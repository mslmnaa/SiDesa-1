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
    <nav class="fixed w-full top-0 z-50 bg-gradient-to-b from-green-700/95 via-green-700/60 to-transparent text-white"
        x-data="{ mobileOpen: false }">
        <!-- Mobile Bar -->
        <div class="md:hidden px-4 py-2 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-base font-bold text-white tracking-tight">BUMDes Marketplace</a>
            <button @click="mobileOpen = !mobileOpen" aria-label="Toggle navigation"
                class="p-2 rounded-md bg-white/15 hover:bg-white/25 focus:outline-none focus:ring-2 focus:ring-white/40 transition">
                <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 hidden md:block">
            <div class="flex justify-between items-center py-3 md:py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-lg md:text-2xl font-bold text-white">
                        <span class="hidden md:inline">BUMDes Marketplace</span>
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="flex items-center space-x-3 md:space-x-6">
                    <a href="{{ route('home') }}"
                        class="text-xs md:text-base text-white hover:text-gray-100 transition-colors">Beranda</a>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center text-xs md:text-base text-white hover:text-gray-100 transition-colors">
                            <span>Produk</span>
                            <svg class="w-3 h-3 md:w-4 md:h-4 ml-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute left-0 mt-2 w-36 md:w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <a href="{{ route('products.index') }}"
                                class="block px-3 md:px-4 py-1.5 md:py-2 text-xs md:text-sm text-gray-700 hover:bg-gray-100">Semua
                                Produk</a>
                            <a href="{{ route('products.type', 'barang') }}"
                                class="block px-3 md:px-4 py-1.5 md:py-2 text-xs md:text-sm text-gray-700 hover:bg-gray-100">Produk
                                Barang</a>
                            <a href="{{ route('products.type', 'jasa') }}"
                                class="block px-3 md:px-4 py-1.5 md:py-2 text-xs md:text-sm text-gray-700 hover:bg-gray-100">Produk
                                Jasa</a>
                        </div>
                    </div>
                    <a href="{{ route('infaq') }}"
                        class="text-xs md:text-base text-white hover:text-gray-100 transition-colors">Infaq Online</a>
                    <a href="{{ route('contact') }}"
                        class="text-xs md:text-base text-white hover:text-gray-100 transition-colors">Kontak</a>
                </div>

                <!-- Right Side -->
                <div class="flex items-center space-x-1 md:space-x-4">
                    <a href="{{ route('user.cart.index') }}"
                        class="relative p-1 md:p-2 text-white hover:text-gray-100 transition-colors">
                        <svg class="w-4 h-4 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M17 13l-1.5 6M9 19.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM20.5 19.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z">
                            </path>
                        </svg>
                        <span id="cart-count"
                            class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full h-3 w-3 md:h-5 md:w-5 flex items-center justify-center text-[10px] md:text-xs leading-none">{{ auth()->check() ? auth()->user()->carts->sum('quantity') : 0 }}</span>
                    </a>

                    <div class="flex items-center space-x-1 md:space-x-4">
                        @auth
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open"
                                    class="flex items-center text-xs md:text-base text-white hover:text-gray-100 transition-colors">
                                    <span
                                        class="mr-1 md:mr-2 max-w-16 md:max-w-32 truncate">{{ auth()->user()->name }}</span>
                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition
                                    class="absolute right-0 mt-2 w-36 md:w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                    @if (auth()->user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}"
                                            class="block px-3 md:px-4 py-1.5 md:py-2 text-xs md:text-sm text-secondary-700 hover:bg-cream">Dashboard
                                            Admin</a>
                                    @endif
                                    <a href="{{ route('profile') }}"
                                        class="block px-3 md:px-4 py-1.5 md:py-2 text-xs md:text-sm text-secondary-700 hover:bg-cream">Profile</a>
                                    <a href="{{ route('user.orders.index') }}"
                                        class="block px-3 md:px-4 py-1.5 md:py-2 text-xs md:text-sm text-gray-700 hover:bg-gray-100">Riwayat
                                        Pesanan</a>
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-left px-3 md:px-4 py-1.5 md:py-2 text-xs md:text-sm text-secondary-700 hover:bg-cream">Logout</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-xs md:text-sm text-white hover:text-gray-100 transition-colors">Login</a>
                            <a href="{{ route('register') }}"
                                class="px-2 md:px-3 py-1 md:py-2 rounded-md text-xs md:text-sm font-medium bg-white/15 backdrop-blur-sm text-white hover:bg-white/25 transition-colors">Daftar</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div x-show="mobileOpen" x-transition.origin.top.left x-cloak
            class="md:hidden bg-green-700/95 backdrop-blur-sm border-t border-white/10 px-4 pb-6 space-y-4">
            <div class="pt-2 flex flex-col space-y-2">
                <a href="{{ route('home') }}" class="text-white/90 hover:text-white text-sm font-medium">Beranda</a>
                <div x-data="{ open: false }" class="border border-white/10 rounded-lg overflow-hidden">
                    <button @click="open=!open"
                        class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium text-white/90 hover:text-white">
                        <span>Produk</span>
                        <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transform transition-transform"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="bg-white/5 border-t border-white/10">
                        <a href="{{ route('products.index') }}"
                            class="block px-4 py-2 text-xs text-white/80 hover:bg-white/10">Semua Produk</a>
                        <a href="{{ route('products.type', 'barang') }}"
                            class="block px-4 py-2 text-xs text-white/80 hover:bg-white/10">Produk Barang</a>
                        <a href="{{ route('products.type', 'jasa') }}"
                            class="block px-4 py-2 text-xs text-white/80 hover:bg-white/10">Produk Jasa</a>
                    </div>
                </div>
                <a href="{{ route('infaq') }}" class="text-white/90 hover:text-white text-sm font-medium">Infaq
                    Online</a>
                <a href="{{ route('contact') }}"
                    class="text-white/90 hover:text-white text-sm font-medium">Kontak</a>
            </div>
            <div class="pt-2 border-t border-white/10">
                <div class="flex items-center justify-between py-3">
                    <a href="{{ route('user.cart.index') }}" class="relative text-white/90 hover:text-white p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M17 13l-1.5 6M9 19.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM20.5 19.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                        </svg>
                        <span
                            class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full h-5 w-5 flex items-center justify-center text-[10px] leading-none">{{ auth()->check() ? auth()->user()->carts->sum('quantity') : 0 }}</span>
                    </a>
                </div>
                @auth
                    <div class="space-y-2">
                        <p class="text-xs uppercase tracking-wide text-white/50">Akun</p>
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                                class="block text-sm text-white/90 hover:text-white">Dashboard Admin</a>
                        @endif
                        <a href="{{ route('profile') }}" class="block text-sm text-white/90 hover:text-white">Profile</a>
                        <a href="{{ route('user.orders.index') }}"
                            class="block text-sm text-white/90 hover:text-white">Riwayat Pesanan</a>
                        <form method="POST" action="{{ route('logout') }}">@csrf <button type="submit"
                                class="text-sm text-red-200 hover:text-white">Logout</button></form>
                    </div>
                @else
                    <div class="flex gap-3 pt-4">
                        <a href="{{ route('login') }}"
                            class="flex-1 text-center px-4 py-2 rounded-md bg-white/15 text-white text-sm font-medium hover:bg-white/25">Login</a>
                        <a href="{{ route('register') }}"
                            class="flex-1 text-center px-4 py-2 rounded-md bg-white text-green-700 text-sm font-semibold hover:bg-green-50">Daftar</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Spacer removed when page wants hero flush to top --}}
    @unless (View::hasSection('hero_fullscreen'))
        <div class="h-16 md:h-20"></div>
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
                            <a href="{{ route('infaq') }}"
                                class="bg-gray-100 p-2 rounded text-center hover:bg-gray-200 transition-colors">
                                💝 Infaq Online
                            </a>
                            <a href="{{ route('user.cart.index') }}"
                                class="bg-gray-100 p-2 rounded text-center hover:bg-gray-200 transition-colors">
                                🛒 Keranjang
                            </a>
                            @auth
                                <a href="{{ route('user.orders.index') }}"
                                    class="bg-blue-100 p-2 rounded text-center hover:bg-blue-200 transition-colors">
                                    📋 Riwayat Pesanan
                                </a>
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

    <!-- Footer -->
    <footer class="relative mt-20 bg-gradient-to-br from-green-900 via-green-800 to-green-900 text-white overflow-hidden">
        <!-- Decorative circles -->
        <div class="pointer-events-none absolute inset-0 opacity-10">
            <div class="absolute -top-24 -left-24 w-72 h-72 bg-green-700 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-emerald-700 rounded-full blur-3xl"></div>
        </div>

        <!-- Call To Action Strip -->
        <div class="relative border-b border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h3 class="text-2xl font-extrabold tracking-tight">Dukung Ekonomi Desa</h3>
                    <p class="text-green-100 mt-2 text-sm md:text-base max-w-xl leading-relaxed">Belanja dan promosikan produk unggulan desa untuk kesejahteraan bersama.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <a href="{{ route('products.index') }}" class="group inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-white text-green-800 font-semibold text-sm shadow hover:shadow-lg hover:-translate-y-0.5 transition">
                        <span>Lihat Produk</span>
                        <svg class="w-4 h-4 text-green-600 group-hover:translate-x-0.5 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-green-600/40 ring-1 ring-white/10 text-white font-semibold text-sm backdrop-blur hover:bg-green-600/60 transition shadow">
                            Daftar Sekarang
                        </a>
                    @endguest
                </div>
            </div>
        </div>

        <!-- Main Footer Content -->
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid gap-12 md:gap-10 lg:gap-16 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Brand -->
                <div>
                    <div class="flex items-center gap-2 mb-5">
                        <span class="text-xl font-bold tracking-tight">BUMDes Marketplace</span>
                    </div>
                    <p class="text-sm text-green-100 leading-relaxed">Memajukan ekonomi desa melalui digitalisasi pemasaran produk & jasa lokal berkualitas.</p>
                    <div class="mt-6 flex items-center gap-3">
                        <a href="#" aria-label="TikTok" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition">
                            <svg class="w-5 h-5" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M30.8 5.2c.3 3.2 2 5.9 4.6 7.7 2 1.5 4.4 2.3 6.9 2.4v6.6c-3.5.1-6.8-1-9.7-2.9-.7-.5-1.4-1.1-2.1-1.7l-.1 11.9c-.1 5.1-3.5 9.7-8.4 11.3-2.5.8-5.3.8-7.8 0-5-1.6-8.4-6.3-8.3-11.6.1-5.3 3.8-9.8 8.9-11.1 2-.5 3.9-.5 5.8-.1v6.8c-.9-.6-2-.8-3.1-.6-2.1.4-3.6 2.3-3.6 4.5 0 2.6 2.1 4.7 4.6 4.7 2.2 0 4.1-1.6 4.5-3.7.1-.4.1-.9.1-1.3l.1-30h6.6Z"/></svg>
                        </a>
                        <a href="#" aria-label="Instagram" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.85s-.011 3.584-.069 4.85c-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07s-3.584-.012-4.85-.07c-3.252-.148-4.771-1.691-4.919-4.919-.058-1.265-.069-1.645-.069-4.85s.011-3.584.069-4.85c.149-3.225 1.664-4.771 4.919-4.919C8.416 2.175 8.796 2.163 12 2.163zm0 1.802c-3.14 0-3.505.012-4.73.068-2.76.126-3.95 1.313-4.078 4.078-.056 1.225-.067 1.585-.067 4.73s.011 3.505.067 4.73c.127 2.765 1.318 3.952 4.078 4.078 1.225.056 1.59.068 4.73.068s3.505-.012 4.73-.068c2.76-.126 3.95-1.313 4.078-4.078.056-1.225.067-1.585.067-4.73s-.011-3.505-.067-4.73c-.127-2.765-1.318-3.952-4.078-4.078-1.225-.056-1.59-.068-4.73-.068zm0 5.838c-1.933 0-3.5 1.567-3.5 3.5s1.567 3.5 3.5 3.5 3.5-1.567 3.5-3.5-1.567-3.5-3.5-3.5zm0 5.25c-1.105 0-2-.895-2-2s.895-2 2-2 2 .895 2 2-.895 2-2 2zm4.965-6.402c-.78 0-1.418.638-1.418 1.418s.638 1.418 1.418 1.418 1.418-.638 1.418-1.418-.638-1.418-1.418-1.418z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-sm font-semibold tracking-wider uppercase text-green-200 mb-5">Tautan Cepat</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('home') }}" class="group flex items-center gap-2 text-green-100 hover:text-white transition"><span class="w-1.5 h-1.5 rounded-full bg-green-400 group-hover:scale-110 transition"></span>Beranda</a></li>
                        <li><a href="{{ route('products.index') }}" class="group flex items-center gap-2 text-green-100 hover:text-white transition"><span class="w-1.5 h-1.5 rounded-full bg-green-400 group-hover:scale-110 transition"></span>Produk</a></li>
                        <li><a href="{{ route('infaq') }}" class="group flex items-center gap-2 text-green-100 hover:text-white transition"><span class="w-1.5 h-1.5 rounded-full bg-green-400 group-hover:scale-110 transition"></span>Infaq Online</a></li>
                        <li><a href="{{ route('contact') }}" class="group flex items-center gap-2 text-green-100 hover:text-white transition"><span class="w-1.5 h-1.5 rounded-full bg-green-400 group-hover:scale-110 transition"></span>Kontak</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h4 class="text-sm font-semibold tracking-wider uppercase text-green-200 mb-5">Bantuan & Layanan</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="text-green-100 hover:text-white transition flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5h12M9 3v2m6 4h6M3 9h12M3 13h6m6 0h6M9 21v-8m6 8v-8"/></svg>Pusat Bantuan</a></li>
                        <li><a href="{{ route('user.orders.index') }}" class="text-green-100 hover:text-white transition flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18"/></svg>Pesanan Saya</a></li>
                        @auth
                            <li><a href="{{ route('profile') }}" class="text-green-100 hover:text-white transition flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/></svg>Profil</a></li>
                        @endauth
                        <li><a href="{{ route('login') }}" class="text-green-100 hover:text-white transition flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 3h4a2 2 0 012 2v4M21 9l-7 7-4-4-6 6"/></svg>Masuk</a></li>
                    </ul>
                </div>

                <!-- Contact / Newsletter -->
                <div>
                    <h4 class="text-sm font-semibold tracking-wider uppercase text-green-200 mb-5">Kontak</h4>
                    <ul class="space-y-3 text-sm text-green-100 mb-6">
                        <li class="flex items-start gap-3"><svg class="w-5 h-5 mt-0.5 text-green-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C10.82 21 3 13.18 3 4V5z"/></svg><span>+62 812-3456-7890</span></li>
                        <li class="flex items-start gap-3"><svg class="w-5 h-5 mt-0.5 text-green-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 2a10 10 0 100 20 10 10 0 000-20z"/></svg><span>Jl. Desa Harmoni No. 10, Indonesia</span></li>
                        <li class="flex items-start gap-3"><svg class="w-5 h-5 mt-0.5 text-green-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12H8m0 0l4 4m-4-4l4-4"/></svg><span>info@bumdes.local</span></li>
                    </ul>
                    <h5 class="text-sm font-semibold tracking-wide mb-2">Dapatkan Update</h5>
                    <form action="#" method="POST" class="relative group">
                        <input type="email" name="newsletter_email" required placeholder="Email Anda" class="w-full bg-white/10 placeholder-green-300/60 text-sm rounded-xl py-3 px-4 pr-32 focus:outline-none focus:ring-2 focus:ring-green-400/60 border border-white/10 focus:border-green-300/40">
                        <button type="submit" class="absolute top-1.5 right-1.5 bg-white text-green-700 text-xs font-semibold px-4 py-2 rounded-lg hover:bg-green-50 transition shadow">Kirim</button>
                    </form>
                    <p class="text-[11px] text-green-300/70 mt-3 leading-relaxed">Dengan berlangganan Anda menyetujui kebijakan informasi kami.</p>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="mt-16 pt-8 border-t border-white/10 text-center">
                <p class="text-xs md:text-sm text-green-300">&copy; {{ date('Y') }} BUMDes Marketplace. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>

</html>
