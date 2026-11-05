<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Admin BUMDes</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
    $adminUser = auth()->user();
    $adminVillageId = ($adminUser->isAdmin() && $adminUser->village_id) ? $adminUser->village_id : null;

    // Pesanan yang menunggu diproses (untuk ikon notifikasi)
    $pendingOrdersQuery = \App\Models\Order::where('status', 'pending');
    if ($adminVillageId) {
        $pendingOrdersQuery->whereHas('items', fn ($q) => $q->where('village_id', $adminVillageId));
    }
    $pendingOrdersCount = (clone $pendingOrdersQuery)->count();
    $pendingOrdersList = (clone $pendingOrdersQuery)->latest()->take(5)->get();

    // Menu sidebar: sama untuk semua item, isi menyesuaikan peran
    $isSuper = $adminUser->isSuperAdmin();
    $menuGroups = [
        'Menu Utama' => [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => ['admin.dashboard'], 'icon' => 'M4 5a1 1 0 011-1h5v7H4V5zm10-1h5a1 1 0 011 1v3h-6V4zM4 13h6v7H5a1 1 0 01-1-1v-6zm10-3h6v9a1 1 0 01-1 1h-5V10z'],
            ['label' => 'Produk', 'route' => 'admin.products.index', 'active' => ['admin.products.*'], 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
            ['label' => 'Pesanan', 'route' => 'admin.orders.index', 'active' => ['admin.orders.*', 'admin.shipping.*'], 'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z', 'badge' => $pendingOrdersCount],
        ],
        'Pengaturan' => $isSuper ? [
            ['label' => 'Desa', 'route' => 'admin.villages.index', 'active' => ['admin.villages.*'], 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
            ['label' => 'Kategori', 'route' => 'admin.categories.index', 'active' => ['admin.categories.*'], 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
            ['label' => 'Admin Desa', 'route' => 'admin.admins.index', 'active' => ['admin.admins.*'], 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
            ['label' => 'Pengguna', 'route' => 'admin.users.index', 'active' => ['admin.users.*'], 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
        ] : [
            ['label' => 'Lokasi Pengiriman', 'route' => 'admin.shipping-settings.index', 'active' => ['admin.shipping-settings.*'], 'icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z'],
        ],
    ];

    $navItem = 'group flex items-center gap-3 px-4 py-2.5 rounded-lg text-[15px] font-semibold transition-colors';
    $navIdle = 'text-[#253D4E] hover:bg-[#DEF9EC] hover:text-[#3BB77E]';
    $navActive = 'bg-[#3BB77E] text-white shadow-sm';
@endphp
<body class="bg-[#F4F6FA] text-[#253D4E]">
    <div class="h-screen flex flex-col" x-data="{ sidebarOpen: false }">

        <!-- Top Bar -->
        <header class="h-16 lg:h-[72px] flex-shrink-0 bg-white border-b border-gray-100 flex items-center z-30">
            <!-- Logo (sejajar dengan sidebar di desktop) -->
            <div class="flex items-center gap-2 px-4 lg:px-6 lg:w-64 flex-shrink-0">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 -ml-2 text-[#253D4E]" aria-label="Buka menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/Logo.svg') }}" alt="" class="w-9 h-9 lg:w-10 lg:h-10" onerror="this.style.display='none'">
                    <span class="font-heading text-[22px] lg:text-[26px] font-bold text-[#253D4E] leading-none">BUMDes</span>
                </a>
            </div>

            <div class="flex-1 flex items-center justify-end gap-1 sm:gap-3 px-3 sm:px-6 lg:px-8">
                <!-- Search -->
                <div x-data="{ open: false }" class="relative flex items-center">
                    <form x-show="open" x-cloak x-transition.opacity @click.outside="open = false"
                          action="{{ route('admin.products.index') }}" method="GET"
                          class="absolute right-full mr-2 sm:static sm:mr-0">
                        <input x-ref="q" type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                               class="w-44 sm:w-64 h-10 px-4 text-sm rounded-full border border-[#BCE3C9] focus:border-[#3BB77E] focus:ring-[#3BB77E]">
                    </form>
                    <button type="button" @click="open = !open; $nextTick(() => open && $refs.q.focus())"
                            class="p-2 rounded-full text-[#253D4E] hover:text-[#3BB77E] hover:bg-[#DEF9EC] transition-colors" aria-label="Cari">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-5.2-5.2M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg>
                    </button>
                </div>

                <!-- Notifications -->
                <div x-data="{ open: false }" class="relative">
                    <button type="button" @click="open = !open" class="relative p-2 rounded-full text-[#3BB77E] hover:bg-[#DEF9EC] transition-colors" aria-label="Notifikasi">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 22a2.5 2.5 0 002.45-2h-4.9A2.5 2.5 0 0012 22zm7-6V11a7 7 0 00-5.5-6.84V3.5a1.5 1.5 0 00-3 0v.66A7 7 0 005 11v5l-1.7 1.7A1 1 0 004 19.4h16a1 1 0 00.7-1.7L19 16z"/></svg>
                        @if($pendingOrdersCount > 0)
                            <span class="absolute top-1 right-1 min-w-[18px] h-[18px] px-1 rounded-full bg-[#F74B81] text-white text-[10px] font-bold flex items-center justify-center ring-2 ring-white">{{ $pendingOrdersCount > 99 ? '99+' : $pendingOrdersCount }}</span>
                        @endif
                    </button>
                    <div x-show="open" x-cloak x-transition @click.outside="open = false"
                         class="absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden z-50">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="font-heading font-bold text-sm">Pesanan Menunggu</p>
                            <p class="text-xs text-gray-500">{{ $pendingOrdersCount }} pesanan perlu diproses</p>
                        </div>
                        @forelse($pendingOrdersList as $po)
                            <a href="{{ route('admin.orders.show', $po) }}" class="flex items-center justify-between gap-3 px-4 py-3 text-sm hover:bg-[#F4F6FA]">
                                <span class="font-semibold truncate">{{ $po->order_number }}</span>
                                <span class="text-xs text-gray-500 flex-shrink-0">{{ $po->created_at->diffForHumans() }}</span>
                            </a>
                        @empty
                            <p class="px-4 py-6 text-sm text-center text-gray-500">Tidak ada pesanan baru</p>
                        @endforelse
                        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="block px-4 py-3 text-center text-sm font-bold text-[#3BB77E] border-t border-gray-100 hover:bg-[#DEF9EC]">Lihat semua</a>
                    </div>
                </div>

                <!-- Account -->
                <div x-data="{ open: false }" class="relative ml-1">
                    <button type="button" @click="open = !open"
                            class="flex items-center gap-2 h-10 pl-3 pr-2 sm:pl-5 sm:pr-3 rounded-full border-2 border-[#3BB77E] text-[#3BB77E] font-bold text-sm hover:bg-[#DEF9EC] transition-colors">
                        <span class="hidden sm:inline max-w-[120px] truncate">{{ $adminUser->isSuperAdmin() ? 'Super Admin' : 'Admin' }}</span>
                        <svg class="w-5 h-5 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <svg class="w-4 h-4 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-cloak x-transition @click.outside="open = false"
                         class="absolute right-0 mt-2 w-60 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                        <div class="px-4 py-2 border-b border-gray-100 mb-1">
                            <p class="font-bold text-sm truncate">{{ $adminUser->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $adminUser->village->name ?? ucfirst($adminUser->role) }}</p>
                        </div>
                        <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-[#DEF9EC] hover:text-[#3BB77E]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Profil Saya
                        </a>
                        <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-[#DEF9EC] hover:text-[#3BB77E]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Ke Website Utama
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 flex min-h-0">
            <!-- Mobile overlay -->
            <div x-show="sidebarOpen" x-cloak x-transition.opacity @click="sidebarOpen = false"
                 class="fixed inset-0 z-40 bg-black/40 lg:hidden"></div>

            <!-- Sidebar -->
            <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-100 flex flex-col transform transition-transform duration-300 lg:static lg:z-auto lg:translate-x-0"
                   :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
                <div class="lg:hidden flex items-center justify-between h-16 px-4 border-b border-gray-100">
                    <span class="font-heading text-xl font-bold">Menu</span>
                    <button @click="sidebarOpen = false" class="p-2" aria-label="Tutup menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-6">
                    @foreach($menuGroups as $groupLabel => $items)
                        <div>
                            <p class="px-4 mb-2 text-xs font-semibold text-gray-400">{{ $groupLabel }}</p>
                            <div class="space-y-1">
                                @foreach($items as $item)
                                    @php $isActive = request()->routeIs(...$item['active']); @endphp
                                    <a href="{{ route($item['route']) }}" class="{{ $navItem }} {{ $isActive ? $navActive : $navIdle }}" @if($isActive) aria-current="page" @endif>
                                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="{{ $item['icon'] }}"/></svg>
                                        <span class="flex-1">{{ $item['label'] }}</span>
                                        @if(!empty($item['badge']))
                                            <span class="min-w-[22px] h-[22px] px-1.5 rounded-full text-[11px] font-bold flex items-center justify-center {{ $isActive ? 'bg-white text-[#3BB77E]' : 'bg-[#F74B81] text-white' }}">{{ $item['badge'] > 99 ? '99+' : $item['badge'] }}</span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </nav>

                <div class="p-4 border-t border-gray-100">
                    <a href="{{ route('home') }}" class="flex items-center justify-center gap-2 w-full py-2.5 rounded-lg bg-[#DEF9EC] text-[#3BB77E] text-sm font-bold hover:bg-[#3BB77E] hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Lihat Website
                    </a>
                </div>
            </aside>

            <!-- Main -->
            <main class="flex-1 min-w-0 overflow-y-auto">
                <div class="px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
                    @hasSection('page_title')
                        <h1 class="font-heading text-2xl lg:text-[28px] font-bold text-[#253D4E] mb-6">@yield('page_title')</h1>
                    @endif

                    @if(session('success'))
                        <div class="flex items-start gap-3 bg-[#DEF9EC] border border-[#BCE3C9] text-[#2F9960] px-4 py-3 rounded-xl mb-6 text-sm font-semibold" role="alert">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm font-semibold" role="alert">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.14.1/dist/cdn.min.js" defer></script>
    @stack('scripts')
</body>
</html>
