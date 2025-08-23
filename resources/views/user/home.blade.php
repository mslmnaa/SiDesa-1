@extends('layouts.app')

@section('title', 'BUMDes Marketplace - Produk Lokal Desa')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-primary-500 to-primary-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12 sm:py-16 md:py-20">
        <div class="text-center">
            @if($hero)
                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-6xl font-bold mb-4 sm:mb-6 leading-tight">{{ $hero->title }}</h1>
                <p class="text-base sm:text-lg md:text-xl lg:text-2xl mb-6 sm:mb-8 max-w-3xl mx-auto leading-relaxed px-2">{{ $hero->content }}</p>
            @else
                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-6xl font-bold mb-4 sm:mb-6 leading-tight">BUMDes Marketplace</h1>
                <p class="text-base sm:text-lg md:text-xl lg:text-2xl mb-6 sm:mb-8 max-w-3xl mx-auto leading-relaxed px-2">
                    Temukan dan beli produk lokal berkualitas langsung dari desa
                </p>
            @endif
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 px-4">
                <a href="{{ route('products.index') }}" class="w-full sm:w-auto bg-white text-primary-500 px-6 sm:px-8 py-3 rounded-lg font-semibold hover:bg-cream transition-colors text-center">
                    Lihat Produk
                </a>
                @guest
                    <a href="{{ route('register') }}" class="w-full sm:w-auto border-2 border-white text-white px-6 sm:px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary-500 transition-colors text-center">
                        Daftar Sekarang
                    </a>
                @endguest
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
@if($categories->count() > 0)
<section class="py-12 sm:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8 sm:mb-12">
            <h2 class="text-2xl sm:text-3xl font-bold text-secondary-800 mb-3 sm:mb-4">Kategori Produk</h2>
            <p class="text-secondary-600 text-sm sm:text-base">Jelajahi berbagai kategori produk lokal kami</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-4 lg:gap-6">
            @foreach($categories as $category)
                <a href="{{ route('products.category', $category) }}" class="group">
                    <div class="bg-light rounded-lg p-3 sm:p-4 lg:p-6 text-center hover:bg-primary-50 transition-colors">
                        @if($category->image)
                            <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="w-12 h-12 sm:w-14 sm:h-14 lg:w-16 lg:h-16 mx-auto mb-2 sm:mb-3 lg:mb-4 rounded-full object-cover">
                        @else
                            <div class="w-12 h-12 sm:w-14 sm:h-14 lg:w-16 lg:h-16 mx-auto mb-2 sm:mb-3 lg:mb-4 rounded-full bg-primary-100 flex items-center justify-center">
                                <svg class="w-6 h-6 sm:w-7 sm:h-7 lg:w-8 lg:h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        @endif
                        <h3 class="font-semibold text-secondary-800 group-hover:text-primary-500 text-sm sm:text-base truncate">{{ $category->name }}</h3>
                        <p class="text-xs sm:text-sm text-secondary-500 mt-1">{{ $category->products_count ?? $category->products->count() }} produk</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Featured Products Section -->
@if($featuredProducts->count() > 0)
<section class="py-12 sm:py-16 bg-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8 sm:mb-12">
            <h2 class="text-2xl sm:text-3xl font-bold text-secondary-800 mb-3 sm:mb-4">Produk Unggulan</h2>
            <p class="text-secondary-600 text-sm sm:text-base">Produk terpilih dari berbagai desa</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4 lg:gap-6">
            @foreach($featuredProducts as $product)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg hover:border-gray-200 transition-all duration-300 group">
                    <!-- Product Image -->
                    <div class="relative overflow-hidden">
                        <a href="{{ route('products.show', $product) }}" class="block">
                            @if($product->images && count($product->images) > 0)
                                <img src="{{ $product->getImageDataUri(0) }}" alt="{{ $product->name }}" 
                                     class="w-full h-40 sm:h-48 lg:h-52 object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-40 sm:h-48 lg:h-52 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center group-hover:from-gray-200 group-hover:to-gray-300 transition-colors duration-300">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </a>
                        
                        <!-- Category Badge -->
                        <div class="absolute top-2 left-2">
                            <span class="text-xs font-medium text-green-700 bg-green-100 bg-opacity-90 backdrop-blur-sm px-2 py-1 rounded-full">
                                {{ Str::limit($product->category->name, 12) }}
                            </span>
                        </div>
                        
                        <!-- Stock Badge -->
                        @if($product->stock <= 5)
                            <div class="absolute top-2 right-2">
                                <span class="text-xs font-medium text-red-700 bg-red-100 bg-opacity-90 backdrop-blur-sm px-2 py-1 rounded-full">
                                    Stok {{ $product->stock }}
                                </span>
                            </div>
                        @endif

                        <!-- Featured Badge -->
                        <div class="absolute bottom-2 left-2">
                            <span class="text-xs font-medium text-yellow-700 bg-yellow-100 bg-opacity-90 backdrop-blur-sm px-2 py-1 rounded-full flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                Featured
                            </span>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-3 sm:p-4">
                        <!-- Product Name -->
                        <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 text-sm sm:text-base leading-tight">
                            <a href="{{ route('products.show', $product) }}" class="hover:text-green-600 transition-colors">
                                {{ $product->name }}
                            </a>
                        </h3>
                        
                        <!-- Product Description -->
                        <p class="text-gray-600 text-xs sm:text-sm mb-3 line-clamp-2 leading-relaxed">
                            {{ Str::limit($product->description, 80) }}
                        </p>
                        
                        <!-- Price -->
                        <div class="mb-3">
                            <span class="text-lg sm:text-xl font-bold text-green-600">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        </div>
                        
                        <!-- Action Button -->
                        <div>
                            @auth
                                <form action="{{ route('user.cart.add') }}" method="POST" class="w-full">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="w-full bg-green-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                        Tambah ke Keranjang
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="w-full bg-green-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-green-700 transition-all duration-200 text-center flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    Tambah ke Keranjang
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-8 sm:mt-12">
            <a href="{{ route('products.index') }}" class="w-full sm:w-auto bg-primary-500 text-white px-6 sm:px-8 py-3 rounded-lg font-semibold hover:bg-primary-600 transition-colors inline-block">
                Lihat Semua Produk
            </a>
        </div>
    </div>
</section>
@endif

<!-- About Us Section -->
@if($aboutUs)
<section class="py-12 sm:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="text-center max-w-3xl mx-auto">
            <h2 class="text-2xl sm:text-3xl font-bold text-secondary-800 mb-3 sm:mb-4">{{ $aboutUs->title }}</h2>
            <p class="text-secondary-600 text-sm sm:text-base lg:text-lg leading-relaxed">{{ $aboutUs->content }}</p>
        </div>
    </div>
</section>
@endif
@endsection