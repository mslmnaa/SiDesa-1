@extends('layouts.app')

@section('hero_fullscreen', true)

@section('title', 'BUMDes Marketplace - Produk Lokal Desa')

@section('content')
    <!-- Hero Section - Zilly Style -->
    <section class="bg-white pt-32 pb-6">
        <div class="max-w-[1400px] mx-auto px-6">

            <!-- Hero Banners Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Main Banner -->
                <div class="md:col-span-2 relative bg-white rounded-xl overflow-hidden shadow-sm">
                    <div class="flex items-center justify-between h-80 p-10"
                        style="background: linear-gradient(135deg, #FFF8E7 0%, #FFE4B5 100%);">
                        <div class="flex-1 z-10">
                            <div
                                class="inline-block bg-red-500 text-white text-xs font-semibold px-3 py-1.5 rounded-full mb-4 uppercase tracking-wide">
                                PROMO MINGGU INI
                            </div>
                            <h2 class="text-5xl font-bold text-gray-900 mb-3 leading-tight">
                                <span class="text-green-600">Produk Segar</span><br>
                                <span class="font-semibold">Langsung Dari Desa</span>
                            </h2>
                            <div class="mb-6">
                                <span class="text-3xl font-bold text-orange-600">Mulai Rp 10.000</span>
                            </div>
                            <a href="{{ route('products.index') }}"
                                class="inline-flex items-center bg-green-600 text-white px-8 py-3.5 rounded-full hover:bg-green-700 transition-colors font-semibold text-sm shadow-lg">
                                Belanja Sekarang
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </a>
                        </div>
                        <div class="flex-1 relative h-full hidden md:flex items-end justify-end">
                            <img src="/images/Background Dash.png" alt="Produk Lokal Desa"
                                class="h-full w-auto object-contain">
                        </div>
                    </div>
                </div>

                <!-- Side Banners -->
                <div class="space-y-4">
                    <div class="bg-white rounded-xl p-6 shadow-sm h-[154px] flex items-center justify-center"
                        style="background: linear-gradient(135deg, #FFF5E6 0%, #FFE8CC 100%);">
                        <div>
                            <div class="text-xs text-gray-600 mb-1.5 font-medium uppercase tracking-wide">PRODUK UNGGULAN
                            </div>
                            <div class="text-2xl font-bold text-gray-900 mb-2.5 leading-tight">Kerajinan Tangan</div>
                            <div class="text-xl font-bold text-orange-600">Diskon 20%</div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-sm h-[154px] flex items-center justify-center"
                        style="background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%);">
                        <div>
                            <div class="text-xs text-gray-600 mb-1.5 font-medium uppercase tracking-wide">PENAWARAN TERBATAS
                            </div>
                            <div class="text-2xl font-bold text-gray-900 mb-2.5 leading-tight">Hasil Pertanian</div>
                            <div class="text-xl font-bold text-red-600">Gratis Ongkir</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Icons Row - Zilly Style -->
            @if ($categories->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 mb-6">
                    <div class="grid grid-cols-4 md:grid-cols-8 gap-4">
                        @foreach ($categories->take(8) as $category)
                            <a href="{{ route('products.category', $category) }}" class="flex flex-col items-center group">
                                <div class="relative w-12 h-12 mb-2">
                                    @if ($category->image)
                                        <img src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                                            class="w-full h-full object-contain group-hover:scale-110 transition-transform">
                                    @else
                                        <div class="w-full h-full bg-orange-50 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <h3
                                    class="text-xs font-medium text-gray-700 group-hover:text-green-600 transition-colors text-center line-clamp-1 mb-0.5">
                                    {{ $category->name }}
                                </h3>
                                <p class="text-[10px] text-gray-400">
                                    {{ $category->products_count ?? $category->products->count() }} Produk</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Featured Villages Section - Compact Style -->
    @if ($featuredVillages->count() > 0)
        <section class="py-6 bg-white border-t border-gray-100">
            <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Desa-Desa Kami</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Jelajahi BUMDes dari berbagai desa</p>
                    </div>
                    <a href="{{ route('villages.index') }}"
                        class="text-green-600 hover:text-green-700 font-medium text-xs flex items-center">
                        Lihat Semua
                        <svg class="w-3.5 h-3.5 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                <!-- Villages Grid - Horizontal Scroll on Mobile -->
                <div class="overflow-x-auto -mx-4 px-4 md:mx-0 md:px-0">
                    <div class="flex md:grid md:grid-cols-3 lg:grid-cols-6 gap-3 pb-4 md:pb-0">
                        @foreach ($featuredVillages as $village)
                            <a href="{{ route('villages.show', $village->slug) }}"
                                class="flex-shrink-0 w-40 md:w-auto bg-white rounded-lg border border-gray-200 p-3.5 hover:shadow-md hover:border-green-400 transition-all duration-200 group">
                                <!-- Village Logo -->
                                <div class="flex justify-center mb-2.5">
                                    <div
                                        class="w-14 h-14 rounded-full bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center group-hover:scale-105 transition-transform">
                                        @if ($village->logo)
                                            <img src="{{ asset('storage/' . $village->logo) }}" alt="{{ $village->name }}"
                                                class="w-12 h-12 object-contain rounded-full">
                                        @else
                                            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                </path>
                                            </svg>
                                        @endif
                                    </div>
                                </div>

                                <!-- Village Info -->
                                <h3
                                    class="text-xs font-semibold text-gray-800 mb-0.5 text-center group-hover:text-green-600 transition-colors line-clamp-1">
                                    {{ $village->name }}
                                </h3>
                                <p class="text-[10px] text-gray-500 text-center mb-1.5 line-clamp-1">
                                    {{ $village->district }}
                                </p>
                                <div class="flex items-center justify-center text-green-600 text-[10px]">
                                    <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <span class="font-medium">{{ $village->products_count }} Produk</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Featured Products Section - Zilly Dense Grid -->
    @if ($featuredProducts->count() > 0)
        <section class="py-8 bg-white">
            <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-900">Produk Unggulan</h2>
                        <p class="text-sm text-gray-500 mt-1">Produk terbaik dan paling diminati</p>
                    </div>
                    <a href="{{ route('products.index') }}"
                        class="hidden md:flex text-green-600 hover:text-green-700 font-medium text-sm items-center">
                        Lihat Semua
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                </div>

                <!-- Products Grid - Zilly Style (6 columns desktop) -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
                    @foreach ($featuredProducts as $product)
                        <a href="{{ route('products.show', $product) }}"
                            class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-xl hover:border-green-400 transition-all duration-200 group">
                            <!-- Product Image -->
                            <div class="relative overflow-hidden bg-gray-50">
                                @if ($product->images && count($product->images) > 0)
                                    <img src="{{ $product->getImageDataUri(0) }}" alt="{{ $product->name }}"
                                        class="w-full h-40 sm:h-44 object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div
                                        class="w-full h-40 sm:h-44 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif

                                <!-- Stock Badge -->
                                @if ($product->stock > 0)
                                    <div
                                        class="absolute top-2 right-2 bg-white text-green-600 text-xs px-2 py-1 rounded font-medium shadow-sm">
                                        Tersedia
                                    </div>
                                @else
                                    <div
                                        class="absolute top-2 right-2 bg-white text-red-600 text-xs px-2 py-1 rounded font-medium shadow-sm">
                                        Habis
                                    </div>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="p-3">
                                <!-- Category Badge Small -->
                                <div class="mb-1.5">
                                    <span class="text-[10px] text-gray-500">
                                        {{ $product->category->name }}
                                    </span>
                                </div>

                                <!-- Product Name -->
                                <h3
                                    class="font-normal text-gray-800 mb-2 text-sm leading-tight line-clamp-2 min-h-[2.5rem]">
                                    {{ $product->name }}
                                </h3>

                                <!-- Price with Old Price -->
                                <div class="mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-bold text-gray-900">
                                            Rp{{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                        @if ($product->price > 0)
                                            <span class="text-[10px] text-gray-400 line-through">
                                                Rp{{ number_format($product->price * 1.2, 0, ',', '.') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Rating Stars -->
                                <div class="flex items-center gap-1 mb-2.5">
                                    <div class="flex text-orange-400">
                                        @for ($i = 0; $i < 5; $i++)
                                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                </path>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-[10px] text-gray-400">(5.00)</span>
                                </div>

                                <!-- Add to Cart Button -->
                                @if ($product->stock > 0)
                                    <button
                                        class="w-full bg-gray-50 hover:bg-green-600 text-gray-700 hover:text-white border border-gray-200 hover:border-green-600 rounded-md py-2 text-xs font-medium transition-all duration-200 flex items-center justify-center gap-1.5 group">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                        <span>Tambah</span>
                                    </button>
                                @else
                                    <button disabled
                                        class="w-full bg-gray-100 text-gray-400 border border-gray-200 rounded-md py-2 text-xs font-medium cursor-not-allowed">
                                        Stok Habis
                                    </button>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- View All Button - Mobile -->
                <div class="text-center mt-8">
                    <a href="{{ route('products.index') }}"
                        class="inline-block bg-green-600 text-white px-8 py-3 rounded-full hover:bg-green-700 transition-colors font-semibold text-sm shadow-md">
                        Lihat Semua Produk
                    </a>
                </div>
            </div>
        </section>
    @endif

@endsection
