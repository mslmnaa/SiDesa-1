@extends('layouts.app')

@section('title', 'BUMDes Marketplace - Produk Lokal Berkualitas Dari Desa')

@section('content')
    <!-- Hero Slider Section -->
    <section class="py-8 bg-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Slider (2/3 width) -->
                <div class="lg:col-span-2">
                    <div class="bg-gradient-to-br from-primary-100 to-primary-50 rounded-nest p-8 lg:p-12 relative overflow-hidden h-full min-h-[400px]">
                        <div class="relative z-10">
                            <h1 class="text-4xl lg:text-5xl font-bold text-secondary-800 mb-4">
                                Produk Desa<br>
                                <span class="text-primary-500">Berkualitas Tinggi</span>
                            </h1>
                            <p class="text-lg text-gray-600 mb-6 max-w-md">
                                Dukung ekonomi lokal dengan berbelanja produk segar langsung dari desa
                            </p>
                            <form action="{{ route('products.index') }}" method="GET" class="max-w-md">
                                <div class="flex bg-white rounded-full shadow-lg overflow-hidden">
                                    <input type="email"
                                           name="newsletter_email"
                                           placeholder="Email anda untuk newsletter..."
                                           class="flex-1 px-6 py-3 border-0 focus:ring-0">
                                    <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white px-8 py-3 font-semibold transition-colors">
                                        Subscribe
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="absolute right-0 bottom-0 w-64 h-64 opacity-20">
                            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#3BB77E" d="M44.7,-76.4C58.8,-69.2,71.8,-59.1,79.6,-45.8C87.4,-32.6,90,-16.3,88.5,-0.9C87,14.6,81.4,29.2,73.1,42.3C64.8,55.4,53.8,67,40.4,74.3C27,81.6,11.2,84.6,-4.8,83.9C-20.8,83.2,-41.6,78.8,-57.3,69.1C-73,59.4,-83.6,44.4,-88.9,27.7C-94.2,11,-94.2,-7.4,-88.7,-23.5C-83.2,-39.6,-72.2,-53.4,-58.5,-60.8C-44.8,-68.2,-29.4,-69.2,-14.8,-70.8C-0.2,-72.4,13.6,-74.6,27.7,-74.1C41.8,-73.6,56.2,-70.4,44.7,-76.4Z" transform="translate(100 100)" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Side Banners (1/3 width) -->
                <div class="space-y-6">
                    <div class="bg-cream rounded-nest p-6 relative overflow-hidden h-[190px]">
                        <div class="relative z-10">
                            <h3 class="text-xl font-bold text-secondary-800 mb-2">Delivered to<br>your home</h3>
                            <a href="{{ route('products.index') }}" class="inline-block bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-md text-sm font-semibold mt-2 transition-colors">
                                Shop Now →
                            </a>
                        </div>
                    </div>
                    <div class="bg-pink-50 rounded-nest p-6 relative overflow-hidden h-[190px]">
                        <div class="relative z-10">
                            <h3 class="text-xl font-bold text-secondary-800 mb-2">Everyday Fresh &<br>Clean Products</h3>
                            <a href="{{ route('products.index') }}" class="inline-block bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-md text-sm font-semibold mt-2 transition-colors">
                                Shop Now →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    @if($categories->count() > 0)
        <section class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-secondary-800">Featured Categories</h2>
                    <div class="flex space-x-4 text-sm font-semibold text-gray-600">
                        <button class="hover:text-primary-500 transition-colors">All</button>
                        <button class="text-primary-500">Milks and Dairies</button>
                        <button class="hover:text-primary-500 transition-colors">Fresh Fruits</button>
                        <button class="hover:text-primary-500 transition-colors">Vegetables</button>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                    @foreach($featuredProducts->take(12) as $product)
                        <div class="product-card-nest group relative">
                            <!-- Discount Badge -->
                            @if($loop->index % 3 == 0)
                                <span class="absolute top-3 left-3 bg-nest-red text-white text-xs font-bold px-2 py-1 rounded z-10">
                                    -{{ rand(10, 60) }}%
                                </span>
                            @endif

                            <div class="relative overflow-hidden rounded-t-nest">
                                @if($product->images && count($product->images) > 0)
                                    <img src="{{ $product->getImageDataUri(0) }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="p-4">
                                <div class="text-xs text-gray-500 mb-1">{{ $product->category->name }}</div>
                                <h3 class="font-semibold text-secondary-800 mb-2 line-clamp-2 min-h-[2.5rem]">
                                    <a href="{{ route('products.show', $product) }}" class="hover:text-primary-500 transition-colors">
                                        {{ $product->name }}
                                    </a>
                                </h3>

                                <div class="flex items-center text-yellow-400 mb-2">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                    <span class="text-xs text-gray-500 ml-1">(4.0)</span>
                                </div>

                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        <span class="text-lg font-bold text-primary-500">
                                            Rp{{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                        @if($loop->index % 3 == 0)
                                            <span class="text-xs text-gray-400 line-through ml-1">
                                                Rp{{ number_format($product->price * 1.5, 0, ',', '.') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                @if($product->village)
                                    <div class="flex items-center text-xs text-gray-500 mb-3">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        </svg>
                                        <span class="truncate">{{ $product->village->name }}</span>
                                    </div>
                                @endif

                                <button class="w-full bg-primary-50 hover:bg-primary-500 text-primary-500 hover:text-white font-semibold py-2 rounded-md transition-colors text-sm">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    Add
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Daily Best Sells -->
    @if($featuredProducts->count() > 0)
        <section class="py-12 bg-light">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-secondary-800">Daily Best Sells</h2>
                    <div class="flex space-x-4 text-sm font-semibold">
                        <button class="text-primary-500">All</button>
                        <button class="text-gray-600 hover:text-primary-500">Deals Of the Day</button>
                        <button class="text-gray-600 hover:text-primary-500">Beauty</button>
                        <button class="text-gray-600 hover:text-primary-500">Bread & Juice</button>
                        <button class="text-gray-600 hover:text-primary-500">Drinks</button>
                        <button class="text-gray-600 hover:text-primary-500">Milks</button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                    <!-- Left Banner -->
                    <div class="bg-gradient-to-br from-primary-100 to-primary-50 rounded-nest p-8 flex flex-col justify-center">
                        <h3 class="text-3xl font-bold text-secondary-800 mb-4">
                            Bring nature<br>into your<br>home
                        </h3>
                        <a href="{{ route('products.index') }}" class="inline-block bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-md text-sm font-semibold transition-colors w-fit">
                            Shop Now →
                        </a>
                    </div>

                    <!-- Products -->
                    @foreach($featuredProducts->take(4) as $product)
                        <div class="product-card-nest group">
                            @if($loop->index == 0)
                                <span class="absolute top-3 left-3 bg-primary-500 text-white text-xs font-bold px-2 py-1 rounded z-10">
                                    -13%
                                </span>
                            @elseif($loop->index == 1)
                                <span class="absolute top-3 left-3 bg-nest-red text-white text-xs font-bold px-2 py-1 rounded z-10">
                                    -8%
                                </span>
                            @elseif($loop->index == 2)
                                <span class="absolute top-3 left-3 bg-nest-blue text-white text-xs font-bold px-2 py-1 rounded z-10">
                                    New
                                </span>
                            @endif

                            <div class="relative overflow-hidden rounded-t-nest">
                                @if($product->images && count($product->images) > 0)
                                    <img src="{{ $product->getImageDataUri(0) }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="p-4">
                                <div class="text-xs text-gray-500 mb-1">{{ $product->category->name }}</div>
                                <h3 class="font-semibold text-secondary-800 mb-2 line-clamp-2 min-h-[2.5rem]">
                                    <a href="{{ route('products.show', $product) }}" class="hover:text-primary-500">
                                        {{ $product->name }}
                                    </a>
                                </h3>

                                <div class="flex items-center text-yellow-400 mb-2">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>

                                <div class="mb-2">
                                    <span class="text-lg font-bold text-primary-500">
                                        Rp{{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                    <span class="text-xs text-gray-400 line-through ml-1">
                                        Rp{{ number_format($product->price * 1.2, 0, ',', '.') }}
                                    </span>
                                </div>

                                <!-- Progress Bar -->
                                <div class="mb-3">
                                    <div class="flex justify-between text-xs text-gray-600 mb-1">
                                        <span>Sold: {{ rand(50, 200) }}/{{ rand(200, 400) }}</span>
                                        <span>{{ rand(40, 90) }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-primary-500 h-2 rounded-full" style="width: {{ rand(40, 90) }}%"></div>
                                    </div>
                                </div>

                                <button class="w-full bg-primary-500 hover:bg-primary-600 text-white font-semibold py-2 rounded-md transition-colors text-sm">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    Add to cart
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Deals Of The Day (with countdown) -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-secondary-800 mb-8">Deals Of The Day</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredProducts->take(4) as $product)
                    <div class="bg-white rounded-nest border border-gray-200 overflow-hidden hover:shadow-nest-hover transition-all">
                        @if($product->images && count($product->images) > 0)
                            <img src="{{ $product->getImageDataUri(0) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-100"></div>
                        @endif

                        <div class="p-4">
                            <!-- Countdown Timer -->
                            <div class="flex justify-between mb-4 text-center">
                                <div>
                                    <div class="bg-primary-50 rounded-lg p-2 w-12">
                                        <div class="text-lg font-bold text-secondary-800">{{ rand(100, 300) }}</div>
                                        <div class="text-xs text-gray-600">Days</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="bg-primary-50 rounded-lg p-2 w-12">
                                        <div class="text-lg font-bold text-secondary-800">{{ rand(1, 23) }}</div>
                                        <div class="text-xs text-gray-600">Hours</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="bg-primary-50 rounded-lg p-2 w-12">
                                        <div class="text-lg font-bold text-secondary-800">{{ rand(1, 59) }}</div>
                                        <div class="text-xs text-gray-600">Mins</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="bg-primary-50 rounded-lg p-2 w-12">
                                        <div class="text-lg font-bold text-secondary-800">{{ rand(1, 59) }}</div>
                                        <div class="text-xs text-gray-600">Secs</div>
                                    </div>
                                </div>
                            </div>

                            <h3 class="font-semibold text-secondary-800 mb-2">
                                <a href="{{ route('products.show', $product) }}" class="hover:text-primary-500">
                                    {{ $product->name }}
                                </a>
                            </h3>

                            @if($product->village)
                                <p class="text-xs text-gray-500 mb-2">By {{ $product->village->name }}</p>
                            @endif

                            <div class="flex items-center justify-between">
                                <span class="text-lg font-bold text-primary-500">
                                    Rp{{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                <span class="text-xs text-gray-400 line-through">
                                    Rp{{ number_format($product->price * 1.3, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 4 Tabs: Top Selling, Trending, Recently Added, Top Rated -->
    <section class="py-12 bg-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                @php
                    $tabs = [
                        ['title' => 'Top Selling', 'products' => $featuredProducts->take(3)],
                        ['title' => 'Trending Products', 'products' => $featuredProducts->skip(3)->take(3)],
                        ['title' => 'Recently added', 'products' => $featuredProducts->skip(6)->take(3)],
                        ['title' => 'Top Rated', 'products' => $featuredProducts->skip(9)->take(3)],
                    ];
                @endphp

                @foreach($tabs as $tab)
                    <div>
                        <h3 class="text-xl font-bold text-secondary-800 mb-4">{{ $tab['title'] }}</h3>
                        <div class="space-y-4">
                            @foreach($tab['products'] as $product)
                                <div class="flex gap-3 bg-white p-3 rounded-lg hover:shadow-md transition-shadow">
                                    <div class="w-20 h-20 flex-shrink-0">
                                        @if($product->images && count($product->images) > 0)
                                            <img src="{{ $product->getImageDataUri(0) }}"
                                                 alt="{{ $product->name }}"
                                                 class="w-full h-full object-cover rounded">
                                        @else
                                            <div class="w-full h-full bg-gray-100 rounded"></div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-sm text-secondary-800 line-clamp-2 mb-1">
                                            <a href="{{ route('products.show', $product) }}" class="hover:text-primary-500">
                                                {{ $product->name }}
                                            </a>
                                        </h4>
                                        <div class="flex items-center text-yellow-400 mb-1">
                                            @for($i = 0; $i < 5; $i++)
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-primary-500 font-bold">
                                                Rp{{ number_format($product->price, 0, ',', '.') }}
                                            </span>
                                            <span class="text-xs text-gray-400 line-through">
                                                Rp{{ number_format($product->price * 1.2, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-16 bg-gradient-to-r from-primary-100 to-primary-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-8 items-center">
                <div>
                    <h2 class="text-3xl lg:text-4xl font-bold text-secondary-800 mb-4">
                        Stay home & get your daily<br>needs from our shop
                    </h2>
                    <p class="text-gray-600 mb-6">Start Your Daily Shopping with Nest Mart</p>
                    <form class="max-w-md">
                        <div class="flex bg-white rounded-full shadow-lg overflow-hidden">
                            <input type="email"
                                   placeholder="Your email address"
                                   class="flex-1 px-6 py-3 border-0 focus:ring-0">
                            <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white px-8 py-3 font-semibold transition-colors">
                                Subscribe
                            </button>
                        </div>
                    </form>
                </div>
                <div class="hidden lg:block">
                    <!-- Delivery man illustration placeholder -->
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-secondary-800">Best prices & offers</h4>
                        <p class="text-sm text-gray-600">Orders $50 or more</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-secondary-800">Free delivery</h4>
                        <p class="text-sm text-gray-600">24/7 amazing services</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-secondary-800">Great daily deal</h4>
                        <p class="text-sm text-gray-600">When you sign up</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-secondary-800">Wide assortment</h4>
                        <p class="text-sm text-gray-600">Mega Discounts</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-secondary-800">Easy returns</h4>
                        <p class="text-sm text-gray-600">Within 30 days</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
