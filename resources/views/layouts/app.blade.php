<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BUMDes Marketplace')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <!-- Mobile Header Text -->
        <div class="md:hidden bg-primary-50 py-2">
            <div class="text-center">
                <a href="{{ route('home') }}" class="text-sm font-bold text-primary-600">
                    BUMDes Marketplace
                </a>
            </div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex justify-between items-center py-3 md:py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-lg md:text-2xl font-bold text-primary-500">
                        <span class="hidden md:inline">BUMDes Marketplace</span>
                    </a>
                </div>

                <!-- Navigation Links - Same layout for all devices, just smaller on mobile -->
                <div class="flex items-center space-x-3 md:space-x-6">
                    <a href="{{ route('home') }}" class="text-secondary-700 hover:text-primary-500 transition-colors text-xs md:text-base">
                        Beranda
                    </a>
                    
                    <!-- Products Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center text-gray-700 hover:text-green-600 transition-colors text-xs md:text-base">
                            <span>Produk</span>
                            <svg class="w-3 h-3 md:w-4 md:h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition class="absolute left-0 mt-2 w-36 md:w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <a href="{{ route('products.index') }}" class="block px-3 md:px-4 py-1.5 md:py-2 text-xs md:text-sm text-gray-700 hover:bg-gray-100">
                                Semua Produk
                            </a>
                            <a href="{{ route('products.type', 'barang') }}" class="block px-3 md:px-4 py-1.5 md:py-2 text-xs md:text-sm text-gray-700 hover:bg-gray-100">
                                Produk Barang
                            </a>
                            <a href="{{ route('products.type', 'jasa') }}" class="block px-3 md:px-4 py-1.5 md:py-2 text-xs md:text-sm text-gray-700 hover:bg-gray-100">
                                Produk Jasa
                            </a>
                        </div>
                    </div>
                    
                    <a href="{{ route('infaq') }}" class="text-gray-700 hover:text-green-600 transition-colors text-xs md:text-base">
                        Infaq Online
                    </a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-green-600 transition-colors text-xs md:text-base">
                        Kontak
                    </a>
                </div>

                <!-- Right Side -->
                <div class="flex items-center space-x-1 md:space-x-4">
                    <!-- Cart - Always visible -->
                    <a href="{{ route('user.cart.index') }}" class="relative text-gray-700 hover:text-green-600 transition-colors p-1 md:p-2">
                        <svg class="w-4 h-4 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M17 13l-1.5 6M9 19.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM20.5 19.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-3 w-3 md:h-5 md:w-5 flex items-center justify-center text-xs md:text-sm" id="cart-count">
                            {{ auth()->check() ? auth()->user()->carts->sum('quantity') : 0 }}
                        </span>
                    </a>

                    <!-- User Menu - Same layout for all devices, just smaller on mobile -->
                    <div class="flex items-center space-x-1 md:space-x-4">
                        @auth
                            <!-- User Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center text-secondary-700 hover:text-primary-500 transition-colors text-xs md:text-base">
                                    <span class="mr-1 md:mr-2 max-w-16 md:max-w-32 truncate">{{ auth()->user()->name }}</span>
                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-36 md:w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="block px-3 md:px-4 py-1.5 md:py-2 text-xs md:text-sm text-secondary-700 hover:bg-cream">
                                            Dashboard Admin
                                        </a>
                                    @endif
                                    <a href="{{ route('profile') }}" class="block px-3 md:px-4 py-1.5 md:py-2 text-xs md:text-sm text-secondary-700 hover:bg-cream">
                                        Profile
                                    </a>
                                    <a href="{{ route('user.orders.index') }}" class="block px-3 md:px-4 py-1.5 md:py-2 text-xs md:text-sm text-gray-700 hover:bg-gray-100">
                                        Riwayat Pesanan
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-3 md:px-4 py-1.5 md:py-2 text-xs md:text-sm text-secondary-700 hover:bg-cream">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-secondary-700 hover:text-primary-500 transition-colors text-xs md:text-sm">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="bg-primary-500 text-white px-2 md:px-3 py-1 md:py-2 rounded-md hover:bg-primary-600 transition-colors text-xs md:text-sm">
                                Daftar
                            </a>
                        @endauth
                    </div>

                </div>
            </div>

            <!-- Additional Mobile User Menu (only for authenticated users) - Hidden on mobile -->
            @auth
                <div class="hidden">
                    <div class="px-4 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <span class="text-sm font-medium text-gray-800">{{ auth()->user()->name }}</span>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="text-xs bg-primary-100 text-primary-600 px-2 py-1 rounded">
                                    Admin
                                </a>
                            @endif
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('user.orders.index') }}" class="text-xs text-gray-600 hover:text-primary-500">
                                Pesanan
                            </a>
                            <a href="{{ route('profile') }}" class="text-xs text-gray-600 hover:text-primary-500">
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-xs text-red-600 hover:text-red-800">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="md:hidden border-t border-gray-200 py-2 bg-gray-50">
                    <div class="px-4 flex items-center justify-center space-x-3">
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-primary-500">
                            Login
                        </a>
                        <span class="text-gray-300">|</span>
                        <a href="{{ route('register') }}" class="text-sm bg-primary-500 text-white px-3 py-1 rounded hover:bg-primary-600">
                            Daftar
                        </a>
                    </div>
                </div>
            @endauth
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-primary-50 border border-primary-400 text-primary-700 px-4 py-3 rounded relative max-w-7xl mx-auto mt-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-accent-100 border border-accent-400 text-accent-700 px-4 py-3 rounded relative max-w-7xl mx-auto mt-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Floating Help Widget -->
    <div class="fixed bottom-4 right-4 z-50" x-data="{ helpOpen: false }">
        <!-- Help Button -->
        <button @click="helpOpen = !helpOpen" 
                class="bg-green-600 hover:bg-green-700 text-white rounded-full p-3 shadow-lg transform transition-all duration-200 hover:scale-110"
                :class="{ 'rotate-180': helpOpen }">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </button>

        <!-- Help Panel -->
        <div x-show="helpOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             @click.away="helpOpen = false"
             class="absolute bottom-16 right-0 w-80 md:w-96 bg-white rounded-lg shadow-2xl border border-gray-200 max-h-96 overflow-hidden">
            
            <!-- Header -->
            <div class="bg-green-600 text-white p-4 rounded-t-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="font-semibold">Bantuan & Panduan</h3>
                    </div>
                    <button @click="helpOpen = false" class="text-white hover:text-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="p-4 overflow-y-auto max-h-80">
                <div class="space-y-4">
                    <!-- Welcome Section -->
                    <div class="bg-blue-50 p-3 rounded-lg">
                        <h4 class="font-semibold text-blue-900 mb-2">Selamat Datang di BUMDes Marketplace!</h4>
                        <p class="text-sm text-blue-800">Platform belanja online untuk produk dan jasa unggulan desa.</p>
                    </div>

                    <!-- Step by Step Guide -->
                    <div class="space-y-3">
                        <h4 class="font-semibold text-gray-900 border-b pb-2">Cara Berbelanja:</h4>
                        
                        <!-- Step 1 -->
                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-semibold">1</div>
                            <div>
                                <h5 class="font-medium text-sm">Jelajahi Produk</h5>
                                <p class="text-xs text-gray-600">Klik menu "Produk" untuk melihat semua produk barang dan jasa tersedia.</p>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-semibold">2</div>
                            <div>
                                <h5 class="font-medium text-sm">Tambah ke Keranjang</h5>
                                <p class="text-xs text-gray-600">Pilih produk yang diinginkan, atur jumlah, lalu klik "Tambah ke Keranjang".</p>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-semibold">3</div>
                            <div>
                                <h5 class="font-medium text-sm">Daftar/Masuk Akun</h5>
                                <p class="text-xs text-gray-600">Buat akun atau masuk untuk melanjutkan ke checkout.</p>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-semibold">4</div>
                            <div>
                                <h5 class="font-medium text-sm">Checkout & Pembayaran</h5>
                                <p class="text-xs text-gray-600">Isi data lengkap, pilih metode pembayaran, dan selesaikan transaksi.</p>
                            </div>
                        </div>

                        <!-- Step 5 -->
                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-semibold">5</div>
                            <div>
                                <h5 class="font-medium text-sm">Pantau Pesanan</h5>
                                <p class="text-xs text-gray-600 mb-2">Cek status pesanan melalui:</p>
                                <div class="text-xs text-gray-600 space-y-1">
                                    <div class="flex items-center">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                        <span><strong>Desktop:</strong> Klik nama Anda → pilih "Riwayat Pesanan"</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                        <span><strong>Mobile:</strong> Klik nama Anda (di navbar) → "Riwayat Pesanan"</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="border-t pt-3">
                        <h4 class="font-semibold text-gray-900 mb-2">Menu Utama:</h4>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <a href="{{ route('products.index') }}" class="bg-gray-100 p-2 rounded text-center hover:bg-gray-200 transition-colors">
                                🛍️ Produk
                            </a>
                            <a href="{{ route('infaq') }}" class="bg-gray-100 p-2 rounded text-center hover:bg-gray-200 transition-colors">
                                💝 Infaq Online
                            </a>
                            <a href="{{ route('user.cart.index') }}" class="bg-gray-100 p-2 rounded text-center hover:bg-gray-200 transition-colors">
                                🛒 Keranjang
                            </a>
                            @auth
                                <a href="{{ route('user.orders.index') }}" class="bg-blue-100 p-2 rounded text-center hover:bg-blue-200 transition-colors">
                                    📋 Riwayat Pesanan
                                </a>
                            @else
                                <a href="{{ route('contact') }}" class="bg-gray-100 p-2 rounded text-center hover:bg-gray-200 transition-colors">
                                    📞 Kontak
                                </a>
                            @endauth
                        </div>
                        @auth
                            <div class="mt-2">
                                <a href="{{ route('contact') }}" class="bg-gray-100 p-2 rounded text-center hover:bg-gray-200 transition-colors block text-xs">
                                    📞 Kontak
                                </a>
                            </div>
                        @endauth
                    </div>

                    <!-- Contact Support -->
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <h4 class="font-semibold text-gray-900 mb-2">Butuh Bantuan Lebih?</h4>
                        <p class="text-xs text-gray-600 mb-2">Hubungi tim dukungan kami:</p>
                        <a href="{{ route('contact') }}" class="inline-flex items-center text-xs bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition-colors">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Kirim Pesan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-secondary-800 text-white py-6 md:py-8 mt-8 md:mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center">
                <h3 class="text-lg md:text-xl font-semibold mb-3 md:mb-4">BUMDes Marketplace</h3>
                <p class="text-secondary-400 text-sm md:text-base leading-relaxed max-w-2xl mx-auto">
                    Mendukung produk lokal desa untuk kemajuan bersama
                </p>
                <div class="mt-3 md:mt-4">
                    <p class="text-xs md:text-sm text-secondary-400">&copy; 2024 BUMDes Marketplace. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>