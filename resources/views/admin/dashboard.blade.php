@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Users -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalUsers) }}</p>
                <p class="text-sm text-gray-600">Total Users</p>
            </div>
        </div>
    </div>

    <!-- Total Products -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalProducts) }}</p>
                <p class="text-sm text-gray-600">Total Produk</p>
            </div>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalOrders) }}</p>
                <p class="text-sm text-gray-600">Total Pesanan</p>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-2xl font-semibold text-gray-900">Rp {{ number_format($totalRevenue) }}</p>
                <p class="text-sm text-gray-600">Total Pendapatan</p>
            </div>
        </div>
    </div>
</div>

<!-- Infaq Statistics Section -->
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-semibold text-gray-900">Statistik Infaq</h3>
        <a href="{{ route('admin.infaq.index') }}" class="text-green-600 hover:text-green-800 font-medium">
            Kelola Infaq →
        </a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <!-- Pending Infaq -->
        <div class="text-center p-4 bg-yellow-50 rounded-lg">
            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-2xl font-bold text-yellow-600">{{ $infaqStats['total_pending'] }}</p>
            <p class="text-sm text-yellow-800">Menunggu Verifikasi</p>
        </div>
        
        <!-- Verified Infaq -->
        <div class="text-center p-4 bg-blue-50 rounded-lg">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-2xl font-bold text-blue-600">{{ $infaqStats['total_verified'] }}</p>
            <p class="text-sm text-blue-800">Terverifikasi</p>
        </div>
        
        <!-- Completed Infaq -->
        <div class="text-center p-4 bg-green-50 rounded-lg">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <p class="text-2xl font-bold text-green-600">{{ $infaqStats['total_completed'] }}</p>
            <p class="text-sm text-green-800">Selesai Disalurkan</p>
        </div>
        
        <!-- Total Donors -->
        <div class="text-center p-4 bg-purple-50 rounded-lg">
            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <p class="text-2xl font-bold text-purple-600">{{ $infaqStats['total_donors'] }}</p>
            <p class="text-sm text-purple-800">Total Donatur</p>
        </div>
        
        <!-- Total Amount -->
        <div class="text-center p-4 bg-emerald-50 rounded-lg">
            <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </div>
            <p class="text-lg font-bold text-emerald-600">Rp {{ number_format($infaqStats['total_amount_collected'], 0, ',', '.') }}</p>
            <p class="text-sm text-emerald-800">Dana Terkumpul</p>
        </div>
    </div>
    
    @if($infaqStats['total_pending'] > 0)
        <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <p class="text-yellow-800">
                    <strong>{{ $infaqStats['total_pending'] }} donasi</strong> menunggu verifikasi Anda.
                    <a href="{{ route('admin.infaq.index', ['status' => 'pending']) }}" class="font-medium underline hover:no-underline">Verifikasi sekarang</a>
                </p>
            </div>
        </div>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Recent Orders -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold text-gray-900">Pesanan Terbaru</h3>
        </div>
        <div class="p-6">
            @if($recentOrders->count() > 0)
                <div class="space-y-4">
                    @foreach($recentOrders as $order)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">{{ $order->order_number }}</p>
                                <p class="text-sm text-gray-600">{{ $order->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-green-600">Rp {{ number_format($order->total_amount) }}</p>
                                <span class="text-xs px-2 py-1 rounded-full
                                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                    @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                                    @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Lihat Semua Pesanan
                    </a>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada pesanan</p>
            @endif
        </div>
    </div>

    <!-- Top Products -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold text-gray-900">Produk Terlaris</h3>
        </div>
        <div class="p-6">
            @if($topProducts->count() > 0)
                <div class="space-y-4">
                    @foreach($topProducts as $product)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    @if($product->images && count($product->images) > 0)
                                        <img src="{{ $product->getImageDataUri(0) }}" alt="{{ $product->name }}" class="w-10 h-10 object-cover rounded">
                                    @else
                                        <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 text-sm">{{ Str::limit($product->name, 30) }}</p>
                                    <p class="text-xs text-gray-500">Stok: {{ $product->stock }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900 text-sm">{{ $product->total_sold }} terjual</p>
                                <p class="text-xs text-green-600">Rp {{ number_format($product->price) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Kelola Produk
                    </a>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada produk</p>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Low Stock Alert -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold text-gray-900">Stok Menipis</h3>
        </div>
        <div class="p-6">
            @if($lowStockProducts->count() > 0)
                <div class="space-y-3">
                    @foreach($lowStockProducts as $product)
                        <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900 text-sm">{{ Str::limit($product->name, 35) }}</p>
                                <p class="text-xs text-gray-600">{{ $product->category->name ?? 'No Category' }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-semibold text-red-600">{{ $product->stock }} tersisa</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('admin.products.index') }}?low_stock=1" class="text-red-600 hover:text-red-800 text-sm font-medium">
                        Update Stok Produk
                    </a>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Semua produk stok aman</p>
            @endif
        </div>
    </div>

    <!-- Orders by Status -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold text-gray-900">Status Pesanan</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Pending</span>
                    <div class="flex items-center">
                        <span class="font-semibold text-yellow-600">{{ $ordersByStatus['pending'] ?? 0 }}</span>
                        <div class="ml-2 w-20 bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $totalOrders > 0 ? (($ordersByStatus['pending'] ?? 0) / $totalOrders) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Processing</span>
                    <div class="flex items-center">
                        <span class="font-semibold text-blue-600">{{ $ordersByStatus['processing'] ?? 0 }}</span>
                        <div class="ml-2 w-20 bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $totalOrders > 0 ? (($ordersByStatus['processing'] ?? 0) / $totalOrders) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Shipped</span>
                    <div class="flex items-center">
                        <span class="font-semibold text-purple-600">{{ $ordersByStatus['shipped'] ?? 0 }}</span>
                        <div class="ml-2 w-20 bg-gray-200 rounded-full h-2">
                            <div class="bg-purple-500 h-2 rounded-full" style="width: {{ $totalOrders > 0 ? (($ordersByStatus['shipped'] ?? 0) / $totalOrders) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Delivered</span>
                    <div class="flex items-center">
                        <span class="font-semibold text-green-600">{{ $ordersByStatus['delivered'] ?? 0 }}</span>
                        <div class="ml-2 w-20 bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $totalOrders > 0 ? (($ordersByStatus['delivered'] ?? 0) / $totalOrders) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection