<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BUMDes Marketplace')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-green-600">
                        BUMDes Marketplace
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-green-600 transition-colors">
                        Beranda
                    </a>
                    
                    <!-- Products Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center text-gray-700 hover:text-green-600 transition-colors">
                            <span>Produk</span>
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <a href="{{ route('products.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Semua Produk
                            </a>
                            <a href="{{ route('products.type', 'barang') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Produk Barang
                            </a>
                            <a href="{{ route('products.type', 'jasa') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Produk Jasa
                            </a>
                        </div>
                    </div>
                    
                    <a href="{{ route('infaq') }}" class="text-gray-700 hover:text-green-600 transition-colors">
                        Infaq Online
                    </a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-green-600 transition-colors">
                        Kontak
                    </a>
                </div>

                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    <!-- Cart - Always visible -->
                    <a href="{{ route('user.cart.index') }}" class="relative text-gray-700 hover:text-green-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M17 13l-1.5 6M9 19.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM20.5 19.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                        </svg>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center" id="cart-count">
                            {{ auth()->check() ? auth()->user()->carts->sum('quantity') : 0 }}
                        </span>
                    </a>

                    @auth
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-gray-700 hover:text-green-600 transition-colors">
                                <span class="mr-2">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Dashboard Admin
                                    </a>
                                @endif
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Profile
                                </a>
                                <a href="{{ route('user.orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Riwayat Pesanan
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-green-600 transition-colors">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative max-w-7xl mx-auto mt-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative max-w-7xl mx-auto mt-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center">
                <h3 class="text-xl font-semibold mb-4">BUMDes Marketplace</h3>
                <p class="text-gray-400">Mendukung produk lokal desa untuk kemajuan bersama</p>
                <div class="mt-4">
                    <p class="text-sm text-gray-400">&copy; 2024 BUMDes Marketplace. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>