<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()
            ->with('orderItems.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('orders.index', compact('orders'));
    }
    
    public function show(Order $order)
    {
        // Ensure order belongs to current user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        $order->load('orderItems.product.category');
        
        return view('orders.show', compact('order'));
    }
    
    public function checkout()
    {
        $cartItems = auth()->user()->carts()->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong');
        }
        
        // Check stock availability for all cart items
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->stock) {
                return redirect()->route('cart.index')
                    ->with('error', "Stok {$item->product->name} tidak mencukupi. Stok tersedia: {$item->product->stock}");
            }
            
            if ($item->product->status !== 'active') {
                return redirect()->route('cart.index')
                    ->with('error', "Produk {$item->product->name} sedang tidak tersedia");
            }
        }
        
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
        
        return view('orders.checkout', compact('cartItems', 'total'));
    }
    
    public function placeOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:1000',
            'notes' => 'nullable|string|max:500'
        ]);
        
        $cartItems = auth()->user()->carts()->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong');
        }
        
        DB::beginTransaction();
        
        try {
            // Calculate total
            $total = $cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });
            
            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $total,
                'status' => 'pending',
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes,
            ]);
            
            // Create order items and update stock
            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;
                
                // Double-check stock
                if ($cartItem->quantity > $product->stock) {
                    throw new \Exception("Stok {$product->name} tidak mencukupi");
                }
                
                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $cartItem->quantity,
                    'price' => $product->price
                ]);
                
                // Update product stock
                $product->decrement('stock', $cartItem->quantity);
            }
            
            // Clear cart
            auth()->user()->carts()->delete();
            
            DB::commit();
            
            return redirect()->route('orders.show', $order)
                ->with('success', 'Pesanan berhasil dibuat! Nomor pesanan: ' . $order->order_number);
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }
}
