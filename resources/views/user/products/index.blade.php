@extends('layouts.app')

@section('title', 'Semua Produk - BUMDes Marketplace')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-6 sm:py-8 px-4 sm:px-6">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Semua Produk</h1>
            <p class="text-gray-600 mt-2 text-sm sm:text-base">Temukan produk lokal berkualitas dari berbagai desa</p>
        </div>

        <!-- Search & Filter -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6 mb-6 sm:mb-8">
            <form method="GET" action="{{ route('products.index') }}" class="space-y-5" id="searchForm">
                <!-- Search Bar - Full Width -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari produk, kategori, atau deskripsi..."
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 text-sm sm:text-base"
                           id="searchInput">
                </div>

                <!-- Filters Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Category Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                        <div class="relative">
                            <select name="category_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-sm appearance-none filter-select">
                                <option value="">🏷️ Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Rentang Harga</label>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                                <input type="number" name="min_price" value="{{ request('min_price') }}"
                                       placeholder="Min"
                                       class="w-full pl-8 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm filter-input">
                            </div>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                                <input type="number" name="max_price" value="{{ request('max_price') }}"
                                       placeholder="Max"
                                       class="w-full pl-8 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm filter-input">
                            </div>
                        </div>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Urutkan</label>
                        <div class="relative">
                            <select name="sort" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-sm appearance-none filter-select">
                                <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>🆕 Produk Terbaru</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>🔤 Nama A-Z</option>
                                <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>💰 Harga Terendah</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>💎 Harga Tertinggi</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Village Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Desa</label>
                        <div class="relative">
                            <select name="village_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-sm appearance-none filter-select">
                                <option value="">🏘️ Semua Desa</option>
                                @foreach($villages as $village)
                                    <option value="{{ $village->id }}" {{ request('village_id') == $village->id ? 'selected' : '' }}>
                                        {{ $village->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pt-2 border-gray-100">
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        <a href="{{ route('products.index') }}" class="w-full sm:w-auto bg-gray-100 text-gray-700 px-6 py-3 rounded-xl hover:bg-gray-200 transition-all duration-200 text-center text-sm font-semibold flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Reset Filter
                        </a>
                    </div>
                    
                    <!-- Results Counter -->
                    <div class="flex items-center gap-2 text-sm text-gray-600 bg-gray-50 px-4 py-2 rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span class="font-semibold">{{ $products->count() }}</span> dari <span class="font-semibold">{{ $products->total() }}</span> produk
                    </div>
                </div>
            </form>
        </div>

        <!-- Products Grid -->
        <div class="relative">
            <!-- Loading Overlay for Products Area -->
            <div id="productsLoadingOverlay" class="absolute inset-0 bg-white bg-opacity-80 backdrop-blur-sm z-10 hidden items-center justify-center rounded-lg">
                <div class="flex flex-col items-center space-y-3">
                    <svg class="animate-spin h-10 w-10 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="text-gray-700 font-medium">Mencari produk...</p>
                </div>
            </div>

            @if($products->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 sm:gap-4 mb-8" id="productsGrid">
                @foreach($products as $product)
                    <a href="{{ route('products.show', $product) }}" 
                       class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md hover:border-green-300 transition-all duration-200 group block">
                        <!-- Product Image -->
                        <div class="relative overflow-hidden">
                            @if($product->images && count($product->images) > 0)
                                <img src="{{ $product->getImageDataUri(0) }}" alt="{{ $product->name }}" 
                                     class="w-full h-32 sm:h-40 md:h-44 object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-32 sm:h-40 md:h-44 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="p-2 sm:p-3">
                            <!-- Product Name -->
                            <h3 class="font-normal text-gray-800 mb-1 text-xs sm:text-sm line-clamp-2 leading-tight">
                                {{ $product->name }}
                            </h3>
                            
                            <!-- Price -->
                            <div class="mt-2">
                                <span class="text-sm sm:text-base font-bold text-gray-900">
                                    Rp{{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>

                            <!-- Village Badge -->
                            @if($product->village)
                                <div class="mt-2 flex items-center gap-1">
                                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <span class="text-xs text-gray-500 truncate">
                                        {{ $product->village->name }}
                                    </span>
                                </div>
                            @endif

                            <!-- Category -->
                            <div class="mt-1">
                                <span class="text-xs text-gray-400">
                                    {{ $product->category->name }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $products->appends(request()->query())->links() }}
            </div>
            @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m13-8V4a1 1 0 00-1-1H7a1 1 0 00-1 1v1m8 0V4m0 0H8m4 0h4"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada produk ditemukan</h3>
                <p class="text-gray-600">Coba ubah filter pencarian Anda atau lihat semua produk</p>
                <a href="{{ route('products.index') }}" class="mt-4 inline-block bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition-colors">
                    Lihat Semua Produk
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');
    const filterSelects = document.querySelectorAll('.filter-select');
    const filterInputs = document.querySelectorAll('.filter-input');
    const loadingOverlay = document.getElementById('productsLoadingOverlay');

    let searchTimeout;
    let isSubmitting = false;

    // Function to show loading
    function showLoading() {
        if (loadingOverlay) {
            loadingOverlay.classList.remove('hidden');
            loadingOverlay.classList.add('flex');
        }
    }

    // Function to hide loading
    function hideLoading() {
        if (loadingOverlay) {
            loadingOverlay.classList.add('hidden');
            loadingOverlay.classList.remove('flex');
        }
    }

    // Debounce function for search input
    searchInput.addEventListener('input', function() {
        // Show loading immediately when user types
        showLoading();

        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            if (!isSubmitting) {
                isSubmitting = true;
                searchForm.submit();
            }
        }, 500); // 500ms delay after user stops typing
    });

    // Instant submit for select filters
    filterSelects.forEach(function(select) {
        select.addEventListener('change', function() {
            showLoading();
            if (!isSubmitting) {
                isSubmitting = true;
                setTimeout(function() {
                    searchForm.submit();
                }, 100);
            }
        });
    });

    // Debounce function for price inputs
    filterInputs.forEach(function(input) {
        let inputTimeout;
        input.addEventListener('input', function() {
            // Show loading immediately when user types
            showLoading();

            clearTimeout(inputTimeout);
            inputTimeout = setTimeout(function() {
                if (!isSubmitting) {
                    isSubmitting = true;
                    searchForm.submit();
                }
            }, 800); // 800ms delay for price inputs
        });
    });

    // Hide loading when page is fully loaded (back button case)
    window.addEventListener('pageshow', function() {
        hideLoading();
        isSubmitting = false;
    });

    // Hide loading on page load
    hideLoading();
});
</script>

@endsection