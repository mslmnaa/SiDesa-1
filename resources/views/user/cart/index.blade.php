@extends('layouts.app')

@section('title', 'Keranjang Belanja - BUMDes Marketplace')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Keranjang Belanja</h1>
            <p class="text-gray-600 mt-2 text-sm sm:text-base">Kelola produk yang akan Anda beli</p>
        </div>

        @if($cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="px-6 py-4 border-b">
                            <h2 class="text-lg font-semibold text-gray-900">Produk dalam Keranjang</h2>
                        </div>
                        
                        <div class="divide-y divide-gray-200">
                            @foreach($cartItems as $item)
                                <div class="p-4 sm:p-6">
                                    <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                                        <!-- Product Image & Info -->
                                        <div class="flex items-start space-x-3 sm:space-x-4 flex-1">
                                            <!-- Product Image -->
                                            <div class="flex-shrink-0">
                                                <a href="{{ route('products.show', $item->product) }}">
                                                    @if($item->product->images && count($item->product->images) > 0)
                                                        <img src="{{ $item->product->getImageDataUri(0) }}" 
                                                             alt="{{ $item->product->name }}" 
                                                             class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded-lg">
                                                    @else
                                                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                                            <svg class="w-6 h-6 sm:w-8 sm:h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </a>
                                            </div>
                                            
                                            <!-- Product Info -->
                                            <div class="flex-1 min-w-0">
                                                <h3 class="font-semibold text-gray-900 mb-1 text-sm sm:text-base">
                                                    <a href="{{ route('products.show', $item->product) }}" class="hover:text-green-600 line-clamp-2">
                                                        {{ $item->product->name }}
                                                    </a>
                                                </h3>
                                                <p class="text-xs sm:text-sm text-gray-500 mb-1">{{ $item->product->category->name }}</p>
                                                <p class="text-sm sm:text-lg font-bold text-green-600">
                                                    Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <!-- Controls & Actions -->
                                        <div class="flex flex-col gap-3">
                                            <!-- Quantity Controls -->
                                            <div class="flex items-center justify-center">
                                                <form action="{{ route('user.cart.update', $item) }}" method="POST" class="flex items-center space-x-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="flex items-center border rounded-lg">
                                                        <button type="button" onclick="decrementQuantity({{ $item->id }})" 
                                                                class="bg-gray-100 text-gray-700 px-3 py-2 hover:bg-gray-200 text-sm">-</button>
                                                        <input type="number" id="quantity-{{ $item->id }}" name="quantity" 
                                                               value="{{ $item->quantity }}" min="1" max="999"
                                                               class="w-16 px-2 py-2 text-center border-0 focus:outline-none text-sm font-semibold">
                                                        <button type="button" onclick="incrementQuantity({{ $item->id }})" 
                                                                class="bg-gray-100 text-gray-700 px-3 py-2 hover:bg-gray-200 text-sm">+</button>
                                                    </div>
                                                    <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded-lg text-xs hover:bg-blue-700">
                                                        Update
                                                    </button>
                                                </form>
                                            </div>
                                            
                                            <!-- Subtotal -->
                                            <div class="text-center">
                                                <p class="text-base font-bold text-gray-900">
                                                    Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}
                                                </p>
                                            </div>
                                            
                                            <!-- WhatsApp & Remove Buttons -->
                                            <div class="flex flex-col gap-2">
                                                @if($item->product->whatsapp_number)
                                                    <button type="button" 
                                                            onclick="openWhatsAppOrderFromCart('{{ $item->product->whatsapp_number }}', '{{ $item->product->name }}', {{ $item->product->price }}, {{ $item->quantity }}, '{{ route('products.show', $item->product) }}')"
                                                            class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-600 transition-colors flex items-center justify-center gap-2">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                                        </svg>
                                                        Chat Penjual
                                                    </button>
                                                    <p class="text-xs text-gray-500 text-center">
                                                        📞 {{ \App\Helpers\WhatsappHelper::getDisplayPhoneNumber($item->product->whatsapp_number) }}
                                                    </p>
                                                @else
                                                    <button type="button" class="bg-gray-400 text-white px-4 py-2 rounded-lg text-sm cursor-not-allowed" disabled>
                                                        Kontak Tidak Tersedia
                                                    </button>
                                                @endif
                                                
                                                <form action="{{ route('user.cart.remove', $item) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus produk ini dari keranjang?')" 
                                                            class="w-full text-red-600 hover:text-red-800 text-xs font-medium py-1">
                                                        Hapus dari Keranjang
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Cart Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6 lg:sticky lg:top-8">
                        <h2 class="text-base sm:text-lg font-semibold text-gray-900 mb-4">Ringkasan Keranjang</h2>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-sm sm:text-base">
                                <span class="text-gray-600">Total Item</span>
                                <span class="font-semibold">{{ $cartItems->count() }} produk</span>
                            </div>
                            <div class="flex justify-between text-sm sm:text-base">
                                <span class="text-gray-600">Estimasi Total</span>
                                <span class="font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <hr>
                            <div class="text-center p-3 bg-green-50 rounded-lg">
                                <p class="text-sm text-green-700">
                                    💬 <strong>Chat langsung</strong> dengan penjual untuk setiap produk
                                </p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <a href="{{ route('products.index') }}" 
                               class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-green-700 transition-colors text-center block">
                                Lanjut Belanja
                            </a>
                        </div>

                        <!-- WhatsApp Info -->
                        <div class="mt-6 p-4 bg-green-50 rounded-lg">
                            <h3 class="font-semibold text-green-900 mb-3 text-sm">🛒 Cara Pesan via WhatsApp:</h3>
                            <ul class="text-xs text-green-800 space-y-2">
                                <li class="flex items-start gap-2">
                                    <span class="text-green-600 font-bold">1.</span>
                                    <span>Klik tombol <strong>"Chat Penjual"</strong> pada produk yang diinginkan</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-green-600 font-bold">2.</span>
                                    <span>WhatsApp akan terbuka dengan pesan otomatis berisi detail produk</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-green-600 font-bold">3.</span>
                                    <span>Diskusikan harga, ongkir, dan cara pembayaran langsung dengan penjual</span>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Benefits -->
                        <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                            <h3 class="font-semibold text-blue-900 mb-2 text-sm">✨ Keuntungan:</h3>
                            <ul class="text-xs text-blue-800 space-y-1">
                                <li>• Nego harga langsung dengan penjual</li>
                                <li>• Konfirmasi stok real-time</li>
                                <li>• Fleksibilitas pembayaran</li>
                                <li>• Komunikasi personal & terpercaya</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-12">
                <div class="bg-white rounded-lg shadow-lg p-12">
                    <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M17 13l-1.5 6M9 19.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM20.5 19.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Keranjang Belanja Kosong</h3>
                    <p class="text-gray-600 mb-6">Anda belum menambahkan produk apapun ke keranjang</p>
                    <div class="space-x-4">
                        <a href="{{ route('products.index') }}" 
                           class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors inline-block">
                            Mulai Berbelanja
                        </a>
                        <a href="{{ route('home') }}" 
                           class="border border-gray-300 text-gray-700 px-8 py-3 rounded-lg hover:bg-gray-50 transition-colors inline-block">
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function incrementQuantity(itemId) {
    const input = document.getElementById(`quantity-${itemId}`);
    const current = parseInt(input.value);
    
    input.value = current + 1;
}

function decrementQuantity(itemId) {
    const input = document.getElementById(`quantity-${itemId}`);
    const min = parseInt(input.getAttribute('min'));
    const current = parseInt(input.value);
    
    if (current > min) {
        input.value = current - 1;
    }
}

function openWhatsAppOrderFromCart(whatsappNumber, productName, productPrice, quantity, productUrl) {
    // Calculate total price
    const totalPrice = productPrice * quantity;
    const formattedPrice = productPrice.toLocaleString('id-ID');
    const formattedTotal = totalPrice.toLocaleString('id-ID');
    
    // Generate WhatsApp message
    const message = `🛍️ *Halo! Saya tertarik dengan produk dari keranjang saya*

📦 *Detail Produk:*
• Nama: ${productName}
• Harga satuan: Rp ${formattedPrice}
• Jumlah: ${quantity} unit
• Total: Rp ${formattedTotal}

🔗 Link produk: ${productUrl}

❓ Apakah produk ini masih tersedia dengan jumlah yang saya minta?
📋 Bagaimana cara pembayaran dan pengirimannya?

Terima kasih! 😊`;
    
    // Clean phone number format for WhatsApp
    const cleanPhone = whatsappNumber.replace(/\D/g, '');
    const formattedPhone = cleanPhone.startsWith('62') ? cleanPhone : 
                          cleanPhone.startsWith('0') ? '62' + cleanPhone.substring(1) : 
                          '62' + cleanPhone;
    
    const encodedMessage = encodeURIComponent(message);
    const whatsappUrl = `https://wa.me/${formattedPhone}?text=${encodedMessage}`;
    
    window.open(whatsappUrl, '_blank');
}
</script>
@endsection