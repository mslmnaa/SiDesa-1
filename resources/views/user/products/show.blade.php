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
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8">
                <!-- Product Images -->
                <div>
                    @if($product->images && count($product->images) > 0)
                        <div class="mb-4">
                            <img id="main-image" src="{{ $product->getImageDataUri(0) }}" alt="{{ $product->name }}" 
                                 class="w-full h-96 object-cover rounded-lg">
                        </div>
                        @if(count($product->images) > 1)
                            <div class="grid grid-cols-4 gap-2">
                                @foreach($product->images as $index => $image)
                                    <img src="{{ $product->getImageDataUri($index) }}" alt="{{ $product->name }}" 
                                         onclick="changeMainImage('{{ $product->getImageDataUri($index) }}')"
                                         class="w-full h-20 object-cover rounded cursor-pointer hover:opacity-75 {{ $index === 0 ? 'ring-2 ring-green-500' : '' }}">
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div>
                    <div class="mb-4">
                        <span class="text-sm text-green-600 bg-green-100 px-3 py-1 rounded-full">{{ $product->category->name }}</span>
                    </div>
                    
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                    
                    <div class="flex items-center mb-4">
                        <span class="text-3xl font-bold text-green-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="flex items-center mb-6">
                        <span class="text-sm text-gray-600 mr-4">Stok tersisa: 
                            <span class="font-semibold {{ $product->stock > 10 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $product->stock }} unit
                            </span>
                        </span>
                        <span class="text-sm px-2 py-1 {{ $product->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded">
                            {{ ucfirst($product->status) }}
                        </span>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi Produk</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                    </div>

                    <!-- Add to Cart Form -->
                    @if($product->stock > 0 && $product->status === 'active')
                        @auth
                            <form action="{{ route('user.cart.add') }}" method="POST" class="mb-6">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                                <div class="flex items-center space-x-4 mb-4">
                                    <label class="text-sm font-medium text-gray-700">Jumlah:</label>
                                    <div class="flex items-center">
                                        <button type="button" onclick="decrementQuantity()" class="bg-gray-200 text-gray-700 px-3 py-1 rounded-l">-</button>
                                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                               class="w-16 px-3 py-1 text-center border-t border-b border-gray-200 focus:outline-none">
                                        <button type="button" onclick="incrementQuantity()" class="bg-gray-200 text-gray-700 px-3 py-1 rounded-r">+</button>
                                    </div>
                                </div>
                                
                                <div class="flex space-x-4">
                                    <button type="submit" class="flex-1 bg-green-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                                        Tambah ke Keranjang
                                    </button>
                                    @if($product->whatsapp_number)
                                        <button type="button" onclick="openWhatsAppOrder('{{ $product->whatsapp_number }}', '{{ $product->name }}', '{{ number_format($product->price, 0, ',', '.') }}', '{{ route('products.show', $product) }}')" 
                                           class="flex-1 bg-green-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-600 transition-colors text-center inline-flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                            </svg>
                                            Pesan via WhatsApp
                                        </button>
                                    @endif
                                </div>
                            </form>
                        @else
                            <div class="mb-6">
                                <p class="text-gray-600 mb-4">Silakan login untuk menambahkan produk ke keranjang</p>
                                <div class="flex space-x-4">
                                    <a href="{{ route('login') }}" class="flex-1 bg-green-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-700 transition-colors text-center">
                                        Login untuk Beli
                                    </a>
                                    @if($product->whatsapp_number)
                                        <button type="button" onclick="openWhatsAppOrder('{{ $product->whatsapp_number }}', '{{ $product->name }}', '{{ number_format($product->price, 0, ',', '.') }}', '{{ route('products.show', $product) }}')" 
                                           class="flex-1 bg-green-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-600 transition-colors text-center inline-flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                            </svg>
                                            Pesan via WhatsApp
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endauth
                    @else
                        <div class="mb-6">
                            <p class="text-red-600 font-semibold">Produk ini sedang tidak tersedia</p>
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
function changeMainImage(imageSrc) {
    document.getElementById('main-image').src = imageSrc;
    
    // Update ring styling
    document.querySelectorAll('.grid img').forEach(img => {
        img.classList.remove('ring-2', 'ring-green-500');
    });
    event.target.classList.add('ring-2', 'ring-green-500');
}

function incrementQuantity() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.getAttribute('max'));
    const current = parseInt(input.value);
    
    if (current < max) {
        input.value = current + 1;
    }
}

function decrementQuantity() {
    const input = document.getElementById('quantity');
    const min = parseInt(input.getAttribute('min'));
    const current = parseInt(input.value);
    
    if (current > min) {
        input.value = current - 1;
    }
}

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