@extends('layouts.app')

@section('title', 'Pesanan #' . $order->order_number . ' - BUMDes Marketplace')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Pesanan #{{ $order->order_number }}</h1>
                    <p class="text-gray-600 mt-2">Dipesan pada {{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div class="text-right">
                    <div class="px-4 py-2 rounded-full text-lg font-semibold
                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                        @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                        @elseif($order->status === 'delivered') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        @if($order->status === 'pending') Menunggu Konfirmasi
                        @elseif($order->status === 'processing') Diproses
                        @elseif($order->status === 'shipped') Dikirim
                        @elseif($order->status === 'delivered') Selesai
                        @else Dibatalkan @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Items -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b">
                        <h2 class="text-xl font-semibold text-gray-900">Produk yang Dipesan</h2>
                    </div>
                    
                    <div class="divide-y divide-gray-200">
                        @foreach($order->orderItems as $item)
                            <div class="p-6">
                                <div class="flex items-center space-x-4">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0">
                                        @if($item->product->images && count($item->product->images) > 0)
                                            <img src="{{ $item->product->getImageDataUri(0) }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 class="w-20 h-20 object-cover rounded-lg">
                                        @else
                                            <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Product Info -->
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-gray-900 mb-1">{{ $item->product->name }}</h3>
                                        <p class="text-sm text-gray-500 mb-2">{{ $item->product->category->name }}</p>
                                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                                            <span>Qty: {{ $item->quantity }}</span>
                                            <span>×</span>
                                            <span>Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                        </div>
                                        
                                        <!-- WhatsApp Contact -->
                                        @if($item->product->whatsapp_number)
                                            <div class="mt-2">
                                                <a href="https://wa.me/{{ $item->product->whatsapp_number }}?text=Halo, saya ingin bertanya tentang pesanan {{ $order->order_number }} untuk produk {{ $item->product->name }}" 
                                                   target="_blank"
                                                   class="inline-flex items-center text-green-600 hover:text-green-800 text-sm">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                                    </svg>
                                                    Chat Penjual
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Subtotal -->
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-gray-900">
                                            Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Status Timeline -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Status Pesanan</h2>
                    
                    <div class="relative">
                        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                        
                        <div class="relative space-y-6">
                            <!-- Pending -->
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $order->status !== 'cancelled' ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">Pesanan Dibuat</h3>
                                    <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>

                            <!-- Processing -->
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">Dikonfirmasi & Diproses</h3>
                                    <p class="text-sm text-gray-500">
                                        @if(in_array($order->status, ['processing', 'shipped', 'delivered']))
                                            Pesanan sedang diproses oleh penjual
                                        @else
                                            Menunggu konfirmasi dari penjual
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Shipped -->
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full {{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">Dikirim</h3>
                                    <p class="text-sm text-gray-500">
                                        @if(in_array($order->status, ['shipped', 'delivered']))
                                            Pesanan sedang dalam perjalanan
                                        @else
                                            Akan dikirim setelah diproses
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Delivered -->
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $order->status === 'delivered' ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">Selesai</h3>
                                    <p class="text-sm text-gray-500">
                                        @if($order->status === 'delivered')
                                            Pesanan telah sampai di tujuan
                                        @else
                                            Pesanan akan selesai setelah dikirim
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Customer Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Pembeli</h2>
                    
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm font-medium text-gray-700">Nama</p>
                            <p class="text-gray-900">{{ $order->customer_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Telepon</p>
                            <p class="text-gray-900">{{ $order->customer_phone }}</p>
                        </div>
                    </div>
                </div>

                <!-- Shipping Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Alamat Pengiriman</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $order->shipping_address }}</p>
                </div>

                <!-- Payment Summary -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Ringkasan Pembayaran</h2>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Ongkos Kirim</span>
                            <span class="font-medium text-green-600">GRATIS</span>
                        </div>
                        <hr>
                        <div class="flex justify-between text-lg font-bold">
                            <span>Total</span>
                            <span class="text-green-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                @if($order->notes)
                    <!-- Order Notes -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Catatan Pesanan</h2>
                        <p class="text-gray-700 italic">{{ $order->notes }}</p>
                    </div>
                @endif

                <!-- Contact Info -->
                <div class="bg-blue-50 rounded-lg p-6">
                    <h3 class="font-semibold text-blue-900 mb-2">Butuh Bantuan?</h3>
                    <p class="text-sm text-blue-800 mb-3">
                        Hubungi penjual langsung untuk informasi lebih lanjut tentang pesanan Anda.
                    </p>
                    <div class="space-y-2">
                        @foreach($order->orderItems->pluck('product')->unique('whatsapp_number') as $product)
                            @if($product->whatsapp_number)
                                <a href="https://wa.me/{{ $product->whatsapp_number }}?text=Halo, saya ingin bertanya tentang pesanan {{ $order->order_number }}" 
                                   target="_blank"
                                   class="block bg-green-500 text-white px-4 py-2 rounded text-center hover:bg-green-600 transition-colors">
                                    Chat via WhatsApp
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection