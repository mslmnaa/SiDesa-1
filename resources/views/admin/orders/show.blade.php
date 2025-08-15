@extends('layouts.admin')

@section('title', 'Pesanan #' . $order->order_number)

@section('content')
<!-- Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Pesanan #{{ $order->order_number }}</h1>
        <p class="text-gray-600 mt-2">Detail lengkap pesanan dari {{ $order->customer_name }}</p>
    </div>
    <div class="space-x-3">
        <a href="{{ route('admin.orders.edit', $order) }}" 
           class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
            Edit Status
        </a>
        <a href="{{ route('admin.orders.index') }}" 
           class="bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition-colors">
            Kembali
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
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
                                <p class="text-sm text-gray-500 mb-2">{{ $item->product->category->name ?? 'No Category' }}</p>
                                <div class="flex items-center space-x-4 text-sm text-gray-600">
                                    <span>Qty: {{ $item->quantity }}</span>
                                    <span>×</span>
                                    <span>Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                </div>
                                
                                <!-- Current stock info -->
                                <div class="mt-2 text-sm">
                                    <span class="text-gray-500">Stok saat ini: </span>
                                    <span class="{{ $item->product->stock <= 10 ? 'text-red-600 font-medium' : 'text-gray-700' }}">
                                        {{ $item->product->stock }}
                                    </span>
                                    @if($item->product->stock <= 10)
                                        <span class="text-red-500 text-xs ml-1">(Low Stock)</span>
                                    @endif
                                </div>
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

        <!-- Order Timeline -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Status Timeline Pesanan</h2>
            
            <div class="relative">
                <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                
                <div class="relative space-y-6">
                    <!-- Order Created -->
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
                        <div class="flex-shrink-0 w-8 h-8 rounded-full {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'bg-green-500' : ($order->status === 'cancelled' ? 'bg-red-500' : 'bg-gray-300') }} flex items-center justify-center">
                            @if($order->status === 'cancelled')
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">
                                {{ $order->status === 'cancelled' ? 'Pesanan Dibatalkan' : 'Dikonfirmasi & Diproses' }}
                            </h3>
                            <p class="text-sm text-gray-500">
                                @if($order->status === 'cancelled')
                                    Pesanan telah dibatalkan
                                @elseif(in_array($order->status, ['processing', 'shipped', 'delivered']))
                                    Pesanan sedang diproses oleh admin
                                @else
                                    Menunggu konfirmasi dari admin
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($order->status !== 'cancelled')
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
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Order Status -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Status Pesanan</h2>
            
            <div class="text-center mb-4">
                <div class="inline-flex px-4 py-2 rounded-full text-lg font-semibold
                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                    {{ $order->status === 'shipped' ? 'bg-purple-100 text-purple-800' : '' }}
                    {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                    {{ ucfirst($order->status) }}
                </div>
            </div>
            
            <!-- Quick Status Update -->
            <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="space-y-3">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Update Status:</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Diproses</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Dikirim</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                
                <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition-colors">
                    Update Status
                </button>
            </form>
        </div>

        <!-- Customer Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Pelanggan</h2>
            
            <div class="space-y-3">
                <div>
                    <p class="text-sm font-medium text-gray-700">Nama</p>
                    <p class="text-gray-900">{{ $order->customer_name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-700">Telepon</p>
                    <p class="text-gray-900">{{ $order->customer_phone }}</p>
                </div>
                @if($order->user)
                    <div>
                        <p class="text-sm font-medium text-gray-700">Email (User Account)</p>
                        <p class="text-blue-600">{{ $order->user->email }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Shipping Address -->
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

        <!-- Order Info -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="font-semibold text-gray-900 mb-2">Informasi Pesanan</h3>
            <div class="text-sm text-gray-600 space-y-1">
                <p>Order ID: #{{ $order->id }}</p>
                <p>Dibuat: {{ $order->created_at->format('d M Y, H:i') }}</p>
                @if($order->updated_at != $order->created_at)
                    <p>Diupdate: {{ $order->updated_at->format('d M Y, H:i') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection