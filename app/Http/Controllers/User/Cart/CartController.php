<?php

namespace App\Http\Controllers\User\Cart;

use App\Http\Controllers\Controller;
use App\Models\Order\Cart;
use App\Models\Product\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = auth()->user()->carts()->with('product.category')->get();
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
        
        return view('user.cart.index', compact('cartItems', 'total'));
    }
    
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1|max:100'
        ]);
        
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;
        
        // Check stock availability
        if ($product->stock < $quantity) {
            return back()->with('error', 'Stok produk tidak mencukupi. Stok tersedia: ' . $product->stock);
        }
        
        // Check if product is active
        if ($product->status !== 'active') {
            return back()->with('error', 'Produk ini sedang tidak tersedia.');
        }
        
        $cart = Cart::where('user_id', auth()->id())
                   ->where('product_id', $product->id)
                   ->first();
                   
        if ($cart) {
            // Update existing cart item
            $newQuantity = $cart->quantity + $quantity;
            
            if ($newQuantity > $product->stock) {
                return back()->with('error', 'Total quantity melebihi stok yang tersedia. Stok tersedia: ' . $product->stock);
            }
            
            $cart->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $quantity
            ]);
        }
        
        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }
    
    public function update(Request $request, Cart $cart)
    {
        // Ensure cart belongs to current user
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }
        
        $request->validate([
            'quantity' => 'required|integer|min:1|max:100'
        ]);
        
        $product = $cart->product;
        
        if ($request->quantity > $product->stock) {
            return back()->with('error', 'Quantity melebihi stok yang tersedia. Stok tersedia: ' . $product->stock);
        }
        
        $cart->update(['quantity' => $request->quantity]);
        
        return back()->with('success', 'Keranjang berhasil diperbarui!');
    }
    
    public function remove(Cart $cart)
    {
        // Ensure cart belongs to current user
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }
        
        $cart->delete();
        
        return back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
}
