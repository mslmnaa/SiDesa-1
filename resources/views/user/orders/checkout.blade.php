@extends('layouts.app')

@section('title', 'Checkout - BUMDes Marketplace')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
            <p class="text-gray-600 mt-2">Lengkapi informasi pengiriman untuk menyelesaikan pembelian</p>
        </div>

        <form action="{{ route('user.orders.place') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Customer Information & Shipping -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Customer Info -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Pembeli</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap *
                                </label>
                                <input type="text" id="customer_name" name="customer_name" 
                                       value="{{ old('customer_name', auth()->user()->name) }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('customer_name') border-red-500 @enderror">
                                @error('customer_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nomor Telepon *
                                </label>
                                <input type="tel" id="customer_phone" name="customer_phone" 
                                       value="{{ old('customer_phone', auth()->user()->phone) }}" required
                                       placeholder="Contoh: 081234567890"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('customer_phone') border-red-500 @enderror">
                                @error('customer_phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Alamat Pengiriman</h2>
                        
                        <div>
                            <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat Lengkap *
                            </label>
                            <textarea id="shipping_address" name="shipping_address" rows="4" required
                                      placeholder="Masukkan alamat lengkap termasuk RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten, Provinsi, dan Kode Pos"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('shipping_address') border-red-500 @enderror">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                            @error('shipping_address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Catatan Pesanan</h2>
                        
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan untuk Penjual (Opsional)
                            </label>
                            <textarea id="notes" name="notes" rows="3"
                                      placeholder="Contoh: Tolong dikemas dengan bubble wrap, pengiriman setelah jam 14:00"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow p-6 sticky top-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h2>
                        
                        <!-- Cart Items -->
                        <div class="space-y-4 mb-6">
                            @foreach($cartItems as $item)
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        @if($item->product->images && count($item->product->images) > 0)
                                            <img src="{{ Storage::url($item->product->images[0]) }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 class="w-12 h-12 object-cover rounded">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $item->product->name }}</p>
                                        <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900">
                                        Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>

                        <!-- Price Summary -->
                        <div class="border-t pt-4">
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal ({{ $cartItems->count() }} item)</span>
                                    <span class="font-medium">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Ongkos Kirim</span>
                                    <span class="font-medium text-green-600">GRATIS</span>
                                </div>
                            </div>
                            
                            <div class="border-t pt-2">
                                <div class="flex justify-between">
                                    <span class="text-lg font-semibold text-gray-900">Total</span>
                                    <span class="text-xl font-bold text-green-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Place Order Button -->
                        <button type="submit" 
                                class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-green-700 transition-colors mt-6">
                            Buat Pesanan
                        </button>

                        <!-- Payment Info -->
                        <div class="mt-6 p-4 bg-yellow-50 rounded-lg">
                            <h3 class="font-semibold text-yellow-900 mb-2">Info Pembayaran</h3>
                            <p class="text-sm text-yellow-800">
                                Setelah pesanan dibuat, Anda akan diberikan informasi pembayaran dan 
                                dapat melakukan koordinasi langsung dengan penjual melalui WhatsApp.
                            </p>
                        </div>

                        <!-- Security Info -->
                        <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span class="text-sm font-medium text-blue-900">Pesanan Anda Aman</span>
                            </div>
                            <p class="text-xs text-blue-800 mt-1">Data pribadi dilindungi dan tidak akan dibagikan kepada pihak ketiga</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection