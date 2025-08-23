@extends('layouts.app')

@section('title', 'Keranjang Belanja - BUMDes Marketplace')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Keranjang Belanja</h1>
            <p class="text-gray-600 mt-2 text-sm sm:text-base">Kelola produk yang akan Anda beli</p>
        </div>

        @if($cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="px-6 py-4 border-b">
                            <h2 class="text-lg font-semibold text-gray-900">Produk dalam Keranjang</h2>
                        </div>
                        
                        <div class="divide-y divide-gray-200">
                            @foreach($cartItems as $item)
                                <div class="p-4 sm:p-6">
                                    <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                                        <!-- Product Image & Info -->
                                        <div class="flex items-start space-x-3 sm:space-x-4 flex-1">
                                            <!-- Product Image -->
                                            <div class="flex-shrink-0">
                                                <a href="{{ route('products.show', $item->product) }}">
                                                    @if($item->product->images && count($item->product->images) > 0)
                                                        <img src="{{ $item->product->getImageDataUri(0) }}" 
                                                             alt="{{ $item->product->name }}" 
                                                             class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded-lg">
                                                    @else
                                                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                                            <svg class="w-6 h-6 sm:w-8 sm:h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </a>
                                            </div>
                                            
                                            <!-- Product Info -->
                                            <div class="flex-1 min-w-0">
                                                <h3 class="font-semibold text-gray-900 mb-1 text-sm sm:text-base">
                                                    <a href="{{ route('products.show', $item->product) }}" class="hover:text-green-600 line-clamp-2">
                                                        {{ $item->product->name }}
                                                    </a>
                                                </h3>
                                                <p class="text-xs sm:text-sm text-gray-500 mb-1">{{ $item->product->category->name }}</p>
                                                <p class="text-sm sm:text-lg font-bold text-green-600">
                                                    Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                                </p>
                                                <p class="text-xs sm:text-sm text-gray-500">Stok: {{ $item->product->stock }}</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Mobile Controls -->
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
                                            <!-- Quantity Controls -->
                                            <div class="flex items-center justify-between sm:justify-start">
                                                <form action="{{ route('user.cart.update', $item) }}" method="POST" class="flex items-center space-x-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="flex items-center border rounded">
                                                        <button type="button" onclick="decrementQuantity({{ $item->id }})" 
                                                                class="bg-gray-100 text-gray-700 px-2 py-1 hover:bg-gray-200 text-sm">-</button>
                                                        <input type="number" id="quantity-{{ $item->id }}" name="quantity" 
                                                               value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                                               class="w-12 px-1 py-1 text-center border-0 focus:outline-none text-sm">
                                                        <button type="button" onclick="incrementQuantity({{ $item->id }})" 
                                                                class="bg-gray-100 text-gray-700 px-2 py-1 hover:bg-gray-200 text-sm">+</button>
                                                    </div>
                                                    <button type="submit" class="bg-blue-600 text-white px-2 py-1 rounded text-xs hover:bg-blue-700">
                                                        Update
                                                    </button>
                                                </form>
                                            </div>
                                            
                                            <!-- Subtotal & Remove -->
                                            <div class="flex items-center justify-between sm:flex-col sm:items-end">
                                                <p class="text-base sm:text-lg font-bold text-gray-900">
                                                    Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}
                                                </p>
                                                <form action="{{ route('user.cart.remove', $item) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus produk ini dari keranjang?')" 
                                                            class="text-red-600 hover:text-red-800 text-xs sm:text-sm font-medium">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6 lg:sticky lg:top-8">
                        <h2 class="text-base sm:text-lg font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h2>
                        
                        <div class="space-y-2 sm:space-y-3 mb-4">
                            <div class="flex justify-between text-sm sm:text-base">
                                <span class="text-gray-600">Subtotal ({{ $cartItems->count() }} item)</span>
                                <span class="font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-xs sm:text-sm text-gray-500">
                                <span>Ongkos Kirim</span>
                                <span>Dihitung di checkout</span>
                            </div>
                            <hr>
                            <div class="flex justify-between text-base sm:text-lg font-bold">
                                <span>Total</span>
                                <span class="text-green-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="space-y-2 sm:space-y-3">
                            <a href="{{ route('user.checkout') }}" 
                               class="w-full bg-green-600 text-white py-2 sm:py-3 px-4 rounded-lg font-semibold hover:bg-green-700 transition-colors text-center block text-sm sm:text-base">
                                Lanjut ke Checkout
                            </a>
                            <a href="{{ route('products.index') }}" 
                               class="w-full border border-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-50 transition-colors text-center block text-sm sm:text-base">
                                Lanjut Belanja
                            </a>
                        </div>

                        <!-- Cart Info -->
                        <div class="mt-4 sm:mt-6 p-3 sm:p-4 bg-blue-50 rounded-lg">
                            <h3 class="font-semibold text-blue-900 mb-2 text-sm sm:text-base">Info Belanja</h3>
                            <ul class="text-xs sm:text-sm text-blue-800 space-y-1 leading-relaxed">
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