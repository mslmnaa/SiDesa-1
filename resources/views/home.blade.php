@extends('layouts.app')

@section('title', 'BUMDes Marketplace - Produk Lokal Desa')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-primary-500 to-primary-700 text-white">
    <div class="max-w-7xl mx-auto px-4 py-20">
        <div class="text-center">
            @if($hero)
                <h1 class="text-4xl md:text-6xl font-bold mb-6">{{ $hero->title }}</h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">{{ $hero->content }}</p>
            @else
                <h1 class="text-4xl md:text-6xl font-bold mb-6">BUMDes Marketplace</h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                    Temukan dan beli produk lokal berkualitas langsung dari desa
                </p>
            @endif
            
            <div class="space-x-4">
                <a href="{{ route('products.index') }}" class="bg-white text-primary-500 px-8 py-3 rounded-lg font-semibold hover:bg-cream transition-colors inline-block">
                    Lihat Produk
                </a>
                @guest
                    <a href="{{ route('register') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary-500 transition-colors inline-block">
                        Daftar Sekarang
                    </a>
                @endguest
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
@if($categories->count() > 0)
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-secondary-800 mb-4">Kategori Produk</h2>
            <p class="text-secondary-600">Jelajahi berbagai kategori produk lokal kami</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('products.category', $category) }}" class="group">
                    <div class="bg-light rounded-lg p-6 text-center hover:bg-primary-50 transition-colors">
                        @if($category->image)
                            <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="w-16 h-16 mx-auto mb-4 rounded-full object-cover">
                        @else
                            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-primary-100 flex items-center justify-center">
                                <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        @endif
                        <h3 class="font-semibold text-secondary-800 group-hover:text-primary-500">{{ $category->name }}</h3>
                        <p class="text-sm text-secondary-500 mt-1">{{ $category->products_count ?? $category->products->count() }} produk</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Featured Products Section -->
@if($featuredProducts->count() > 0)
<section class="py-16 bg-light">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-secondary-800 mb-4">Produk Unggulan</h2>
            <p class="text-secondary-600">Produk terpilih dari berbagai desa</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <a href="{{ route('products.show', $product) }}">
                        @if($product->images && count($product->images) > 0)
                            <img src="{{ Storage::url($product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-secondary-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </a>

                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs text-primary-600 bg-primary-100 px-2 py-1 rounded-full">{{ $product->category->name }}</span>
                            <span class="text-xs text-secondary-500">Stok: {{ $product->stock }}</span>
                        </div>
                        
                        <h3 class="font-semibold text-secondary-800 mb-2">
                            <a href="{{ route('products.show', $product) }}" class="hover:text-primary-500">{{ $product->name }}</a>
                        </h3>
                        
                        <p class="text-secondary-600 text-sm mb-3 line-clamp-2">{{ Str::limit($product->description, 100) }}</p>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-primary-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            
                            @auth
                                <form action="{{ route('cart.add') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="bg-primary-500 text-white px-3 py-1 rounded text-sm hover:bg-primary-600 transition-colors">
                                        + Keranjang
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="bg-primary-500 text-white px-3 py-1 rounded text-sm hover:bg-primary-600 transition-colors">
                                    + Keranjang
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('products.index') }}" class="bg-primary-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-600 transition-colors">
                Lihat Semua Produk
            </a>
        </div>
    </div>
</section>
@endif

<!-- About Us Section -->
@if($aboutUs)
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto">
            <h2 class="text-3xl font-bold text-secondary-800 mb-4">{{ $aboutUs->title }}</h2>
            <p class="text-secondary-600 text-lg leading-relaxed">{{ $aboutUs->content }}</p>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-16 bg-primary-500">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Mulai Berbelanja Sekarang</h2>
        <p class="text-primary-100 text-lg mb-8">Dukung produk lokal dan ekonomi desa</p>
        <div class="space-x-4">
            @guest
                <a href="{{ route('register') }}" class="bg-white text-primary-500 px-8 py-3 rounded-lg font-semibold hover:bg-cream transition-colors inline-block">
                    Daftar Gratis
                </a>
                <a href="{{ route('products.index') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary-500 transition-colors inline-block">
                    Jelajahi Produk
                </a>
            @else
                <a href="{{ route('products.index') }}" class="bg-white text-primary-500 px-8 py-3 rounded-lg font-semibold hover:bg-cream transition-colors inline-block">
                    Mulai Berbelanja
                </a>
            @endguest
        </div>
    </div>
</section>
@endsection