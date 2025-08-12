@extends('layouts.app')

@section('title', $product->name . ' - BUMDes Marketplace')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-green-600">Beranda</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('products.index') }}" class="ml-1 text-gray-700 hover:text-green-600">Produk</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-gray-500">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Product Detail -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8">
                <!-- Product Images -->
                <div>
                    @if($product->images && count($product->images) > 0)
                        <div class="mb-4">
                            <img id="main-image" src="{{ Storage::url($product->images[0]) }}" alt="{{ $product->name }}" 
                                 class="w-full h-96 object-cover rounded-lg">
                        </div>
                        @if(count($product->images) > 1)
                            <div class="grid grid-cols-4 gap-2">
                                @foreach($product->images as $index => $image)
                                    <img src="{{ Storage::url($image) }}" alt="{{ $product->name }}" 
                                         onclick="changeMainImage('{{ Storage::url($image) }}')"
                                         class="w-full h-20 object-cover rounded cursor-pointer hover:opacity-75 {{ $index === 0 ? 'ring-2 ring-green-500' : '' }}">
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div>
                    <div class="mb-4">
                        <span class="text-sm text-green-600 bg-green-100 px-3 py-1 rounded-full">{{ $product->category->name }}</span>
                    </div>
                    
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                    
                    <div class="flex items-center mb-4">
                        <span class="text-3xl font-bold text-green-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="flex items-center mb-6">
                        <span class="text-sm text-gray-600 mr-4">Stok tersisa: 
                            <span class="font-semibold {{ $product->stock > 10 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $product->stock }} unit
                            </span>
                        </span>
                        <span class="text-sm px-2 py-1 {{ $product->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded">
                            {{ ucfirst($product->status) }}
                        </span>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi Produk</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                    </div>

                    <!-- Add to Cart Form -->
                    @if($product->stock > 0 && $product->status === 'active')
                        @auth
                            <form action="{{ route('cart.add') }}" method="POST" class="mb-6">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                                <div class="flex items-center space-x-4 mb-4">
                                    <label class="text-sm font-medium text-gray-700">Jumlah:</label>
                                    <div class="flex items-center">
                                        <button type="button" onclick="decrementQuantity()" class="bg-gray-200 text-gray-700 px-3 py-1 rounded-l">-</button>
                                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                               class="w-16 px-3 py-1 text-center border-t border-b border-gray-200 focus:outline-none">
                                        <button type="button" onclick="incrementQuantity()" class="bg-gray-200 text-gray-700 px-3 py-1 rounded-r">+</button>
                                    </div>
                                </div>
                                
                                <div class="flex space-x-4">
                                    <button type="submit" class="flex-1 bg-green-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                                        Tambah ke Keranjang
                                    </button>
                                    @if($product->whatsapp_number)
                                        <a href="https://wa.me/{{ $product->whatsapp_number }}?text=Halo, saya tertarik dengan produk {{ $product->name }}" 
                                           target="_blank"
                                           class="flex-1 bg-green-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-600 transition-colors text-center">
                                            Chat Penjual
                                        </a>
                                    @endif
                                </div>
                            </form>
                        @else
                            <div class="mb-6">
                                <p class="text-gray-600 mb-4">Silakan login untuk menambahkan produk ke keranjang</p>
                                <div class="flex space-x-4">
                                    <a href="{{ route('login') }}" class="flex-1 bg-green-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-700 transition-colors text-center">
                                        Login untuk Beli
                                    </a>
                                    @if($product->whatsapp_number)
                                        <a href="https://wa.me/{{ $product->whatsapp_number }}?text=Halo, saya tertarik dengan produk {{ $product->name }}" 
                                           target="_blank"
                                           class="flex-1 bg-green-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-600 transition-colors text-center">
                                            Chat Penjual
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endauth
                    @else
                        <div class="mb-6">
                            <p class="text-red-600 font-semibold">Produk ini sedang tidak tersedia</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Produk Sejenis</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        <div class="bg-gray-50 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                            <a href="{{ route('products.show', $related) }}">
                                @if($related->images && count($related->images) > 0)
                                    <img src="{{ Storage::url($related->images[0]) }}" alt="{{ $related->name }}" class="w-full h-40 object-cover">
                                @else
                                    <div class="w-full h-40 bg-gray-200 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </a>
                            
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-2">
                                    <a href="{{ route('products.show', $related) }}" class="hover:text-green-600">{{ $related->name }}</a>
                                </h3>
                                <p class="text-green-600 font-bold">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function changeMainImage(imageSrc) {
    document.getElementById('main-image').src = imageSrc;
    
    // Update ring styling
    document.querySelectorAll('.grid img').forEach(img => {
        img.classList.remove('ring-2', 'ring-green-500');
    });
    event.target.classList.add('ring-2', 'ring-green-500');
}

function incrementQuantity() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.getAttribute('max'));
    const current = parseInt(input.value);
    
    if (current < max) {
        input.value = current + 1;
    }
}

function decrementQuantity() {
    const input = document.getElementById('quantity');
    const min = parseInt(input.getAttribute('min'));
    const current = parseInt(input.value);
    
    if (current > min) {
        input.value = current - 1;
    }
}
</script>
@endsection