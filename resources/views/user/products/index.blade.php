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
            <form method="GET" action="{{ route('products.index') }}" class="space-y-5">
                <!-- Search Bar - Full Width -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari produk, kategori, atau deskripsi..."
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 text-sm sm:text-base">
                </div>

                <!-- Filters Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Category Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                        <div class="relative">
                            <select name="category_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-sm appearance-none">
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
                                       class="w-full pl-8 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                            </div>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" 
                                       placeholder="Max"
                                       class="w-full pl-8 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Urutkan</label>
                        <div class="relative">
                            <select name="sort" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-sm appearance-none">
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

                    <!-- Stock Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Ketersediaan</label>
                        <div class="relative">
                            <select name="stock" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-sm appearance-none">
                                <option value="">📦 Semua Stok</option>
                                <option value="available" {{ request('stock') == 'available' ? 'selected' : '' }}>✅ Tersedia</option>
                                <option value="low" {{ request('stock') == 'low' ? 'selected' : '' }}>⚠️ Stok Menipis</option>
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
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pt-2 border-t border-gray-100">
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        <button type="submit" class="w-full sm:w-auto bg-green-600 text-white px-6 py-3 rounded-xl hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 text-sm font-semibold flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
                            </svg>
                            Terapkan Filter
                        </button>
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
        @if($products->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4 lg:gap-6 mb-8">
                @foreach($products as $product)
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
                            
                            <!-- Action Buttons -->
                            <div class="space-y-2">
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
                                
                                @if($product->whatsapp_number)
                                    <button type="button" onclick="openWhatsAppOrder('{{ $product->whatsapp_number }}', '{{ $product->name }}', '{{ number_format($product->price, 0, ',', '.') }}', '{{ route('products.show', $product) }}')" 
                                           class="w-full bg-green-500 text-white px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-green-600 transition-all duration-200 flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                        </svg>
                                        Pesan via WhatsApp
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
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

<script>
function openWhatsAppOrder(whatsappNumber, productName, productPrice, productUrl) {
    const quantity = 1; // Default quantity for product listing
    const totalPrice = parseInt(productPrice.replace(/\./g, '')) * quantity;
    const formattedTotalPrice = totalPrice.toLocaleString('id-ID');
    
    const message = `🛒 *PEMESANAN PRODUK*

📦 *Detail Produk:*
• Nama: ${productName}
• Harga Satuan: Rp ${productPrice}
• Jumlah: ${quantity}
• Total Harga: Rp ${formattedTotalPrice}

🔗 *Link Produk:*
${productUrl}

📝 *Informasi Pemesan:*
• Nama: [Silakan isi nama Anda]
• Alamat Lengkap: [Silakan isi alamat pengiriman]
• No. HP: [Silakan isi nomor HP]

💬 Halo, saya ingin memesan produk di atas. Mohon konfirmasi ketersediaan dan ongkos kirim ke alamat saya. Terima kasih! 😊`;
    
    const encodedMessage = encodeURIComponent(message);
    const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodedMessage}`;
    
    window.open(whatsappUrl, '_blank');
}
</script>
@endsection