<?php

namespace App\Http\Controllers\User\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Order\Cart;
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
        $cartItems = Cart::where('user_id', auth()->id())
            ->with(['product.village'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart.index')
                ->with('error', 'Keranjang Anda kosong');
        }

        // Group cart items by village
        $groupedByVillage = $cartItems->groupBy('product.village_id');

        return view('user.orders.checkout', compact('cartItems', 'groupedByVillage'));
    }

    /**
     * Process checkout and create order
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|string',
            'customer_notes' => 'nullable|string',
        ]);

        $cartItems = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart.index')
                ->with('error', 'Keranjang Anda kosong');
        }

        DB::beginTransaction();

        try {
            // Calculate total
            $totalAmount = $cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });

            // Create order
            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'user_id' => auth()->id(),
                'total_amount' => $totalAmount,
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

            // Clear cart
            Cart::where('user_id', auth()->id())->delete();

            DB::commit();

            return redirect()->route('user.orders.show', $order)
                ->with('success', 'Order berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Gagal membuat order: ' . $e->getMessage());
        }
    }

    /**
     * Upload payment proof
     */
    public function uploadPaymentProof(Request $request, Order $order)
    {
        // Pastikan order milik user yang login
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('payment_proof')) {
            $image = $request->file('payment_proof');
            $compressedImage = \App\Models\Product\Product::compressImage($image);

            $order->update([
                'payment_proof' => $compressedImage,
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);
        }

        return redirect()->back()
            ->with('success', 'Bukti pembayaran berhasil diupload');
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
