@extends('layouts.app')

@section('title', $typeLabel . ' - BUMDes Marketplace')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-8 px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ $typeLabel }}</h1>
            <p class="text-gray-600 mt-2">
                @if($type === 'barang')
                    Temukan berbagai produk barang berkualitas dari desa
                @else
                    Temukan layanan jasa terbaik dari masyarakat desa
                @endif
            </p>
        </div>

        <!-- Search & Filter -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <form method="GET" action="{{ route('products.type', $type) }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cari {{ $type === 'barang' ? 'Produk' : 'Jasa' }}</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Nama {{ $type === 'barang' ? 'produk' : 'jasa' }} atau deskripsi..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select name="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Harga Min</label>
                            <input type="number" name="min_price" value="{{ request('min_price') }}" 
                                   placeholder="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Harga Max</label>
                            <input type="number" name="max_price" value="{{ request('max_price') }}" 
                                   placeholder="1000000"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                        </div>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                        <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Terbaru</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                            <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Harga Terendah</option>
                        </select>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition-colors">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('products.type', $type) }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-300 transition-colors">
                        Reset Filter
                    </a>
                </div>
            </form>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <!-- Product Image -->
                        <div class="relative h-48 bg-gray-200">
                            @if($product->images && count($product->images) > 0)
                                <img src="{{ $product->getImageDataUri(0) }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-300">
                                    <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($type === 'barang')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m8 6.273A24.317 24.317 0 007.52 15.012M9 7h6m0 10v-3a1 1 0 00-1-1H10a1 1 0 00-1 1v3a1 1 0 001 1h4a1 1 0 001-1z"></path>
                                        @endif
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Type Badge -->
                            <div class="absolute top-2 left-2">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $type === 'barang' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                    {{ ucfirst($type) }}
                                </span>
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="p-4">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="text-lg font-semibold text-gray-900 line-clamp-2">{{ $product->name }}</h3>
                            </div>
                            
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $product->description }}</p>
                            
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-2xl font-bold text-green-600">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                    @if($type === 'jasa')
                                        <span class="text-sm font-normal text-gray-500">/layanan</span>
                                    @endif
                                </span>
                                @if($type === 'barang')
                                    <span class="text-sm text-gray-500">Stok: {{ $product->stock }}</span>
                                @endif
                            </div>
                            
                            <div class="flex items-center mb-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $product->category->name }}
                                </span>
                            </div>

                            <!-- Action Button -->
                            <div class="space-y-2">
                                <a href="{{ route('products.show', $product) }}" 
                                   class="w-full bg-green-600 text-white text-center py-2 rounded-md hover:bg-green-700 transition-colors block">
                                    Lihat Detail
                                </a>
                                
                                @if($type === 'barang')
                                    <div class="flex space-x-2">
                                        @auth
                                            <form method="POST" action="{{ route('user.cart.add') }}" class="flex-1">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition-colors">
                                                    + Keranjang
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('login') }}" class="flex-1 bg-blue-600 text-white text-center py-2 rounded-md hover:bg-blue-700 transition-colors">
                                                + Keranjang
                                            </a>
                                        @endauth
                                        
                                        @if($product->whatsapp_number)
                                            <button type="button" onclick="openWhatsAppOrder('{{ $product->whatsapp_number }}', '{{ $product->name }}', '{{ number_format($product->price, 0, ',', '.') }}', '{{ route('products.show', $product) }}')" 
                                                   class="flex-1 bg-green-500 text-white py-2 rounded-md hover:bg-green-600 transition-colors inline-flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                @elseif($type === 'jasa' && $product->whatsapp_number)
                                    <button type="button" onclick="openWhatsAppOrder('{{ $product->whatsapp_number }}', '{{ $product->name }}', '{{ number_format($product->price, 0, ',', '.') }}', '{{ route('products.show', $product) }}')" 
                                           class="w-full bg-green-500 text-white py-2 rounded-md hover:bg-green-600 transition-colors inline-flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
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
                {{ $products->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if($type === 'barang')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m8 6.273A24.317 24.317 0 007.52 15.012M9 7h6m0 10v-3a1 1 0 00-1-1H10a1 1 0 00-1 1v3a1 1 0 001-1h4a1 1 0 001-1z"></path>
                    @endif
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">
                    Tidak ada {{ $type === 'barang' ? 'produk barang' : 'layanan jasa' }} yang ditemukan
                </h3>
                <p class="text-gray-600 mb-6">
                    Coba ubah filter pencarian atau periksa kembali nanti untuk {{ $type === 'barang' ? 'produk barang' : 'layanan jasa' }} terbaru.
                </p>
                <a href="{{ route('products.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
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