@extends('layouts.app')

@section('title', $village->name . ' - BUMDes Marketplace')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Village Header -->
    <div class="bg-gradient-to-r from-green-600 to-green-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 sm:py-12">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                <!-- Village Logo -->
                <div class="w-32 h-32 bg-white rounded-full p-3 shadow-lg flex-shrink-0">
                    @if($village->logo)
                        <img src="{{ asset('storage/' . $village->logo) }}" alt="{{ $village->name }}" class="w-full h-full object-contain rounded-full">
                    @else
                        <div class="w-full h-full bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Village Info -->
                <div class="flex-1 text-center md:text-left">
                    <h1 class="text-3xl sm:text-4xl font-bold mb-3">{{ $village->name }}</h1>

                    @if($village->description)
                        <p class="text-green-50 text-lg mb-4 max-w-3xl">{{ $village->description }}</p>
                    @endif

                    <div class="flex flex-wrap gap-4 justify-center md:justify-start text-sm">
                        <!-- Location -->
                        <div class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-lg backdrop-blur-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>{{ $village->district }}, {{ $village->city }}, {{ $village->province }}</span>
                        </div>

                        <!-- Products Count -->
                        <div class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-lg backdrop-blur-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span>{{ $village->products->count() }} Produk</span>
                        </div>

                        <!-- Phone -->
                        @if($village->phone)
                            <div class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-lg backdrop-blur-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span>{{ $village->phone }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Bar -->
    @if($village->whatsapp || $village->email)
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4">
                <div class="flex flex-wrap gap-3 justify-center md:justify-start">
                    @if($village->whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $village->whatsapp) }}"
                           target="_blank"
                           class="inline-flex items-center gap-2 bg-green-600 text-white px-6 py-2.5 rounded-lg hover:bg-green-700 transition-colors font-medium">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                            Hubungi via WhatsApp
                        </a>
                    @endif

                    @if($village->email)
                        <a href="mailto:{{ $village->email }}"
                           class="inline-flex items-center gap-2 bg-gray-700 text-white px-6 py-2.5 rounded-lg hover:bg-gray-800 transition-colors font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Kirim Email
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Products Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Produk dari {{ $village->name }}</h2>
            <p class="text-gray-600">Jelajahi {{ $village->products->count() }} produk berkualitas dari desa ini</p>
        </div>

        @if($village->products->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 sm:gap-4">
                @foreach ($village->products as $product)
                    <a href="{{ route('products.show', $product) }}"
                       class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md hover:border-green-300 transition-all duration-200 group block">
                        <!-- Product Image -->
                        <div class="relative overflow-hidden">
                            @if ($product->images && count($product->images) > 0)
                                <img src="{{ $product->getImageDataUri(0) }}" alt="{{ $product->name }}"
                                     class="w-full h-32 sm:h-40 md:h-44 object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-32 sm:h-40 md:h-44 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif

                            <!-- Stock Badge -->
                            @if($product->stock <= 0)
                                <div class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded">
                                    Habis
                                </div>
                            @elseif($product->stock < 10)
                                <div class="absolute top-2 right-2 bg-orange-500 text-white text-xs px-2 py-1 rounded">
                                    Stok {{ $product->stock }}
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
        @else
            <div class="text-center py-12 bg-white rounded-xl">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m13-8V4a1 1 0 00-1-1H7a1 1 0 00-1 1v1m8 0V4m0 0H8m4 0h4"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada produk</h3>
                <p class="text-gray-600">Desa ini belum menambahkan produk</p>
            </div>
        @endif
    </div>

    <!-- Back Button -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 pb-8">
        <a href="{{ route('villages.index') }}"
           class="inline-flex items-center gap-2 text-green-600 hover:text-green-700 font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Desa
        </a>
    </div>
</div>

@endsection
