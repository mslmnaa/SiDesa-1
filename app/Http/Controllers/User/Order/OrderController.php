<?php

namespace App\Http\Controllers\User\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Order\Cart;
use App\Models\ShippingAddress;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display user's orders
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items.village')
            ->latest()
            ->paginate(10);

        return view('user.orders.index', compact('orders'));
    }

    /**
     * Show order detail
     */
    public function show(Order $order)
    {
        // Pastikan order milik user yang login
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke order ini');
        }

        $order->load(['items.product', 'items.village']);

        return view('user.orders.show', compact('order'));
    }

    /**
     * Checkout from cart
     */
    public function checkout()
    {
        // Hanya ambil item yang selected
        $cartItems = Cart::where('user_id', auth()->id())
            ->where('is_selected', true)
            ->with(['product.village'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart.index')
                ->with('error', 'Tidak ada produk yang dipilih untuk checkout. Silakan pilih produk terlebih dahulu.');
        }

        // Check if any selected product's village hasn't configured shipping location
        $unConfiguredVillages = $cartItems->filter(function ($item) {
            return !$item->product->village->origin_city_id;
        });

        if ($unConfiguredVillages->isNotEmpty()) {
            $villageNames = $unConfiguredVillages->pluck('product.village.name')->unique()->implode(', ');
            return redirect()->route('user.cart.index')
                ->with('error', 'Tidak dapat checkout. Desa berikut belum mengatur lokasi pengiriman: ' . $villageNames . '. Silakan hapus produk dari desa tersebut atau tunggu hingga desa mengatur lokasi pengiriman.');
        }

        // Group cart items by village
        $groupedByVillage = $cartItems->groupBy('product.village_id');

        // Prepare villages origin data for shipping calculation
        $villagesOrigin = $groupedByVillage->map(function ($items, $villageId) {
            $village = $items->first()->product->village;

            // Skip if village not found
            if (!$village) {
                return null;
            }

            return [
                'village_id' => $villageId,
                'village_name' => $village->name,
                'origin_city_id' => $village->origin_city_id,
                'origin_city_name' => $village->origin_city_name,
                'total_weight' => $items->sum(function ($item) {
                    return $item->quantity * ($item->product->weight ?? 1000); // default 1kg if no weight
                }),
                'has_origin' => !empty($village->origin_city_id) // Check if origin is set
            ];
        })->filter()->values(); // Filter out null values

        return view('user.orders.checkout', compact('cartItems', 'groupedByVillage', 'villagesOrigin'));
    }

    /**
     * Process checkout and create order
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|string',
            'customer_notes' => 'nullable|string',
            // Shipping address validation
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'province_id' => 'required|string',
            'province_name' => 'required|string',
            'city_id' => 'required|string',
            'city_name' => 'required|string',
            'district' => 'nullable|string|max:255',
            'postal_code' => 'required|string|max:10',
            'full_address' => 'required|string',
            // Shipping service validation
            'shipping_cost' => 'required|integer|min:0',
            'shipping_service' => 'required|string',
            'shipping_etd' => 'nullable|string',
        ]);

        // Hanya ambil item yang selected
        $cartItems = Cart::where('user_id', auth()->id())
            ->where('is_selected', true)
            ->with(['product.village'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart.index')
                ->with('error', 'Tidak ada produk yang dipilih untuk checkout');
        }

        // Validate shipping location is configured for all villages
        $unConfiguredVillages = $cartItems->filter(function ($item) {
            return !$item->product->village->origin_city_id;
        });

        if ($unConfiguredVillages->isNotEmpty()) {
            $villageNames = $unConfiguredVillages->pluck('product.village.name')->unique()->implode(', ');
            return redirect()->route('user.cart.index')
                ->with('error', 'Tidak dapat melakukan checkout. Desa berikut belum mengatur lokasi pengiriman: ' . $villageNames);
        }

        DB::beginTransaction();

        try {
            // Create shipping address
            $shippingAddress = ShippingAddress::create([
                'user_id' => auth()->id(),
                'label' => 'Order Address',
                'recipient_name' => $validated['recipient_name'],
                'phone' => $validated['phone'],
                'province_id' => $validated['province_id'],
                'province_name' => $validated['province_name'],
                'city_id' => $validated['city_id'],
                'city_name' => $validated['city_name'],
                'district' => $validated['district'],
                'postal_code' => $validated['postal_code'],
                'full_address' => $validated['full_address'],
                'is_default' => false,
            ]);

            // Calculate total (products + shipping)
            $productTotal = $cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });
            $totalAmount = $productTotal + $validated['shipping_cost'];

            // Create order
            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'user_id' => auth()->id(),
                'shipping_address_id' => $shippingAddress->id,
                'total_amount' => $totalAmount,
                'shipping_cost' => $validated['shipping_cost'],
                'shipping_service' => $validated['shipping_service'],
                'shipping_etd' => $validated['shipping_etd'],
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'payment_method' => $validated['payment_method'],
                'customer_notes' => $validated['customer_notes'] ?? null,
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'village_id' => $cartItem->product->village_id,
                    'product_name' => $cartItem->product->name,
                    'price' => $cartItem->product->price,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $cartItem->quantity * $cartItem->product->price,
                ]);

                // Reduce stock
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            // Clear hanya cart items yang selected (yang sudah di-checkout)
            Cart::where('user_id', auth()->id())
                ->where('is_selected', true)
                ->delete();

            // Generate Midtrans Snap Token if payment method is midtrans
            if ($validated['payment_method'] === 'midtrans') {
                try {
                    $midtransService = new MidtransService();
                    $snapToken = $midtransService->createTransaction($order);

                    $order->update([
                        'midtrans_snap_token' => $snapToken,
                        'midtrans_order_id' => $order->order_number,
                    ]);
                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect()->back()
                        ->with('error', 'Gagal membuat pembayaran: ' . $e->getMessage());
                }
            }

            DB::commit();

            // Redirect to payment page if using Midtrans
            if ($validated['payment_method'] === 'midtrans') {
                return redirect()->route('user.payment.show', $order);
            }

            return redirect()->route('user.orders.show', $order)
                ->with('success', 'Order berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Gagal membuat order: ' . $e->getMessage());
        }
    }


    /**
     * Generate unique order number
     */
    private function generateOrderNumber()
    {
        $prefix = 'ORD';
        $date = date('Ymd');
        $random = strtoupper(substr(md5(uniqid()), 0, 6));

        return $prefix . $date . $random;
    }
}
