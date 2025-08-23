@extends('layouts.admin')

@section('title', 'User: ' . $user->name)

@section('content')
<!-- Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
        <p class="text-gray-600 mt-2">Detail lengkap informasi user</p>
    </div>
    <div class="space-x-3">
        @if($user->id !== auth()->id())
            <a href="{{ route('admin.users.edit', $user) }}" 
               class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                Edit User
            </a>
        @else
            <a href="{{ route('profile') }}" 
               class="bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                Edit Profile
            </a>
        @endif
        <a href="{{ route('admin.users.index') }}" 
           class="bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition-colors">
            Kembali
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- User Profile -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center space-x-6 mb-6">
                <div class="w-24 h-24 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center">
                    <span class="text-white font-bold text-3xl">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </span>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">
                        {{ $user->name }}
                        @if($user->id === auth()->id())
                            <span class="ml-2 text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded-full">Anda</span>
                        @endif
                    </h2>
                    <p class="text-gray-600">{{ $user->email }}</p>
                    <div class="mt-2">
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                            {{ $user->role === 'superadmin' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $user->role === 'admin' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $user->role === 'user' ? 'bg-green-100 text-green-800' : '' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- User Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-gray-900 mb-3">Informasi Kontak</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email:</span>
                            <span class="text-gray-900">{{ $user->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Telepon:</span>
                            <span class="text-gray-900">{{ $user->phone ?? '-' }}</span>
                        </div>
                        @if($user->address)
                            <div>
                                <span class="text-gray-600">Alamat:</span>
                                <p class="text-gray-900 mt-1">{{ $user->address }}</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div>
                    <h3 class="font-semibold text-gray-900 mb-3">Informasi Account</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">User ID:</span>
                            <span class="text-gray-900">#{{ $user->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Role:</span>
                            <span class="font-medium text-gray-900">{{ ucfirst($user->role) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="text-green-600 font-medium">
                                {{ $user->email_verified_at ? 'Verified' : 'Unverified' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Bergabung:</span>
                            <span class="text-gray-900">{{ $user->created_at->format('d M Y') }}</span>
                        </div>
                        @if($user->updated_at != $user->created_at)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Terakhir Update:</span>
                                <span class="text-gray-900">{{ $user->updated_at->format('d M Y, H:i') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Orders -->
        @if($recentOrders->count() > 0)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <h2 class="text-xl font-semibold text-gray-900">Pesanan Terbaru</h2>
                </div>
                
                <div class="divide-y divide-gray-200">
                    @foreach($recentOrders as $order)
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $order->order_number }}</h3>
                                    <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-green-600">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </p>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $order->status === 'shipped' ? 'bg-purple-100 text-purple-800' : '' }}
                                        {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Order Items Preview -->
                            <div class="flex space-x-2">
                                @foreach($order->orderItems->take(4) as $item)
                                    <div class="flex-shrink-0 w-12 h-12 rounded-lg overflow-hidden border">
                                        @if($item->product && $item->product->images && count($item->product->images) > 0)
                                            <img src="{{ Storage::url($item->product->images[0]) }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                @if($order->orderItems->count() > 4)
                                    <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center">
                                        <span class="text-xs font-medium text-gray-600">
                                            +{{ $order->orderItems->count() - 4 }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-sm text-gray-500">{{ $order->orderItems->count() }} item(s)</span>
                                <a href="{{ route('admin.orders.show', $order) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Lihat Detail →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    
    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Statistics -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Statistik</h2>
            
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Pesanan:</span>
                    <span class="font-semibold text-gray-900">{{ $user->orders_count }}</span>
                </div>
                
                @if($user->orders_count > 0)
                    @php
                        $totalSpent = $user->orders()->sum('total_amount');
                        $avgOrderValue = $user->orders_count > 0 ? $totalSpent / $user->orders_count : 0;
                        $lastOrder = $user->orders()->latest()->first();
                    @endphp
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Belanja:</span>
                        <span class="font-semibold text-green-600">
                            Rp {{ number_format($totalSpent, 0, ',', '.') }}
                        </span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Rata-rata per Order:</span>
                        <span class="font-semibold text-gray-900">
                            Rp {{ number_format($avgOrderValue, 0, ',', '.') }}
                        </span>
                    </div>
                    
                    @if($lastOrder)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Pesanan Terakhir:</span>
                            <span class="text-gray-900">{{ $lastOrder->created_at->diffForHumans() }}</span>
                        </div>
                    @endif
                @endif
            </div>
        </div>
        
        <!-- Role Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Role & Permissions</h3>
            
            <div class="space-y-3">
                <div class="text-center">
                    <span class="inline-flex px-4 py-2 text-lg font-semibold rounded-full 
                        {{ $user->role === 'superadmin' ? 'bg-red-100 text-red-800' : '' }}
                        {{ $user->role === 'admin' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $user->role === 'user' ? 'bg-green-100 text-green-800' : '' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
                
                <div class="text-sm text-gray-600">
                    @if($user->role === 'superadmin')
                        <h4 class="font-medium text-gray-900 mb-2">Super Administrator</h4>
                        <ul class="space-y-1">
                            <li>• Akses penuh ke semua fitur</li>
                            <li>• Dapat mengelola user dan admin</li>
                            <li>• Dapat mengubah role user lain</li>
                            <li>• Akses ke semua data sistem</li>
                        </ul>
                    @elseif($user->role === 'admin')
                        <h4 class="font-medium text-gray-900 mb-2">Administrator</h4>
                        <ul class="space-y-1">
                            <li>• Mengelola produk dan kategori</li>
                            <li>• Mengelola pesanan pelanggan</li>
                            <li>• Akses dashboard admin</li>
                            <li>• Kelola konten landing page</li>
                        </ul>
                    @else
                        <h4 class="font-medium text-gray-900 mb-2">Regular User</h4>
                        <ul class="space-y-1">
                            <li>• Berbelanja produk</li>
                            <li>• Mengelola keranjang belanja</li>
                            <li>• Melihat riwayat pesanan</li>
                            <li>• Update profil pribadi</li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            
            <div class="space-y-3">
                @if($user->id !== auth()->id())
                    <a href="{{ route('admin.users.edit', $user) }}" 
                       class="w-full bg-green-600 text-white py-2 px-4 rounded-lg text-center font-medium hover:bg-green-700 transition-colors block">
                        Edit User
                    </a>
                    
                    @if($user->orders_count == 0)
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                              onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }}? Aksi ini tidak dapat dibatalkan!')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-red-700 transition-colors">
                                Hapus User
                            </button>
                        </form>
                    @else
                        <div class="w-full bg-gray-300 text-gray-500 py-2 px-4 rounded-lg text-center font-medium cursor-not-allowed">
                            Tidak Dapat Dihapus
                        </div>
                        <p class="text-xs text-gray-500 text-center">User memiliki riwayat pesanan</p>
                    @endif
                @else
                    <a href="{{ route('profile') }}" 
                       class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg text-center font-medium hover:bg-purple-700 transition-colors block">
                        Edit Profile Saya
                    </a>
                @endif
                
                @if($user->orders_count > 0)
                    <a href="{{ route('admin.orders.index') }}?search={{ urlencode($user->email) }}" 
                       class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg text-center font-medium hover:bg-blue-700 transition-colors block">
                        Lihat Semua Pesanan
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection