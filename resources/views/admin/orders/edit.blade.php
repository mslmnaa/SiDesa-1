@extends('layouts.admin')

@section('title', 'Edit Pesanan #' . $order->order_number)

@section('content')
<!-- Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Edit Pesanan #{{ $order->order_number }}</h1>
        <p class="text-gray-600 mt-2">Update status dan informasi pesanan</p>
    </div>
    <div class="space-x-3">
        <a href="{{ route('admin.orders.show', $order) }}" 
           class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
            Lihat Detail
        </a>
        <a href="{{ route('admin.orders.index') }}" 
           class="bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition-colors">
            Kembali
        </a>
    </div>
</div>

<form action="{{ route('admin.orders.update', $order) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Status -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Status Pesanan</h2>
                
                <div class="space-y-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status Pesanan *
                        </label>
                        <select id="status" name="status" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('status') border-red-500 @enderror">
                            <option value="pending" {{ old('status', $order->status) === 'pending' ? 'selected' : '' }}>
                                Pending - Menunggu Konfirmasi
                            </option>
                            <option value="processing" {{ old('status', $order->status) === 'processing' ? 'selected' : '' }}>
                                Processing - Sedang Diproses
                            </option>
                            <option value="shipped" {{ old('status', $order->status) === 'shipped' ? 'selected' : '' }}>
                                Shipped - Sedang Dikirim
                            </option>
                            <option value="delivered" {{ old('status', $order->status) === 'delivered' ? 'selected' : '' }}>
                                Delivered - Sudah Sampai
                            </option>
                            <option value="cancelled" {{ old('status', $order->status) === 'cancelled' ? 'selected' : '' }}>
                                Cancelled - Dibatalkan
                            </option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Status Description -->
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <h4 class="font-medium text-blue-900 mb-2">Panduan Status:</h4>
                        <ul class="text-sm text-blue-800 space-y-1">
                            <li><strong>Pending:</strong> Pesanan baru masuk, menunggu konfirmasi admin</li>
                            <li><strong>Processing:</strong> Pesanan dikonfirmasi dan sedang disiapkan</li>
                            <li><strong>Shipped:</strong> Pesanan sudah dikirim ke alamat pelanggan</li>
                            <li><strong>Delivered:</strong> Pesanan sudah sampai di tujuan</li>
                            <li><strong>Cancelled:</strong> Pesanan dibatalkan (stok akan dikembalikan)</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Order Notes -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Catatan Admin</h2>
                
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan Internal (Opsional)
                    </label>
                    <textarea id="notes" name="notes" rows="4"
                              placeholder="Tambahkan catatan internal untuk pesanan ini..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('notes') border-red-500 @enderror">{{ old('notes', $order->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        Catatan ini hanya untuk admin dan tidak terlihat oleh pelanggan.
                    </p>
                </div>
            </div>
            
            <!-- Order Items (Read Only) -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <h2 class="text-xl font-semibold text-gray-900">Produk yang Dipesan</h2>
                    <p class="text-sm text-gray-600 mt-1">Informasi ini tidak dapat diubah</p>
                </div>
                
                <div class="divide-y divide-gray-200">
                    @foreach($order->orderItems as $item)
                        <div class="p-6 bg-gray-50">
                            <div class="flex items-center space-x-4">
                                <!-- Product Image -->
                                <div class="flex-shrink-0">
                                    @if($item->product->images && count($item->product->images) > 0)
                                        <img src="{{ Storage::url($item->product->images[0]) }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="w-16 h-16 object-cover rounded-lg">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Product Info -->
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-medium text-gray-900 mb-1">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $item->product->category->name ?? 'No Category' }}</p>
                                    <div class="flex items-center space-x-4 text-sm text-gray-600 mt-1">
                                        <span>Qty: {{ $item->quantity }}</span>
                                        <span>×</span>
                                        <span>Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                
                                <!-- Subtotal -->
                                <div class="text-right">
                                    <p class="font-medium text-gray-900">
                                        Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Current Status -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Saat Ini</h3>
                
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
                
                <div class="text-sm text-gray-600 text-center">
                    Diupdate: {{ $order->updated_at->format('d M Y, H:i') }}
                </div>
            </div>
            
            <!-- Customer Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pelanggan</h3>
                
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="font-medium text-gray-700">Nama:</span>
                        <span class="text-gray-900 ml-2">{{ $order->customer_name }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Telepon:</span>
                        <span class="text-gray-900 ml-2">{{ $order->customer_phone }}</span>
                    </div>
                    @if($order->user)
                        <div>
                            <span class="font-medium text-gray-700">Email:</span>
                            <span class="text-blue-600 ml-2">{{ $order->user->email }}</span>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h3>
                
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Order ID:</span>
                        <span class="font-medium">#{{ $order->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Item:</span>
                        <span class="font-medium">{{ $order->orderItems->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-medium">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Ongkir:</span>
                        <span class="font-medium text-green-600">GRATIS</span>
                    </div>
                    <hr>
                    <div class="flex justify-between text-base">
                        <span class="font-semibold">Total:</span>
                        <span class="font-bold text-green-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Submit Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="space-y-3">
                    <button type="submit" 
                            class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                        Simpan Perubahan
                    </button>
                    
                    <a href="{{ route('admin.orders.show', $order) }}" 
                       class="w-full bg-gray-500 text-white py-3 px-4 rounded-lg font-semibold hover:bg-gray-600 transition-colors text-center block">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection