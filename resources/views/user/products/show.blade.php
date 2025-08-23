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
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6 sm:p-8">
                <!-- Product Images -->
                <div class="space-y-4">
                    @if($product->images && count($product->images) > 0)
                        <div class="relative group">
                            <img id="main-image" src="{{ $product->getImageDataUri(0) }}" alt="{{ $product->name }}" 
                                 class="w-full h-80 sm:h-96 object-cover rounded-xl shadow-md">
                            
                            <!-- Image Zoom Indicator -->
                            <div class="absolute top-3 right-3 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                        
                        @if(count($product->images) > 1)
                            <div class="grid grid-cols-4 gap-3">
                                @foreach($product->images as $index => $image)
                                    <div class="relative">
                                        <img src="{{ $product->getImageDataUri($index) }}" alt="{{ $product->name }}" 
                                             onclick="changeMainImage('{{ $product->getImageDataUri($index) }}', {{ $index }})"
                                             class="w-full h-20 object-cover rounded-lg cursor-pointer hover:opacity-80 transition-all duration-200 {{ $index === 0 ? 'ring-2 ring-green-500' : 'ring-1 ring-gray-200' }}"
                                             data-index="{{ $index }}">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="w-full h-80 sm:h-96 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-gray-500 text-sm">Tidak ada gambar produk</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="space-y-6">
                    <!-- Category Badge -->
                    <div>
                        <span class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-green-700 bg-green-100 rounded-full">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            {{ $product->category->name }}
                        </span>
                    </div>
                    
                    <!-- Product Name -->
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight">{{ $product->name }}</h1>
                    </div>
                    
                    <!-- Price -->
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                        <div class="flex items-center">
                            <span class="text-3xl sm:text-4xl font-bold text-green-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                        <p class="text-green-700 text-sm mt-1">Harga termasuk semua biaya</p>
                    </div>
                    
                    <!-- Stock & Status -->
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <span class="text-sm text-gray-600">Stok tersisa:</span>
                            <span class="font-semibold {{ $product->stock > 10 ? 'text-green-600' : ($product->stock > 0 ? 'text-orange-600' : 'text-red-600') }}">
                                {{ $product->stock }} unit
                            </span>
                        </div>
                        
                        <div class="h-6 w-px bg-gray-300"></div>
                        
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full {{ $product->status === 'active' ? 'bg-green-500' : 'bg-red-500' }}"></div>
                            <span class="text-sm font-medium {{ $product->status === 'active' ? 'text-green-700' : 'text-red-700' }}">
                                {{ $product->status === 'active' ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="border border-gray-200 rounded-xl p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Deskripsi Produk
                        </h3>
                        <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                    </div>

                    <!-- Add to Cart Form -->
                    @if($product->stock > 0 && $product->status === 'active')
                        @auth
                            <div class="border border-gray-200 rounded-xl p-6 bg-gray-50">
                                <form action="{{ route('user.cart.add') }}" method="POST" class="space-y-6">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    
                                    <!-- Quantity Selector -->
                                    <div class="flex items-center justify-between">
                                        <label class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                            Jumlah
                                        </label>
                                        <div class="flex items-center bg-white border border-gray-300 rounded-xl overflow-hidden">
                                            <button type="button" onclick="decrementQuantity()" 
                                                    class="px-4 py-3 text-gray-600 hover:bg-gray-100 transition-colors focus:outline-none focus:bg-gray-100">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"/>
                                                </svg>
                                            </button>
                                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                                   class="w-20 px-3 py-3 text-center border-0 focus:outline-none text-lg font-semibold"
                                                   onchange="updateTotal()">
                                            <button type="button" onclick="incrementQuantity()" 
                                                    class="px-4 py-3 text-gray-600 hover:bg-gray-100 transition-colors focus:outline-none focus:bg-gray-100">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Total Price Display -->
                                    <div class="bg-white rounded-xl p-4 border border-gray-200">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600">Total Harga:</span>
                                            <span id="total-price" class="text-xl font-bold text-green-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="grid grid-cols-1 gap-3">
                                        <button type="submit" class="w-full bg-green-600 text-white py-4 px-6 rounded-xl font-semibold hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 flex items-center justify-center gap-3">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                            </svg>
                                            Tambah ke Keranjang
                                        </button>
                                        
                                        @if($product->whatsapp_number)
                                            <button type="button" onclick="openWhatsAppOrder('{{ $product->whatsapp_number }}', '{{ $product->name }}', '{{ number_format($product->price, 0, ',', '.') }}', '{{ route('products.show', $product) }}')" 
                                                   class="w-full bg-green-500 text-white py-4 px-6 rounded-xl font-semibold hover:bg-green-600 transition-all duration-200 flex items-center justify-center gap-3">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                                </svg>
                                                Pesan Langsung via WhatsApp
                                            </button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="border border-orange-200 rounded-xl p-6 bg-orange-50">
                                <div class="text-center mb-4">
                                    <svg class="w-12 h-12 text-orange-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-orange-900 mb-2">Login Diperlukan</h3>
                                    <p class="text-orange-700 text-sm">Silakan login untuk menambahkan produk ke keranjang</p>
                                </div>
                                
                                <div class="grid grid-cols-1 gap-3">
                                    <a href="{{ route('login') }}" class="w-full bg-green-600 text-white py-4 px-6 rounded-xl font-semibold hover:bg-green-700 transition-all duration-200 text-center flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                        </svg>
                                        Login untuk Berbelanja
                                    </a>
                                    
                                    @if($product->whatsapp_number)
                                        <button type="button" onclick="openWhatsAppOrder('{{ $product->whatsapp_number }}', '{{ $product->name }}', '{{ number_format($product->price, 0, ',', '.') }}', '{{ route('products.show', $product) }}')" 
                                               class="w-full bg-green-500 text-white py-4 px-6 rounded-xl font-semibold hover:bg-green-600 transition-all duration-200 flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                            </svg>
                                            Pesan Tanpa Login via WhatsApp
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endauth
                    @else
                        <div class="border border-red-200 rounded-xl p-6 bg-red-50 text-center">
                            <svg class="w-12 h-12 text-red-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-red-900 mb-2">Produk Tidak Tersedia</h3>
                            <p class="text-red-700 text-sm">Maaf, produk ini sedang tidak tersedia atau stok habis</p>
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
                                    <img src="{{ $related->getImageDataUri(0) }}" alt="{{ $related->name }}" class="w-full h-40 object-cover">
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
// Product price for calculation
const productPrice = {{ $product->price }};

function changeMainImage(imageSrc, index) {
    document.getElementById('main-image').src = imageSrc;
    
    // Update ring styling for all thumbnails
    document.querySelectorAll('[data-index]').forEach(img => {
        img.classList.remove('ring-2', 'ring-green-500');
        img.classList.add('ring-1', 'ring-gray-200');
    });
    
    // Highlight selected thumbnail
    const selectedImg = document.querySelector(`[data-index="${index}"]`);
    if (selectedImg) {
        selectedImg.classList.remove('ring-1', 'ring-gray-200');
        selectedImg.classList.add('ring-2', 'ring-green-500');
    }
}

function incrementQuantity() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.getAttribute('max'));
    const current = parseInt(input.value);
    
    if (current < max) {
        input.value = current + 1;
        updateTotal();
    }
}

function decrementQuantity() {
    const input = document.getElementById('quantity');
    const min = parseInt(input.getAttribute('min'));
    const current = parseInt(input.value);
    
    if (current > min) {
        input.value = current - 1;
        updateTotal();
    }
}

function updateTotal() {
    const quantity = parseInt(document.getElementById('quantity').value) || 1;
    const total = productPrice * quantity;
    
    // Format number with Indonesian locale
    const formattedTotal = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(total).replace('IDR', 'Rp');
    
    const totalPriceElement = document.getElementById('total-price');
    if (totalPriceElement) {
        totalPriceElement.textContent = formattedTotal;
        
        // Add smooth animation
        totalPriceElement.style.transform = 'scale(1.1)';
        setTimeout(() => {
            totalPriceElement.style.transform = 'scale(1)';
        }, 200);
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateTotal();
    
    // Add smooth transitions
    const quantityInput = document.getElementById('quantity');
    if (quantityInput) {
        quantityInput.addEventListener('input', updateTotal);
    }
});

function openWhatsAppOrder(whatsappNumber, productName, productPrice, productUrl) {
    // Get quantity from input if exists (for logged in users)
    let quantity = 1;
    const quantityInput = document.getElementById('quantity');
    if (quantityInput) {
        quantity = parseInt(quantityInput.value);
    }
    
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