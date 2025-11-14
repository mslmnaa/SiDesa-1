<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BUMDes Marketplace - Produk Lokal Berkualitas')</title>

    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white">
    <!-- Top Header Bar -->
    <div class="bg-white border-b border-gray-200 py-3 hidden lg:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center text-sm">
                <div class="flex items-center space-x-6">
                    <a href="{{ route('contact') }}" class="text-gray-600 hover:text-primary-500 transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-secondary-800 font-semibold">Gabung Mitra</span>
                    </a>
                </div>
                <div class="flex items-center space-x-6">
                    @auth
                        <span class="text-gray-600">Halo, <span class="text-primary-500 font-semibold">{{ auth()->user()->name }}</span></span>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-primary-500 transition-colors">Masuk</a>
                        <span class="text-gray-300">|</span>
                        <a href="{{ route('register') }}" class="text-gray-600 hover:text-primary-500 transition-colors">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="bg-white shadow-sm sticky top-0 z-40 border-b border-gray-200" x-data="{ mobileOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-5 lg:py-6">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='50' height='50' viewBox='0 0 50 50'%3E%3Ccircle cx='25' cy='25' r='25' fill='%233BB77E'/%3E%3Cpath d='M25 10 L35 20 L35 40 L15 40 L15 20 Z' fill='white'/%3E%3Crect x='20' y='30' width='10' height='10' fill='%233BB77E'/%3E%3Crect x='18' y='22' width='4' height='4' fill='%233BB77E'/%3E%3Crect x='28' y='22' width='4' height='4' fill='%233BB77E'/%3E%3C/svg%3E"
                             alt="BUMDes Logo" class="w-12 h-12">
                        <div class="hidden sm:block">
                            <span class="text-2xl font-bold text-primary-500">Nest</span>
                            <p class="text-xs text-gray-500 -mt-1">BUMDes Marketplace</p>
                        </div>
                    </a>
                </div>

                <!-- Search Bar (Desktop) -->
                <div class="hidden lg:flex flex-1 max-w-2xl mx-8">
                    <form action="{{ route('products.index') }}" method="GET" class="w-full relative">
                        <div class="flex items-center border-2 border-primary-500 rounded-md overflow-hidden">
                            <div class="relative flex-1">
                                <input type="search"
                                       name="search"
                                       placeholder="Cari produk lokal desa..."
                                       class="w-full px-4 py-3 border-0 focus:ring-0 text-sm">
                            </div>
                            <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white px-8 py-3 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Right Icons -->
                <div class="flex items-center space-x-1 lg:space-x-4">
                    <!-- Compare (Desktop only) -->
                    <a href="#" class="hidden lg:flex flex-col items-center group p-2">
                        <svg class="w-6 h-6 text-secondary-700 group-hover:text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span class="text-xs text-gray-600 mt-1">Compare</span>
                    </a>

                    <!-- Wishlist (Desktop only) -->
                    <a href="#" class="hidden lg:flex flex-col items-center group p-2">
                        <svg class="w-6 h-6 text-secondary-700 group-hover:text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span class="text-xs text-gray-600 mt-1">Wishlist</span>
                    </a>

                    <!-- Cart -->
                    <a href="{{ route('user.cart.index') }}" class="relative group flex flex-col items-center p-2">
                        <div class="relative">
                            <svg class="w-6 h-6 text-secondary-700 group-hover:text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            @if(auth()->check() && auth()->user()->carts->sum('quantity') > 0)
                                <span id="cart-count" class="absolute -top-2 -right-2 bg-primary-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ auth()->user()->carts->sum('quantity') }}
                                </span>
                            @endif
                        </div>
                        <span class="text-xs text-gray-600 mt-1 hidden lg:block">Cart</span>
                    </a>

                    <!-- Account -->
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false"
                                    class="flex flex-col items-center p-2 hover:text-primary-500 transition-colors">
                                <svg class="w-6 h-6 text-secondary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="text-xs text-gray-600 mt-1 hidden lg:block">Account</span>
                            </button>
                            <div x-show="open" x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-nest py-2 z-50 border border-gray-200">
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-primary-50 hover:text-primary-500 transition-colors">Dashboard Admin</a>
                                @endif
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-primary-50 hover:text-primary-500 transition-colors">Profil Saya</a>
                                <a href="{{ route('user.orders.index') }}" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-primary-50 hover:text-primary-500 transition-colors">Riwayat Pesanan</a>
                                <hr class="my-2 border-gray-200">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="hidden lg:flex flex-col items-center p-2">
                            <svg class="w-6 h-6 text-secondary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="text-xs text-gray-600 mt-1">Account</span>
                        </a>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 text-secondary-700">
                        <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Search -->
            <div class="lg:hidden pb-4">
                <form action="{{ route('products.index') }}" method="GET">
                    <div class="flex items-center border-2 border-primary-500 rounded-md overflow-hidden">
                        <input type="search"
                               name="search"
                               placeholder="Cari produk..."
                               class="flex-1 px-4 py-2 border-0 focus:ring-0 text-sm">
                        <button type="submit" class="bg-primary-500 text-white px-4 py-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileOpen" x-transition x-cloak class="lg:hidden pb-4 border-t border-gray-200">
                <nav class="pt-4 space-y-2">
                    <a href="{{ route('home') }}" class="block py-2 text-secondary-700 hover:text-primary-500 font-semibold">Beranda</a>
                    <a href="{{ route('products.index') }}" class="block py-2 text-secondary-700 hover:text-primary-500 font-semibold">Produk</a>
                    <a href="{{ route('villages.index') }}" class="block py-2 text-secondary-700 hover:text-primary-500 font-semibold">Desa</a>
                    <a href="{{ route('contact') }}" class="block py-2 text-secondary-700 hover:text-primary-500 font-semibold">Kontak</a>
                    @guest
                        <a href="{{ route('login') }}" class="block py-2 text-primary-500 font-bold">Masuk</a>
                        <a href="{{ route('register') }}" class="block py-2 text-primary-500 font-bold">Daftar</a>
                    @endguest
                </nav>
            </div>
        </div>
    </header>

    <!-- Navigation Bar (Desktop) -->
    <nav class="bg-white border-b border-gray-200 hidden lg:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-3">
                <!-- Browse Categories Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false"
                            class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-md flex items-center font-semibold transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        Browse All Categories
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="absolute left-0 mt-2 w-64 bg-white rounded-lg shadow-nest py-2 z-50 border border-gray-200">
                        <a href="{{ route('products.index') }}" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-primary-50 hover:text-primary-500 transition-colors">Semua Produk</a>
                        <a href="{{ route('products.type', 'barang') }}" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-primary-50 hover:text-primary-500 transition-colors">Produk Barang</a>
                        <a href="{{ route('products.type', 'jasa') }}" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-primary-50 hover:text-primary-500 transition-colors">Produk Jasa</a>
                    </div>
                </div>

                <!-- Main Navigation -->
                <div class="flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-secondary-700 hover:text-primary-500 font-semibold transition-colors {{ request()->routeIs('home') ? 'text-primary-500' : '' }}">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Home
                    </a>
                    <a href="{{ route('products.index') }}" class="text-secondary-700 hover:text-primary-500 font-semibold transition-colors {{ request()->routeIs('products.*') ? 'text-primary-500' : '' }}">Shop</a>
                    <a href="{{ route('villages.index') }}" class="text-secondary-700 hover:text-primary-500 font-semibold transition-colors {{ request()->routeIs('villages.*') ? 'text-primary-500' : '' }}">Vendors</a>
                    <a href="{{ route('contact') }}" class="text-secondary-700 hover:text-primary-500 font-semibold transition-colors {{ request()->routeIs('contact') ? 'text-primary-500' : '' }}">Contact</a>
                </div>

                <!-- Support Info -->
                <div class="flex items-center space-x-2 text-primary-500">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <div>
                        <p class="text-2xl font-bold text-primary-500">1900888123</p>
                        <p class="text-xs text-gray-600">24/7 Support Center</p>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <div class="flex">
                    <svg class="h-5 w-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                <div class="flex">
                    <svg class="h-5 w-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-20">
        <!-- Main Footer -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
                <!-- About -->
                <div class="lg:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='50' height='50' viewBox='0 0 50 50'%3E%3Ccircle cx='25' cy='25' r='25' fill='%233BB77E'/%3E%3Cpath d='M25 10 L35 20 L35 40 L15 40 L15 20 Z' fill='white'/%3E%3Crect x='20' y='30' width='10' height='10' fill='%233BB77E'/%3E%3Crect x='18' y='22' width='4' height='4' fill='%233BB77E'/%3E%3Crect x='28' y='22' width='4' height='4' fill='%233BB77E'/%3E%3C/svg%3E"
                             alt="Logo" class="w-12 h-12">
                        <span class="text-2xl font-bold text-primary-500">Nest</span>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                        Platform e-commerce BUMDes untuk memasarkan produk lokal berkualitas dari desa ke seluruh Indonesia.
                    </p>
                    <div class="space-y-2 text-sm">
                        <p class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Indonesia
                        </p>
                        <p class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            info@bumdes.id
                        </p>
                        <p class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            (+62) 812-3456-7890
                        </p>
                    </div>
                </div>

                <!-- Company -->
                <div>
                    <h4 class="text-lg font-bold text-secondary-800 mb-4">Company</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-600 hover:text-primary-500 transition-colors">About Us</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary-500 transition-colors">Delivery Information</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary-500 transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary-500 transition-colors">Terms & Conditions</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-600 hover:text-primary-500 transition-colors">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Account -->
                <div>
                    <h4 class="text-lg font-bold text-secondary-800 mb-4">Account</h4>
                    <ul class="space-y-2 text-sm">
                        @auth
                            <li><a href="{{ route('profile') }}" class="text-gray-600 hover:text-primary-500 transition-colors">My Account</a></li>
                            <li><a href="{{ route('user.orders.index') }}" class="text-gray-600 hover:text-primary-500 transition-colors">Order History</a></li>
                            <li><a href="{{ route('user.cart.index') }}" class="text-gray-600 hover:text-primary-500 transition-colors">Shopping Cart</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="text-gray-600 hover:text-primary-500 transition-colors">Sign In</a></li>
                            <li><a href="{{ route('register') }}" class="text-gray-600 hover:text-primary-500 transition-colors">Register</a></li>
                            <li><a href="{{ route('user.cart.index') }}" class="text-gray-600 hover:text-primary-500 transition-colors">View Cart</a></li>
                        @endauth
                        <li><a href="#" class="text-gray-600 hover:text-primary-500 transition-colors">Track My Order</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-600 hover:text-primary-500 transition-colors">Help Ticket</a></li>
                    </ul>
                </div>

                <!-- Corporate -->
                <div>
                    <h4 class="text-lg font-bold text-secondary-800 mb-4">Corporate</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('contact') }}" class="text-gray-600 hover:text-primary-500 transition-colors">Become a Vendor</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary-500 transition-colors">Affiliate Program</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary-500 transition-colors">Farm Business</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary-500 transition-colors">Farm Careers</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary-500 transition-colors">Our Suppliers</a></li>
                    </ul>
                </div>
            </div>

            <!-- App Download & Payment -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-12 pt-12 border-t border-gray-200">
                <div>
                    <h4 class="text-lg font-bold text-secondary-800 mb-4">Install App</h4>
                    <p class="text-sm text-gray-600 mb-4">From App Store or Google Play</p>
                    <div class="flex gap-3">
                        <a href="#" class="inline-block">
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='40' viewBox='0 0 120 40'%3E%3Crect fill='black' width='120' height='40' rx='5'/%3E%3Ctext x='60' y='25' font-family='Arial' font-size='12' fill='white' text-anchor='middle'%3EGoogle Play%3C/text%3E%3C/svg%3E" alt="Google Play" class="h-10">
                        </a>
                        <a href="#" class="inline-block">
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='40' viewBox='0 0 120 40'%3E%3Crect fill='black' width='120' height='40' rx='5'/%3E%3Ctext x='60' y='25' font-family='Arial' font-size='12' fill='white' text-anchor='middle'%3EApp Store%3C/text%3E%3C/svg%3E" alt="App Store" class="h-10">
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-secondary-800 mb-4">Secured Payment Gateways</h4>
                    <div class="flex gap-2 flex-wrap">
                        <div class="bg-white border border-gray-200 rounded px-3 py-2">
                            <span class="text-blue-600 font-bold">VISA</span>
                        </div>
                        <div class="bg-white border border-gray-200 rounded px-3 py-2">
                            <span class="text-red-600 font-bold">Master</span>
                        </div>
                        <div class="bg-white border border-gray-200 rounded px-3 py-2">
                            <span class="text-blue-500 font-bold">Maestro</span>
                        </div>
                        <div class="bg-white border border-gray-200 rounded px-3 py-2">
                            <span class="text-blue-400 font-bold">AMEX</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="border-t border-gray-200 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-600">
                    <p>&copy; {{ date('Y') }} Nest - BUMDes Marketplace. All rights reserved</p>
                    <div class="flex items-center space-x-4 mt-4 md:mt-0">
                        <a href="#" class="hover:text-primary-500 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="hover:text-primary-500 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="#" class="hover:text-primary-500 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @stack('scripts')
</body>
</html>
