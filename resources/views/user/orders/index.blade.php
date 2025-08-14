@extends('layouts.app')

@section('title', 'Riwayat Pesanan - BUMDes Marketplace')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Riwayat Pesanan</h1>
            <p class="text-gray-600 mt-2">Kelola dan lacak semua pesanan Anda</p>
        </div>

        @if($orders->count() > 0)
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <!-- Order Header -->
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $order->order_number }}</h3>
                                        <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                    <div class="px-3 py-1 rounded-full text-sm font-medium
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
                                <div class="text-right">
                                    <p class="text-lg font-bold text-green-600">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </p>
                                    <p class="text-sm text-gray-500">{{ $order->orderItems->count() }} item</p>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items Preview -->
                        <div class="px-6 py-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($order->orderItems->take(3) as $item)
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
                                            <p class="text-xs text-gray-500">{{ $item->quantity }}x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                                
                                @if($order->orderItems->count() > 3)
                                    <div class="flex items-center justify-center text-gray-500">
                                        <span class="text-sm">+{{ $order->orderItems->count() - 3 }} item lainnya</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Order Actions -->
                        <div class="px-6 py-4 bg-gray-50 border-t">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span>Dikirim ke {{ Str::limit($order->shipping_address, 50) }}</span>
                                </div>
                                
                                <div class="flex space-x-3">
                                    <a href="{{ route('user.orders.show', $order) }}" 
                                       class="text-green-600 hover:text-green-800 text-sm font-medium">
                                        Lihat Detail
                                    </a>
                                    
                                    @if($order->status === 'pending')
                                        <span class="text-orange-600 text-sm font-medium">Menunggu Konfirmasi Penjual</span>
                                    @elseif($order->status === 'processing')
                                        <span class="text-blue-600 text-sm font-medium">Sedang Diproses</span>
                                    @elseif($order->status === 'shipped')
                                        <span class="text-purple-600 text-sm font-medium">Dalam Pengiriman</span>
                                    @elseif($order->status === 'delivered')
                                        <span class="text-green-600 text-sm font-medium">Pesanan Selesai</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                {{ $orders->links() }}
            </div>
        @else
            <!-- Empty Orders -->
            <div class="text-center py-12">
                <div class="bg-white rounded-lg shadow-lg p-12">
                    <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Pesanan</h3>
                    <p class="text-gray-600 mb-6">Anda belum pernah melakukan pemesanan apapun</p>
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
@endsection