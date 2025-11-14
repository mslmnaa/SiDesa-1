<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BUMDes Marketplace')</title>

    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">
    <!-- Navigation - Zilly Style -->
    <nav class="fixed w-full top-0 z-50 bg-white border-b border-gray-100" x-data="{ mobileOpen: false, categoriesOpen: false }">
        <div class="max-w-[1400px] mx-auto px-6">
            <div class="flex items-center justify-between py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <svg class="w-9 h-9 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <span class="text-3xl font-bold text-gray-900">BUMDes</span>
                    </a>
                </div>

                <!-- All Categories Dropdown -->
                <div class="relative hidden xl:block ml-6">
                    <button @click="categoriesOpen = !categoriesOpen"
                        class="flex items-center gap-2 border border-gray-300 rounded px-3 py-2 hover:border-green-600 transition-colors bg-white">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <span class="text-sm text-gray-700">Semua Kategori</span>
                        <svg class="w-3.5 h-3.5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="categoriesOpen" @click.away="categoriesOpen = false" x-transition x-cloak
                        class="absolute left-0 top-full mt-2 w-56 bg-white rounded shadow-lg border border-gray-200 py-2 z-50">
                        <a href="{{ route('products.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-green-600">Semua
                            Produk</a>
                        <a href="{{ route('products.type', 'barang') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-green-600">Produk
                            Barang</a>
                        <a href="{{ route('products.type', 'jasa') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-green-600">Produk
                            Jasa</a>
                        <a href="{{ route('villages.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-green-600">Desa
                            Partner</a>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="hidden lg:flex flex-1 max-w-2xl mx-6">
                    <div class="relative w-full">
                        <input type="text" placeholder="Cari produk lokal dari desa..."
                            class="w-full pl-4 pr-24 py-2.5 text-sm border border-gray-300 rounded focus:outline-none focus:border-green-600">
                        <button
                            class="absolute right-1 top-1/2 -translate-y-1/2 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold px-5 py-1.5 rounded text-sm transition-colors">
                            Cari
                        </button>
                    </div>
                </div>

                <!-- Right Icons -->
                <div class="hidden lg:flex items-center gap-5">
                    <!-- User -->
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center gap-1.5 text-gray-700 hover:text-green-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span
                                    class="absolute -top-1 -right-1 bg-green-600 text-white rounded-full w-4 h-4 flex items-center justify-center text-[10px] font-medium">0</span>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition x-cloak
                                class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg border border-gray-100 py-1 z-50">
                                <a href="{{ route('profile') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profil</a>
                                <a href="{{ route('user.orders.index') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Pesanan</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="flex items-center text-gray-700 hover:text-green-600 transition-colors relative">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span
                                class="absolute -top-1 -right-1 bg-green-600 text-white rounded-full w-4 h-4 flex items-center justify-center text-[10px] font-medium">0</span>
                        </a>
                    @endauth

                    <!-- Wishlist -->
                    <a href="#"
                        class="flex items-center text-gray-700 hover:text-green-600 transition-colors relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                        <span
                            class="absolute -top-1 -right-1 bg-green-600 text-white rounded-full w-4 h-4 flex items-center justify-center text-[10px] font-medium">0</span>
                    </a>

                    <!-- Cart -->
                    <a href="{{ route('user.cart.index') }}"
                        class="flex items-center gap-2 text-gray-700 hover:text-green-600 transition-colors relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <span
                            class="absolute -top-1 -right-1 bg-green-600 text-white rounded-full w-4 h-4 flex items-center justify-center text-[10px] font-medium">{{ auth()->check() ? auth()->user()->carts->sum('quantity') : 0 }}</span>
                        <span
                            class="text-sm font-semibold">Rp{{ number_format(auth()->check()? auth()->user()->carts->sum(function ($cart) {return $cart->quantity * $cart->product->price;}): 0,0,',','.') }}</span>
                    </a>

                    <!-- Hamburger icon -->
                    <button class="flex items-center text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <!-- Mobile Cart -->
                <a href="{{ route('user.cart.index') }}" class="lg:hidden relative p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    <span
                        class="absolute top-0 right-0 bg-green-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-[10px]">{{ auth()->check() ? auth()->user()->carts->sum('quantity') : 0 }}</span>
                </a>

                <!-- Mobile Menu -->
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Secondary Nav -->
        <div class="hidden lg:block border-t border-gray-100">
            <div class="max-w-[1400px] mx-auto px-6">
                <div class="flex items-center justify-between py-3">
                    <div class="flex items-center gap-8">
                        <a href="{{ route('home') }}"
                            class="text-sm text-gray-700 hover:text-green-600 transition-colors">Beranda</a>
                        <a href="{{ route('products.index') }}"
                            class="text-sm text-gray-700 hover:text-green-600 transition-colors">Produk</a>
                        <a href="{{ route('villages.index') }}"
                            class="text-sm text-gray-700 hover:text-green-600 transition-colors">Desa</a>
                        <a href="{{ route('contact') }}"
                            class="text-sm text-gray-700 hover:text-green-600 transition-colors">Kontak</a>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            <span class="text-gray-700">Diskon Mingguan</span>
                        </div>
                        <div class="flex items-center gap-2 bg-red-600 text-white px-3 py-1.5 rounded text-sm">
                            <span class="font-medium">Hotline Number:</span>
                            <span class="font-bold">+62 812-3456-7890</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div x-show="mobileOpen" x-transition.origin.top x-cloak class="md:hidden bg-white border-t border-gray-200">
            <div class="px-4 py-3 space-y-2">
                <a href="{{ route('home') }}"
                    class="block text-sm text-gray-700 hover:text-green-600 py-2 font-medium">Beranda</a>
                <a href="{{ route('villages.index') }}"
                    class="block text-sm text-gray-700 hover:text-green-600 py-2 font-medium">Desa</a>
                <div x-data="{ open: false }">
                    <button @click="open=!open"
                        class="w-full flex items-center justify-between text-sm text-gray-700 hover:text-green-600 py-2 font-medium">
                        <span>Produk</span>
                        <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transform transition-transform"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="pl-4 space-y-2">
                        <a href="{{ route('products.index') }}"
                            class="block text-xs text-gray-600 hover:text-green-600 py-1.5">Semua Produk</a>
                        <a href="{{ route('products.type', 'barang') }}"
                            class="block text-xs text-gray-600 hover:text-green-600 py-1.5">Produk Barang</a>
                        <a href="{{ route('products.type', 'jasa') }}"
                            class="block text-xs text-gray-600 hover:text-green-600 py-1.5">Produk Jasa</a>
                    </div>
                </div>
                <a href="{{ route('contact') }}"
                    class="block text-sm text-gray-700 hover:text-green-600 py-2 font-medium">Gabung Mitra</a>

                <div class="pt-3 border-t border-gray-200">
                    @auth
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                                class="block text-sm text-gray-700 hover:text-green-600 py-2">Dashboard Admin</a>
                        @endif
                        <a href="{{ route('profile') }}"
                            class="block text-sm text-gray-700 hover:text-green-600 py-2">Profile</a>
                        <a href="{{ route('user.orders.index') }}"
                            class="block text-sm text-gray-700 hover:text-green-600 py-2">Riwayat Pesanan</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left text-sm text-red-600 hover:text-red-700 py-2">Logout</button>
                        </form>
                    @else
                        <div class="flex gap-2 pt-2">
                            <a href="{{ route('login') }}"
                                class="flex-1 text-center px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50">Login</a>
                            <a href="{{ route('register') }}"
                                class="flex-1 text-center px-4 py-2 text-sm font-medium bg-green-600 text-white rounded-md hover:bg-green-700">Daftar</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Spacer removed when page wants hero flush to top --}}
    @unless (View::hasSection('hero_fullscreen'))
        <div class="h-14"></div>
    @endunless

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="bg-primary-50 border border-primary-400 text-primary-700 px-4 py-3 rounded relative max-w-7xl mx-auto mt-4"
            role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-accent-100 border border-accent-400 text-accent-700 px-4 py-3 rounded relative max-w-7xl mx-auto mt-4"
            role="alert">
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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                </path>
            </svg>
        </button>

        <!-- Help Panel -->
        <div x-show="helpOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95" @click.away="helpOpen = false"
            class="absolute bottom-16 right-0 w-80 md:w-96 bg-white rounded-lg shadow-2xl border border-gray-200 max-h-96 overflow-hidden">

            <!-- Header -->
            <div class="bg-green-600 text-white p-4 rounded-t-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="font-semibold">Bantuan & Panduan</h3>
                    </div>
                    <button @click="helpOpen = false" class="text-white hover:text-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
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
                        <p class="text-sm text-blue-800">Platform belanja online untuk produk dan jasa unggulan desa.
                        </p>
                    </div>

                    <!-- Step by Step Guide -->
                    <div class="space-y-3">
                        <h4 class="font-semibold text-gray-900 border-b pb-2">Cara Berbelanja:</h4>

                        <!-- Step 1 -->
                        <div class="flex items-start space-x-3">
                            <div
                                class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-semibold">
                                1</div>
                            <div>
                                <h5 class="font-medium text-sm">Jelajahi Produk</h5>
                                <p class="text-xs text-gray-600">Klik menu "Produk" untuk melihat semua produk barang
                                    dan jasa tersedia.</p>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="flex items-start space-x-3">
                            <div
                                class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-semibold">
                                2</div>
                            <div>
                                <h5 class="font-medium text-sm">Tambah ke Keranjang</h5>
                                <p class="text-xs text-gray-600">Pilih produk yang diinginkan, atur jumlah, lalu klik
                                    "Tambah ke Keranjang".</p>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="flex items-start space-x-3">
                            <div
                                class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-semibold">
                                3</div>
                            <div>
                                <h5 class="font-medium text-sm">Daftar/Masuk Akun</h5>
                                <p class="text-xs text-gray-600">Buat akun atau masuk untuk melanjutkan ke checkout.
                                </p>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="flex items-start space-x-3">
                            <div
                                class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-semibold">
                                4</div>
                            <div>
                                <h5 class="font-medium text-sm">Checkout & Pembayaran</h5>
                                <p class="text-xs text-gray-600">Isi data lengkap, pilih metode pembayaran, dan
                                    selesaikan transaksi.</p>
                            </div>
                        </div>

                        <!-- Step 5 -->
                        <div class="flex items-start space-x-3">
                            <div
                                class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-semibold">
                                5</div>
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
                                        <span><strong>Mobile:</strong> Klik nama Anda (di navbar) → "Riwayat
                                            Pesanan"</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="border-t pt-3">
                        <h4 class="font-semibold text-gray-900 mb-2">Menu Utama:</h4>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <a href="{{ route('products.index') }}"
                                class="bg-gray-100 p-2 rounded text-center hover:bg-gray-200 transition-colors">
                                🛍️ Produk
                            </a>
                            <a href="{{ route('user.cart.index') }}"
                                class="bg-gray-100 p-2 rounded text-center hover:bg-gray-200 transition-colors">
                                🛒 Keranjang
                            </a>
                            @auth
                            @else
                                <a href="{{ route('contact') }}"
                                    class="bg-gray-100 p-2 rounded text-center hover:bg-gray-200 transition-colors">
                                    📞 Kontak
                                </a>
                            @endauth
                        </div>
                        @auth
                            <div class="mt-2">
                                <a href="{{ route('contact') }}"
                                    class="bg-gray-100 p-2 rounded text-center hover:bg-gray-200 transition-colors block text-xs">
                                    📞 Kontak
                                </a>
                            </div>
                        @endauth
                    </div>

                    <!-- Contact Support -->
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <h4 class="font-semibold text-gray-900 mb-2">Butuh Bantuan Lebih?</h4>
                        <p class="text-xs text-gray-600 mb-2">Hubungi tim dukungan kami:</p>
                        <a href="{{ route('contact') }}"
                            class="inline-flex items-center text-xs bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition-colors">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                            Kirim Pesan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer - Zilly Style -->
    <footer class="mt-16 bg-gray-900 text-gray-300">
        <!-- Main Footer -->
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-5">
                <!-- Brand -->
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <span class="text-xl font-bold text-white">BUMDes Marketplace</span>
                    </div>
                    <p class="text-xs text-gray-400 leading-relaxed mb-4">Platform marketplace terpercaya untuk produk
                        lokal berkualitas dari Badan Usaha Milik Desa (BUMDes). Dukung ekonomi desa dengan berbelanja
                        produk unggulan dari berbagai desa di Indonesia.</p>

                    <!-- Contact Info -->
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center gap-2 text-xs">
                            <svg class="w-3.5 h-3.5 text-green-400 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C10.82 21 3 13.18 3 4V5z" />
                            </svg>
                            <span class="text-gray-400">+62 812-3456-7890</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs">
                            <svg class="w-3.5 h-3.5 text-green-400 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-gray-400">info@bumdesmarketplace.id</span>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-400">Ikuti kami:</span>
                        <div class="flex gap-2">
                            <a href="#"
                                class="w-7 h-7 rounded-full bg-gray-800 hover:bg-green-600 flex items-center justify-center text-gray-400 hover:text-white transition">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-7 h-7 rounded-full bg-gray-800 hover:bg-green-600 flex items-center justify-center text-gray-400 hover:text-white transition">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-7 h-7 rounded-full bg-gray-800 hover:bg-green-600 flex items-center justify-center text-gray-400 hover:text-white transition">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Navigasi -->
                <div>
                    <h4 class="text-sm font-semibold text-white mb-3">Navigasi</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('home') }}" class="hover:text-green-400 transition">Beranda</a></li>
                        <li><a href="{{ route('villages.index') }}" class="hover:text-green-400 transition">Desa
                                Partner</a></li>
                        <li><a href="{{ route('products.index') }}" class="hover:text-green-400 transition">Semua
                                Produk</a></li>
                        <li><a href="{{ route('products.type', 'barang') }}"
                                class="hover:text-green-400 transition">Produk Barang</a></li>
                        <li><a href="{{ route('products.type', 'jasa') }}"
                                class="hover:text-green-400 transition">Produk Jasa</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-green-400 transition">Gabung Mitra</a>
                        </li>
                    </ul>
                </div>

                <!-- Akun Saya -->
                <div>
                    <h4 class="text-sm font-semibold text-white mb-3">Akun Saya</h4>
                    <ul class="space-y-2 text-xs">
                        @auth
                            <li><a href="{{ route('profile') }}" class="hover:text-green-400 transition">Profil Saya</a>
                            </li>
                            <li><a href="{{ route('user.orders.index') }}"
                                    class="hover:text-green-400 transition">Riwayat Pesanan</a></li>
                            <li><a href="{{ route('user.cart.index') }}"
                                    class="hover:text-green-400 transition">Keranjang Belanja</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="hover:text-green-400 transition">Masuk</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-green-400 transition">Daftar</a></li>
                        @endauth
                        <li><a href="{{ route('contact') }}" class="hover:text-green-400 transition">Hubungi Kami</a>
                        </li>
                        <li><a href="#" class="hover:text-green-400 transition">Bantuan</a></li>
                    </ul>
                </div>

                <!-- Tentang BUMDes -->
                <div>
                    <h4 class="text-sm font-semibold text-white mb-3">Tentang Kami</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="#" class="hover:text-green-400 transition">Tentang BUMDes</a></li>
                        <li><a href="#" class="hover:text-green-400 transition">Cara Kerja</a></li>
                        <li><a href="#" class="hover:text-green-400 transition">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-green-400 transition">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-green-400 transition">FAQ</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-green-400 transition">Kontak</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-gray-800">
            <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                    <p class="text-xs text-gray-500">&copy; {{ date('Y') }} BUMDes Marketplace. Semua hak
                        dilindungi undang-undang.</p>

                    <!-- Payment Methods -->
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-500">Metode Pembayaran:</span>
                        <div class="flex gap-1.5">
                            <div class="h-6 px-2 bg-white rounded flex items-center justify-center">
                                <span class="text-[9px] font-bold text-blue-600">BCA</span>
                            </div>
                            <div class="h-6 px-2 bg-white rounded flex items-center justify-center">
                                <span class="text-[9px] font-bold text-red-600">BNI</span>
                            </div>
                            <div class="h-6 px-2 bg-white rounded flex items-center justify-center">
                                <span class="text-[9px] font-bold text-blue-700">BRI</span>
                            </div>
                            <div class="h-6 px-2 bg-white rounded flex items-center justify-center">
                                <span class="text-[9px] font-bold text-orange-500">GOPAY</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Additional Scripts -->
    @stack('scripts')
</body>

</html>
