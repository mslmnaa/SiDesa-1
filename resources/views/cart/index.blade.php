@extends('layouts.app')

@section('title', 'Keranjang Belanja - BUMDes Marketplace')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Keranjang Belanja</h1>
            <p class="text-gray-600 mt-2">Kelola produk yang akan Anda beli</p>
        </div>

        @if($cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="px-6 py-4 border-b">
                            <h2 class="text-lg font-semibold text-gray-900">Produk dalam Keranjang</h2>
                        </div>
                        
                        <div class="divide-y divide-gray-200">
                            @foreach($cartItems as $item)
                                <div class="p-6">
                                    <div class="flex items-center space-x-4">
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0">
                                            <a href="{{ route('products.show', $item->product) }}">
                                                @if($item->product->images && count($item->product->images) > 0)
                                                    <img src="{{ Storage::url($item->product->images[0]) }}" 
                                                         alt="{{ $item->product->name }}" 
                                                         class="w-20 h-20 object-cover rounded-lg">
                                                @else
                                                    <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </a>
                                        </div>
                                        
                                        <!-- Product Info -->
                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-semibold text-gray-900 mb-1">
                                                <a href="{{ route('products.show', $item->product) }}" class="hover:text-green-600">
                                                    {{ $item->product->name }}
                                                </a>
                                            </h3>
                                            <p class="text-sm text-gray-500 mb-2">{{ $item->product->category->name }}</p>
                                            <p class="text-lg font-bold text-green-600">
                                                Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                            </p>
                                            <p class="text-sm text-gray-500">Stok tersedia: {{ $item->product->stock }}</p>
                                        </div>
                                        
                                        <!-- Quantity Controls -->
                                        <div class="flex items-center space-x-2">
                                            <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center space-x-2">
                                                @csrf
                                                @method('PUT')
                                                <div class="flex items-center">
                                                    <button type="button" onclick="decrementQuantity({{ $item->id }})" 
                                                            class="bg-gray-200 text-gray-700 px-2 py-1 rounded-l hover:bg-gray-300">-</button>
                                                    <input type="number" id="quantity-{{ $item->id }}" name="quantity" 
                                                           value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                                           class="w-16 px-2 py-1 text-center border-t border-b border-gray-200 focus:outline-none">
                                                    <button type="button" onclick="incrementQuantity({{ $item->id }})" 
                                                            class="bg-gray-200 text-gray-700 px-2 py-1 rounded-r hover:bg-gray-300">+</button>
                                                </div>
                                                <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                                                    Update
                                                </button>
                                            </form>
                                        </div>
                                        
                                        <!-- Subtotal & Remove -->
                                        <div class="text-right">
                                            <p class="text-lg font-bold text-gray-900 mb-2">
                                                Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}
                                            </p>
                                            <form action="{{ route('cart.remove', $item) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Yakin ingin menghapus produk ini dari keranjang?')" 
                                                        class="text-red-600 hover:text-red-800 text-sm">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-lg p-6 sticky top-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h2>
                        
                        <div class="space-y-3 mb-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal ({{ $cartItems->count() }} item)</span>
                                <span class="font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-500">
                                <span>Ongkos Kirim</span>
                                <span>Akan dihitung di checkout</span>
                            </div>
                            <hr>
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total</span>
                                <span class="text-green-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <a href="{{ route('checkout') }}" 
                               class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-green-700 transition-colors text-center block">
                                Lanjut ke Checkout
                            </a>
                            <a href="{{ route('products.index') }}" 
                               class="w-full border border-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-50 transition-colors text-center block">
                                Lanjut Belanja
                            </a>
                        </div>

                        <!-- Cart Info -->
                        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                            <h3 class="font-semibold text-blue-900 mb-2">Info Belanja</h3>
                            <ul class="text-sm text-blue-800 space-y-1">
                                <li>• Gratis ongkir untuk pembelian di atas Rp 100,000</li>
                                <li>• Produk akan dikemas dengan baik</li>
                                <li>• Chat langsung dengan penjual via WhatsApp</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-12">
                <div class="bg-white rounded-lg shadow-lg p-12">
                    <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M17 13l-1.5 6M9 19.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM20.5 19.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Keranjang Belanja Kosong</h3>
                    <p class="text-gray-600 mb-6">Anda belum menambahkan produk apapun ke keranjang</p>
                    <div class="space-x-4">
                        <a href="{{ route('products.index') }}" 
                           class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors inline-block">
                            Mulai Berbelanja
                        </a>
                        <a href="{{ route('home') }}" 
                           class="border border-gray-300 text-gray-700 px-8 py-3 rounded-lg hover:bg-gray-50 transition-colors inline-block">
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function incrementQuantity(itemId) {
    const input = document.getElementById(`quantity-${itemId}`);
    const max = parseInt(input.getAttribute('max'));
    const current = parseInt(input.value);
    
    if (current < max) {
        input.value = current + 1;
    }
}

function decrementQuantity(itemId) {
    const input = document.getElementById(`quantity-${itemId}`);
    const min = parseInt(input.getAttribute('min'));
    const current = parseInt(input.value);
    
    if (current > min) {
        input.value = current - 1;
    }
}
</script>
@endsection