@extends('layouts.app')

@section('hero_fullscreen', true)

@section('title', 'BUMDes Marketplace - Produk Lokal Desa')

@section('content')
    <!-- Hero Section -->
    <section class="relative text-white overflow-hidden">
        <div class="absolute inset-0">
            <img src="/images/Background Dash.png" alt="Hero Background" class="w-full h-full object-cover object-center">
            <div class="absolute inset-0 bg-gradient-to-r from-green-800/90 via-green-700/80 to-green-600/40"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-24 sm:pt-40 sm:pb-32 lg:pt-48 lg:pb-40">
            <div class="lg:w-1/2 text-center lg:text-left">
                @if ($hero)
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white mb-6 drop-shadow">
                        {{ $hero->title }}
                    </h1>
                    <p class="text-lg sm:text-xl text-green-50 max-w-2xl mx-auto lg:mx-0 mb-8">
                        {{ $hero->content }}
                    </p>
                @else
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white mb-6 drop-shadow">
                        BUMDes Marketplace
                    </h1>
                    <p class="text-lg sm:text-xl text-green-50 max-w-2xl mx-auto lg:mx-0 mb-8">
                        Temukan dan beli produk lokal berkualitas langsung dari desa.
                    </p>
                @endif
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    <a href="{{ route('products.index') }}"
                        class="transform transition duration-300 hover:scale-105 w-full sm:w-auto bg-white text-green-700 px-8 py-3 rounded-full font-bold text-lg shadow-lg hover:bg-green-50">
                        Jelajahi Produk
                    </a>
                    @guest
                        <a href="{{ route('register') }}"
                            class="transform transition duration-300 hover:scale-105 w-full sm:w-auto border-2 border-white text-white px-8 py-3 rounded-full font-bold text-lg hover:bg-white/15 backdrop-blur-sm">
                            Daftar
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    @if ($categories->count() > 0)
        <section class="py-16 sm:py-20 bg-light">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-secondary-800 tracking-tight">Jelajahi Kategori</h2>
                    <p class="mt-4 max-w-2xl mx-auto text-lg text-secondary-600">Temukan produk berdasarkan kategori yang
                        Anda minati.</p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 lg:gap-8">
                    @foreach ($categories as $category)
                        <a href="{{ route('products.category', $category) }}" class="group text-center">
                            <div class="relative w-24 h-24 sm:w-28 sm:h-28 mx-auto">
                                @if ($category->image)
                                    {{-- <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                                        class="w-full h-full rounded-full object-cover shadow-lg group-hover:shadow-xl transition-all duration-300 transform group-hover:scale-110 border-4 border-white"> --}}
                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                                        class="w-full h-full rounded-full object-cover shadow-lg group-hover:shadow-xl transition-all duration-300 transform group-hover:scale-110 border-4 border-white">
                                @else
                                    <div
                                        class="w-full h-full rounded-full bg-primary-100 flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 transform group-hover:scale-110 border-4 border-white">
                                        <svg class="w-10 h-10 text-primary-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <h3
                                class="mt-4 font-bold text-secondary-800 group-hover:text-primary-600 transition-colors text-base sm:text-lg truncate">
                                {{ $category->name }}</h3>
                            <p class="text-sm text-secondary-500">
                                {{ $category->products_count ?? $category->products->count() }} produk</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Featured Products Section -->
    @if ($featuredProducts->count() > 0)
        <section class="py-16 sm:py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-secondary-800 tracking-tight">Produk Unggulan</h2>
                    <p class="mt-4 max-w-2xl mx-auto text-lg text-secondary-600">Produk-produk terbaik dan paling diminati
                        dari desa kami.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach ($featuredProducts as $product)
                        <div
                            class="bg-white rounded-2xl shadow-md overflow-hidden group transition-all duration-300 hover:shadow-2xl hover:-translate-y-2">
                            <div class="relative">
                                <a href="{{ route('products.show', $product) }}" class="block h-56">
                                    @if ($product->images && count($product->images) > 0)
                                        <img src="{{ $product->getImageDataUri(0) }}" alt="{{ $product->name }}"
                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                                    @else
                                        <div
                                            class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                </a>
                                <div class="absolute top-3 left-3">
                                    <span
                                        class="text-xs font-bold text-primary-800 bg-primary-100 px-3 py-1 rounded-full">{{ Str::limit($product->category->name, 15) }}</span>
                                </div>
                                @if ($product->stock <= 5 && $product->stock > 0)
                                    <div class="absolute top-3 right-3">
                                        <span class="text-xs font-bold text-red-800 bg-red-100 px-3 py-1 rounded-full">Stok
                                            Terbatas</span>
                                    </div>
                                @elseif ($product->stock == 0)
                                    <div class="absolute top-3 right-3">
                                        <span
                                            class="text-xs font-bold text-gray-800 bg-gray-200 px-3 py-1 rounded-full">Habis</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-5">
                                <h3 class="font-bold text-lg text-gray-900 mb-2 h-14 overflow-hidden">
                                    <a href="{{ route('products.show', $product) }}"
                                        class="hover:text-primary-600 transition-colors">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 text-sm mb-4 h-10 overflow-hidden">
                                    {{ Str::limit($product->description, 60) }}
                                </p>
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-2xl font-extrabold text-primary-600">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>
                                @auth
                                    <form action="{{ route('user.cart.add') }}" method="POST" class="w-full">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit"
                                            class="w-full bg-primary-600 text-white px-4 py-3 rounded-xl font-bold hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 transition-all duration-300 flex items-center justify-center gap-2 disabled:bg-gray-400"
                                            {{ $product->stock == 0 ? 'disabled' : '' }}>
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                                                </path>
                                            </svg>
                                            <span>{{ $product->stock == 0 ? 'Stok Habis' : 'Tambah Keranjang' }}</span>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="w-full block text-center bg-primary-600 text-white px-4 py-3 rounded-xl font-bold hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 transition-all duration-300">
                                        Login untuk Beli
                                    </a>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-16">
                    <a href="{{ route('products.index') }}"
                        class="transform transition duration-300 hover:scale-105 inline-block bg-secondary-800 text-white px-10 py-4 rounded-full font-bold text-lg shadow-lg hover:bg-secondary-900">
                        Lihat Semua Produk
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- About Us Section -->
    @if ($aboutUs)
        <section class="py-16 sm:py-20 bg-light">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-2xl shadow-lg p-8 sm:p-12 text-center">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-secondary-800 tracking-tight">{{ $aboutUs->title }}
                    </h2>
                    <p class="mt-6 max-w-2xl mx-auto text-lg text-secondary-600 leading-relaxed">{{ $aboutUs->content }}
                    </p>
                    <div class="mt-8">
                        <a href="{{ route('register') }}"
                            class="transform transition duration-300 hover:scale-105 inline-block bg-primary-600 text-white px-8 py-3 rounded-full font-bold text-lg shadow-lg hover:bg-primary-700">
                            Gabung Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
