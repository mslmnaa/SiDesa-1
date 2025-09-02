@extends('layouts.app')

@section('title', 'Profile - BUMDes Marketplace')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Profile</h1>
            <p class="text-gray-600 mt-2">Kelola informasi profil dan riwayat aktivitas Anda</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8" x-data="{ activeTab: '{{ request()->get('tab', 'profil') }}' }">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-white font-bold text-xl">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">{{ auth()->user()->name }}</h3>
                                <p class="text-sm text-gray-600">{{ ucfirst(auth()->user()->role) }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Menu Navigation -->
                    <nav class="p-4">
                        <ul class="space-y-2">
                            <li>
                                <button @click="activeTab = 'profil'" 
                                        :class="activeTab === 'profil' ? 'bg-green-50 text-green-700 border-green-200' : 'text-gray-700 hover:bg-gray-50'"
                                        class="w-full flex items-center px-4 py-3 text-left rounded-lg border transition-colors">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Profil
                                </button>
                            </li>
                            <li>
                                <button @click="activeTab = 'orders'" 
                                        :class="activeTab === 'orders' ? 'bg-green-50 text-green-700 border-green-200' : 'text-gray-700 hover:bg-gray-50'"
                                        class="w-full flex items-center px-4 py-3 text-left rounded-lg border transition-colors">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    Riwayat Pesanan
                                </button>
                            </li>
                            <li>
                                <button @click="activeTab = 'infaq'" 
                                        :class="activeTab === 'infaq' ? 'bg-green-50 text-green-700 border-green-200' : 'text-gray-700 hover:bg-gray-50'"
                                        class="w-full flex items-center px-4 py-3 text-left rounded-lg border transition-colors">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                    </svg>
                                    Riwayat Infaq
                                </button>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <!-- Profil Tab -->
                    <div x-show="activeTab === 'profil'" x-transition>
                        <div class="p-8">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-2xl font-bold text-gray-900">Informasi Profil</h2>
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                    {{ ucfirst(auth()->user()->role) }}
                                </span>
                            </div>

                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                        <input id="name" name="name" type="text" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('name') border-red-500 @enderror"
                                               value="{{ old('name', auth()->user()->name) }}">
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                        <input id="email" name="email" type="email" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('email') border-red-500 @enderror"
                                               value="{{ old('email', auth()->user()->email) }}">
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                        <input id="phone" name="phone" type="tel"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('phone') border-red-500 @enderror"
                                               value="{{ old('phone', auth()->user()->phone) }}">
                                        @error('phone')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Bergabung</label>
                                        <input type="text" value="{{ auth()->user()->created_at->format('d M Y') }}" disabled
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600">
                                    </div>
                                </div>

                                <div class="mb-6">
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                                    <textarea id="address" name="address" rows="3"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('address') border-red-500 @enderror">{{ old('address', auth()->user()->address) }}</textarea>
                                    @error('address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Password Change Section -->
                                <div class="border-t border-gray-200 pt-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ubah Password</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                                            <input id="password" name="password" type="password"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('password') border-red-500 @enderror"
                                                   placeholder="Kosongkan jika tidak ingin mengubah">
                                            @error('password')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                                            <input id="password_confirmation" name="password_confirmation" type="password"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                                   placeholder="Ulangi password baru">
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                                    <a href="{{ route('home') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                        Batal
                                    </a>
                                    <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-colors">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Orders Tab -->
                    <div x-show="activeTab === 'orders'" x-transition>
                        <div class="p-8">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-2xl font-bold text-gray-900">Riwayat Pesanan</h2>
                                <a href="{{ route('products.index') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    Belanja Sekarang
                                </a>
                            </div>
                            
                            @if($orders->count() > 0)
                                <div class="space-y-4">
                                    @foreach($orders as $order)
                                        <div class="bg-gray-50 rounded-xl border border-gray-200 overflow-hidden">
                                            <!-- Order Header -->
                                            <div class="px-6 py-4 border-b border-gray-200 bg-white">
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
                                            <div class="px-6 py-4 bg-white">
                                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                                    @foreach($order->orderItems->take(3) as $item)
                                                        <div class="flex items-center space-x-3">
                                                            <div class="flex-shrink-0">
                                                                @if($item->product->images && count($item->product->images) > 0)
                                                                    <img src="{{ $item->product->getImageDataUri(0) }}" 
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Pagination -->
                                <div class="mt-6">
                                    {{ $orders->appends(request()->query())->fragment('orders')->links() }}
                                </div>
                                
                                <div class="mt-6 text-center">
                                    <a href="{{ route('user.orders.index') }}" class="text-green-600 hover:text-green-800 font-medium">
                                        Lihat Semua Riwayat Pesanan →
                                    </a>
                                </div>
                            @else
                                <!-- Empty Orders -->
                                <div class="text-center py-12">
                                    <div class="w-20 h-20 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Belum Ada Pesanan</h3>
                                    <p class="text-gray-600 mb-6">Anda belum pernah melakukan pemesanan apapun</p>
                                    <a href="{{ route('products.index') }}" 
                                       class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                        Mulai Berbelanja
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Infaq Tab -->
                    <div x-show="activeTab === 'infaq'" x-transition>
                        <div class="p-8">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-2xl font-bold text-gray-900">Riwayat Infaq</h2>
                                <a href="{{ route('infaq.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Infaq Baru
                                </a>
                            </div>
                            
                            @if($infaqs->count() > 0)
                                <div class="space-y-4">
                                    @foreach($infaqs as $infaq)
                                        <div class="bg-gray-50 rounded-xl border border-gray-200 overflow-hidden">
                                            <div class="p-6">
                                                <div class="flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <!-- Status Badge -->
                                                        <div class="flex items-center gap-3 mb-4">
                                                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                                {{ $infaq->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                                   ($infaq->status === 'verified' ? 'bg-blue-100 text-blue-800' : 
                                                                   ($infaq->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                                   'bg-red-100 text-red-800')) }}">
                                                                {{ $infaq->status_label }}
                                                            </span>
                                                            <span class="text-sm text-gray-500">
                                                                {{ $infaq->created_at->format('d M Y, H:i') }}
                                                            </span>
                                                        </div>

                                                        <!-- Amount and Payment Method -->
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                            <div>
                                                                <p class="text-sm text-gray-600">Jumlah Donasi</p>
                                                                <p class="text-xl font-bold text-green-600">
                                                                    Rp {{ number_format($infaq->amount, 0, ',', '.') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <p class="text-sm text-gray-600">Metode Pembayaran</p>
                                                                <p class="text-base font-semibold text-gray-900">
                                                                    {{ $infaq->payment_method_label }}
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <!-- Message -->
                                                        @if($infaq->message)
                                                            <div class="mb-4">
                                                                <p class="text-sm text-gray-600 mb-1">Pesan</p>
                                                                <p class="text-gray-900 bg-white rounded-lg p-3 border">
                                                                    "{{ $infaq->message }}"
                                                                </p>
                                                            </div>
                                                        @endif

                                                        <!-- Anonymous Status -->
                                                        @if($infaq->anonymous)
                                                            <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.464 6.464M9.878 9.878a3 3 0 00-4.243 4.243m7.073 7.073L6.464 6.464M19.072 19.072L6.464 6.464"/>
                                                                </svg>
                                                                Donasi Anonim
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <!-- Action Button -->
                                                    <div class="ml-4">
                                                        <a href="{{ route('infaq.show', $infaq) }}" 
                                                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                            </svg>
                                                            Detail
                                                        </a>
                                                    </div>
                                                </div>

                                                <!-- Payment Proof Preview -->
                                                @if($infaq->payment_proof)
                                                    <div class="mt-4 pt-4 border-t border-gray-200">
                                                        <p class="text-sm text-gray-600 mb-2">Bukti Pembayaran</p>
                                                        <img src="{{ asset('storage/' . $infaq->payment_proof) }}" 
                                                             alt="Bukti Pembayaran"
                                                             class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Pagination -->
                                <div class="mt-6">
                                    {{ $infaqs->appends(request()->query())->fragment('infaq')->links() }}
                                </div>
                                
                                <div class="mt-6 text-center">
                                    <a href="{{ route('user.infaq.index') }}" class="text-green-600 hover:text-green-800 font-medium">
                                        Lihat Semua Riwayat Infaq →
                                    </a>
                                </div>
                            @else
                                <!-- Empty State -->
                                <div class="text-center py-12">
                                    <div class="w-20 h-20 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Belum Ada Riwayat Infaq</h3>
                                    <p class="text-gray-600 mb-6">Anda belum pernah melakukan donasi infaq. Mulai berbagi kebaikan sekarang!</p>
                                    <a href="{{ route('infaq.create') }}" 
                                       class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        Mulai Berinfaq
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection