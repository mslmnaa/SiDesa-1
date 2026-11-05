@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
@php
    $icons = [
        'cash' => 'M3 6h18v12H3V6zm9 3a3 3 0 100 6 3 3 0 000-6zM6 9a2 2 0 01-2 2V9h2zm12 0h2v2a2 2 0 01-2-2zM4 13a2 2 0 012 2H4v-2zm16 0v2h-2a2 2 0 012-2z',
        'cart' => 'M3 3h2.2l.5 2H21l-2.5 8.5a2 2 0 01-1.9 1.5H8.4a2 2 0 01-1.9-1.5L4.4 5M9 21a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm8 0a1.5 1.5 0 100-3 1.5 1.5 0 000 3z',
        'truck' => 'M2 6h11v9H2V6zm11 3h4l3 3v3h-7V9zM6 19a2 2 0 100-4 2 2 0 000 4zm11 0a2 2 0 100-4 2 2 0 000 4z',
        'return' => 'M9 14L4 9l5-5M4 9h10.5a5.5 5.5 0 010 11H11',
    ];

    $statusMap = [
        'pending' => ['Menunggu', 'text-[#F74B81]'],
        'processing' => ['Diproses', 'text-[#3B82F6]'],
        'shipped' => ['Pengiriman', 'text-[#253D4E]'],
        'completed' => ['Selesai', 'text-[#2F9960]'],
        'cancelled' => ['Dibatalkan', 'text-gray-400'],
    ];

    $card = 'bg-white rounded-2xl border border-gray-100 shadow-[0_1px_3px_rgba(37,61,78,0.06)]';
@endphp

{{-- Peringatan lokasi pengiriman (admin desa) --}}
@if(isset($needsShippingSetup) && $needsShippingSetup)
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center gap-4 bg-[#FFF7E6] border border-[#FDC040]/50 rounded-2xl p-4 sm:p-5">
        <div class="w-10 h-10 rounded-xl bg-[#FDC040] text-white flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div class="flex-1 text-sm">
            <p class="font-bold">Atur lokasi asal pengiriman</p>
            <p class="text-gray-600">Tanpa ini, pembeli tidak bisa menghitung ongkos kirim untuk produk desa Anda.</p>
        </div>
        <a href="{{ route('admin.shipping-settings.index') }}" class="inline-flex justify-center px-4 py-2.5 rounded-lg bg-[#253D4E] hover:bg-[#1b2e3b] text-white text-sm font-bold transition-colors">Atur Sekarang</a>
    </div>
@endif

{{-- Ringkasan --}}
<div class="grid grid-cols-2 xl:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-6">
    @foreach($summaryCards as $c)
        @php
            $g = $c['growth'];
            $isUp = is_numeric($g) && $g > 0;
            $isDown = is_numeric($g) && $g < 0;
            $good = ($isUp && $c['up_is_good']) || ($isDown && !$c['up_is_good']);
            $bad = ($isUp && !$c['up_is_good']) || ($isDown && $c['up_is_good']);
        @endphp
        <div class="{{ $card }} p-4 sm:p-5 min-w-0 flex flex-col" x-data="{ menu: false }">
            <div class="flex items-start justify-between gap-2 mb-3 sm:mb-4">
                <p class="text-[13px] sm:text-sm font-bold leading-snug">{{ $c['label'] }}</p>
                <div class="relative -mr-2 -mt-1">
                    <button type="button" @click="menu = !menu" class="p-1.5 rounded-md text-gray-400 hover:text-[#253D4E] hover:bg-gray-100" aria-label="Opsi">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 5.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 5.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3z"/></svg>
                    </button>
                    <div x-show="menu" x-cloak @click.outside="menu = false" class="absolute right-0 mt-1 w-36 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-10">
                        <a href="{{ $c['link'] }}" class="block px-3 py-2 text-sm hover:bg-[#DEF9EC] hover:text-[#3BB77E]">Lihat detail</a>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl bg-[#3BB77E] text-white flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="{{ $icons[$c['icon']] }}"/></svg>
                </div>
                <p class="font-heading text-lg sm:text-[22px] font-bold leading-tight min-w-0 break-all">{{ $c['value'] }}</p>
            </div>
            <div class="mt-auto pt-3 flex flex-wrap items-center justify-between gap-x-2 gap-y-1">
                @if($g !== false)
                    <span class="flex-shrink-0 inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded-md text-xs font-bold
                        {{ $good ? 'bg-[#DEF9EC] text-[#2F9960]' : ($bad ? 'bg-[#FDE8EF] text-[#D6336C]' : 'bg-gray-100 text-gray-500') }}">
                        @if($g === null)
                            Baru
                        @else
                            @if($isUp)<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 19V5m-6 6l6-6 6 6"/></svg>@endif
                            @if($isDown)<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 5v14m6-6l-6 6-6-6"/></svg>@endif
                            {{ number_format(abs($g), 1, ',', '.') }}%
                        @endif
                    </span>
                @endif
                <p class="text-[11px] sm:text-xs text-gray-500 ml-auto text-right">{{ $c['note'] }}</p>
            </div>
        </div>
    @endforeach
</div>

<div class="grid grid-cols-1 xl:grid-cols-5 gap-4 lg:gap-6 mb-6">
    {{-- Grafik penjualan --}}
    <section class="{{ $card }} p-5 lg:p-6 xl:col-span-3"
             x-data="salesChart(@js($salesChart))">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
            <div>
                <h2 class="font-heading text-lg font-bold">Grafik Penjualan</h2>
                <p class="text-xs text-gray-500">Pendapatan dari pesanan yang sudah dibayar</p>
            </div>
            <div class="inline-flex rounded-lg border border-[#3BB77E] overflow-hidden text-sm self-start" role="tablist">
                <template x-for="t in tabs" :key="t.key">
                    <button type="button" role="tab" @click="setPeriod(t.key)" :aria-selected="period === t.key"
                            :class="period === t.key ? 'bg-[#3BB77E] text-white' : 'text-[#253D4E] hover:bg-[#DEF9EC]'"
                            class="px-4 py-1.5 font-semibold transition-colors border-l first:border-l-0 border-[#3BB77E]" x-text="t.label"></button>
                </template>
            </div>
        </div>

        <div class="flex items-baseline gap-2 mb-2">
            <span class="font-heading text-2xl font-bold" x-text="formatFull(total)"></span>
            <span class="text-xs text-gray-500" x-text="'total ' + periodLabel"></span>
        </div>

        <div x-ref="wrap" class="relative select-none" :style="'height:' + H + 'px'" @mouseleave="hover = null">
            <svg :width="w" :height="H" class="block overflow-visible">
                <defs>
                    <linearGradient id="salesFill" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="#3BB77E" stop-opacity="0.18"/>
                        <stop offset="100%" stop-color="#3BB77E" stop-opacity="0"/>
                    </linearGradient>
                </defs>
                {{-- grid, label sumbu Y & X (template x-for tidak jalan di dalam SVG) --}}
                <g x-html="axesSvg"></g>
                <path :d="areaPath" fill="url(#salesFill)"/>
                <path :d="linePath" fill="none" stroke="#2F9960" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"/>
                {{-- hover --}}
                <g x-show="hover !== null">
                    <line :x1="x(hover ?? 0)" :x2="x(hover ?? 0)" :y1="padT" :y2="H - padB" stroke="#253D4E" stroke-opacity="0.25" stroke-width="1"/>
                    <circle :cx="x(hover ?? 0)" :cy="y(points[hover ?? 0]?.value ?? 0)" r="5" fill="#2F9960" stroke="#fff" stroke-width="2"/>
                </g>
                <rect :x="padL" :y="0" :width="Math.max(0, w - padL - padR)" :height="H" fill="transparent"
                      @pointermove="onMove($event)" @pointerdown="onMove($event)"/>
            </svg>
            <div x-show="hover !== null" x-cloak
                 class="pointer-events-none absolute z-10 bg-[#253D4E] text-white rounded-lg px-3 py-2 text-xs shadow-lg whitespace-nowrap"
                 :style="tipStyle">
                <p class="text-white/70" x-text="hover !== null ? points[hover].full : ''"></p>
                <p class="font-bold text-sm" x-text="hover !== null ? formatFull(points[hover].value) : ''"></p>
            </div>
            <p x-show="total === 0" x-cloak class="absolute inset-0 flex items-center justify-center text-sm text-gray-400 pointer-events-none">Belum ada penjualan pada periode ini</p>
        </div>

        {{-- tampilan tabel untuk pembaca layar --}}
        <table class="sr-only">
            <caption>Pendapatan per periode</caption>
            <tbody>
                <template x-for="(p, i) in points" :key="'r' + i">
                    <tr><th x-text="p.full"></th><td x-text="formatFull(p.value)"></td></tr>
                </template>
            </tbody>
        </table>
    </section>

    {{-- Terlaris --}}
    <section class="{{ $card }} p-5 lg:p-6 xl:col-span-2 flex flex-col">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-heading text-lg font-bold">Terlaris</h2>
            <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-[#3BB77E] hover:underline">Semua produk →</a>
        </div>
        @if($bestSellers->count())
            <div class="overflow-x-auto -mx-5 lg:-mx-6 px-5 lg:px-6">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-[#3BB77E] text-white text-xs">
                            <th class="text-left font-semibold py-2.5 pl-3 rounded-l-lg">Produk</th>
                            <th class="hidden sm:table-cell text-right font-semibold py-2.5 px-2">Harga</th>
                            <th class="text-right font-semibold py-2.5 px-2">Terjual</th>
                            <th class="text-right font-semibold py-2.5 pr-3 rounded-r-lg">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($bestSellers as $row)
                            <tr>
                                <td class="py-2.5 pl-1">
                                    <a href="{{ route('admin.products.show', $row->product) }}" class="flex items-center gap-2.5 min-w-0 hover:text-[#3BB77E]">
                                        @if($row->product->images && count($row->product->images) > 0)
                                            <img src="{{ $row->product->getImageDataUri(0) }}" alt="" class="w-9 h-9 rounded-lg object-cover flex-shrink-0">
                                        @else
                                            <span class="w-9 h-9 rounded-lg bg-[#F4F6FA] flex-shrink-0"></span>
                                        @endif
                                        <span class="text-xs font-semibold line-clamp-2 leading-snug">{{ $row->product->name }}</span>
                                    </a>
                                </td>
                                <td class="hidden sm:table-cell py-2.5 px-2 text-right text-xs text-gray-600 whitespace-nowrap">Rp{{ number_format($row->product->price, 0, ',', '.') }}</td>
                                <td class="py-2.5 px-2 text-right text-xs font-semibold">{{ number_format($row->sold, 0, ',', '.') }}</td>
                                <td class="py-2.5 pr-1 text-right text-xs font-bold text-[#2F9960] whitespace-nowrap">Rp{{ number_format($row->revenue, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="flex-1 flex flex-col items-center justify-center text-center py-10">
                <div class="w-12 h-12 rounded-xl bg-[#DEF9EC] text-[#3BB77E] flex items-center justify-center mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
                <p class="text-sm font-semibold">Belum ada produk terjual</p>
                <p class="text-xs text-gray-500">Produk terlaris muncul setelah ada pesanan dibayar.</p>
            </div>
        @endif
    </section>
</div>

{{-- Pesanan terbaru --}}
<section class="{{ $card }} p-5 lg:p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="font-heading text-lg font-bold">Pesanan Terbaru</h2>
        <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-[#3BB77E] hover:underline">Lainnya →</a>
    </div>

    @if($recentOrders->count())
        <div class="hidden md:block overflow-x-auto -mx-5 lg:-mx-6 px-5 lg:px-6">
            <table class="w-full min-w-[720px] text-sm">
                <thead>
                    <tr class="bg-[#3BB77E] text-white text-xs">
                        <th class="text-left font-semibold py-3 pl-4 rounded-l-lg">Produk</th>
                        <th class="text-center font-semibold py-3 px-3">Jumlah</th>
                        <th class="text-center font-semibold py-3 px-3">Tanggal</th>
                        <th class="text-right font-semibold py-3 px-3">Total Harga</th>
                        <th class="text-center font-semibold py-3 px-3">Status</th>
                        <th class="text-center font-semibold py-3 pr-4 rounded-r-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recentOrders as $order)
                        @php
                            $firstItem = $order->items->first();
                            $firstProduct = $firstItem?->product;
                            $otherCount = max(0, $order->items->count() - 1);
                            [$statusLabel, $statusClass] = $statusMap[$order->status] ?? [ucfirst($order->status), 'text-gray-500'];
                            if ($order->payment_status === 'refunded') { [$statusLabel, $statusClass] = ['Refund', 'text-[#E8A317]']; }
                        @endphp
                        <tr class="hover:bg-[#F4F6FA]/60">
                            <td class="py-3 pl-2">
                                <div class="flex items-center gap-3 min-w-0">
                                    @if($firstProduct && $firstProduct->images && count($firstProduct->images) > 0)
                                        <img src="{{ $firstProduct->getImageDataUri(0) }}" alt="" class="w-10 h-10 rounded-lg object-cover flex-shrink-0">
                                    @else
                                        <span class="w-10 h-10 rounded-lg bg-[#F4F6FA] flex-shrink-0"></span>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="font-semibold truncate max-w-[260px]">{{ $firstItem->product_name ?? '-' }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->order_number }}@if($otherCount) · +{{ $otherCount }} produk lain @endif</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-3 text-center">{{ $order->items->sum('quantity') }}</td>
                            <td class="py-3 px-3 text-center whitespace-nowrap text-gray-600">{{ $order->created_at->locale('id')->translatedFormat('j F Y') }}</td>
                            <td class="py-3 px-3 text-right whitespace-nowrap font-semibold">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="py-3 px-3 text-center">
                                <span class="inline-flex items-center gap-1.5 text-xs font-bold {{ $statusClass }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>{{ $statusLabel }}
                                </span>
                            </td>
                            <td class="py-3 pr-2 text-center">
                                <a href="{{ route('admin.orders.show', $order) }}" title="Lihat detail"
                                   class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 hover:text-[#3BB77E] hover:bg-[#DEF9EC] transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.5 12C3.8 7.9 7.6 5 12 5s8.2 2.9 9.5 7c-1.3 4.1-5.1 7-9.5 7s-8.2-2.9-9.5-7z"/></svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Versi HP: daftar kartu --}}
        <div class="md:hidden divide-y divide-gray-100 -mx-1">
            @foreach($recentOrders as $order)
                @php
                    $firstItem = $order->items->first();
                    $firstProduct = $firstItem?->product;
                    $otherCount = max(0, $order->items->count() - 1);
                    [$statusLabel, $statusClass] = $statusMap[$order->status] ?? [ucfirst($order->status), 'text-gray-500'];
                    if ($order->payment_status === 'refunded') { [$statusLabel, $statusClass] = ['Refund', 'text-[#E8A317]']; }
                @endphp
                <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center gap-3 px-1 py-3">
                    @if($firstProduct && $firstProduct->images && count($firstProduct->images) > 0)
                        <img src="{{ $firstProduct->getImageDataUri(0) }}" alt="" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                    @else
                        <span class="w-12 h-12 rounded-lg bg-[#F4F6FA] flex-shrink-0"></span>
                    @endif
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold truncate">{{ $firstItem->product_name ?? '-' }}@if($otherCount) <span class="font-normal text-gray-500">+{{ $otherCount }}</span>@endif</p>
                        <p class="text-xs text-gray-500">{{ $order->created_at->locale('id')->translatedFormat('j M Y') }} · {{ $order->items->sum('quantity') }} item</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="text-sm font-bold">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        <p class="inline-flex items-center gap-1 text-[11px] font-bold {{ $statusClass }}"><span class="w-1.5 h-1.5 rounded-full bg-current"></span>{{ $statusLabel }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center justify-center text-center py-12">
            <div class="w-12 h-12 rounded-xl bg-[#DEF9EC] text-[#3BB77E] flex items-center justify-center mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <p class="text-sm font-semibold">Belum ada pesanan</p>
            <p class="text-xs text-gray-500">Pesanan dari pembeli akan muncul di sini.</p>
        </div>
    @endif
</section>
@endsection

@push('scripts')
<script>
    window.salesChart = function (series) {
        return {
            series,
            tabs: [
                { key: 'weekly', label: 'Mingguan' },
                { key: 'monthly', label: 'Bulanan' },
                { key: 'yearly', label: 'Tahunan' },
            ],
            period: 'monthly',
            w: 600, padL: 56, padR: 16, padT: 12, padB: 32,
            hover: null,
            init() {
                const measure = () => { this.w = this.$refs.wrap.clientWidth || 600; };
                measure();
                new ResizeObserver(measure).observe(this.$refs.wrap);
            },
            setPeriod(p) { this.period = p; this.hover = null; },
            get points() { return this.series[this.period] || []; },
            get H() { return this.w < 560 ? 220 : 300; },
            get compact() { return this.w < 560; },
            get total() { return this.points.reduce((s, p) => s + p.value, 0); },
            get periodLabel() { return { weekly: '8 minggu terakhir', monthly: '6 bulan terakhir', yearly: '5 tahun terakhir' }[this.period]; },
            get maxY() {
                const m = Math.max(...this.points.map(p => p.value), 0);
                if (m <= 0) return 100000;
                const step = Math.pow(10, Math.floor(Math.log10(m)));
                return Math.ceil((m * 1.1) / step) * step;
            },
            get ticks() { const m = this.maxY; return [0, m / 4, m / 2, (m * 3) / 4, m]; },
            get axesSvg() {
                const esc = t => String(t).replace(/[&<>"]/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));
                let out = '';
                for (const t of this.ticks) {
                    const yy = this.y(t);
                    out += `<line x1="${this.padL}" x2="${this.w - this.padR}" y1="${yy}" y2="${yy}" stroke="#E5E7EB" stroke-dasharray="3 4" stroke-width="1"/>`;
                    out += `<text x="${this.padL - 10}" y="${yy + 4}" text-anchor="end" font-size="11" fill="#7E7E7E">${esc(this.formatShort(t))}</text>`;
                }
                this.points.forEach((p, i) => {
                    out += `<text x="${this.x(i)}" y="${this.H - 8}" text-anchor="middle" font-size="11" fill="#7E7E7E">${esc(this.compact ? (p.short || p.label) : p.label)}</text>`;
                });
                return out;
            },
            x(i) {
                const n = this.points.length;
                const inner = this.w - this.padL - this.padR - 24;
                return this.padL + 12 + (n <= 1 ? inner / 2 : (inner * i) / (n - 1));
            },
            y(v) { return this.padT + (this.H - this.padT - this.padB) * (1 - v / this.maxY); },
            // Kurva monotone (tidak melewati titik data / tidak turun di bawah nol)
            get linePath() {
                const pts = this.points.map((p, i) => [this.x(i), this.y(p.value)]);
                if (pts.length < 2) return pts.length ? `M${pts[0][0]},${pts[0][1]}` : '';
                const n = pts.length, d = [], m = [];
                for (let i = 0; i < n - 1; i++) d.push((pts[i + 1][1] - pts[i][1]) / (pts[i + 1][0] - pts[i][0]));
                m.push(d[0]);
                for (let i = 1; i < n - 1; i++) m.push(d[i - 1] * d[i] <= 0 ? 0 : (d[i - 1] + d[i]) / 2);
                m.push(d[n - 2]);
                for (let i = 0; i < n - 1; i++) {
                    if (d[i] === 0) { m[i] = 0; m[i + 1] = 0; continue; }
                    const a = m[i] / d[i], b = m[i + 1] / d[i], s = a * a + b * b;
                    if (s > 9) { const t = 3 / Math.sqrt(s); m[i] = t * a * d[i]; m[i + 1] = t * b * d[i]; }
                }
                let path = `M${pts[0][0]},${pts[0][1]}`;
                for (let i = 0; i < n - 1; i++) {
                    const h = (pts[i + 1][0] - pts[i][0]) / 3;
                    path += ` C${pts[i][0] + h},${pts[i][1] + m[i] * h} ${pts[i + 1][0] - h},${pts[i + 1][1] - m[i + 1] * h} ${pts[i + 1][0]},${pts[i + 1][1]}`;
                }
                return path;
            },
            get areaPath() {
                if (this.points.length < 2) return '';
                const base = this.H - this.padB;
                return `${this.linePath} L${this.x(this.points.length - 1)},${base} L${this.x(0)},${base} Z`;
            },
            onMove(e) {
                const rect = this.$refs.wrap.getBoundingClientRect();
                const px = e.clientX - rect.left;
                let best = 0, dist = Infinity;
                this.points.forEach((_, i) => { const dd = Math.abs(this.x(i) - px); if (dd < dist) { dist = dd; best = i; } });
                this.hover = best;
            },
            get tipStyle() {
                if (this.hover === null) return '';
                const px = this.x(this.hover), py = this.y(this.points[this.hover].value);
                const left = Math.min(Math.max(px - 70, 0), this.w - 150);
                const top = Math.max(py - 62, 0);
                return `left:${left}px;top:${top}px`;
            },
            formatFull(v) { return 'Rp' + Math.round(v).toLocaleString('id-ID'); },
            formatShort(v) {
                if (v >= 1e9) return (v / 1e9).toLocaleString('id-ID', { maximumFractionDigits: 1 }) + ' M';
                if (v >= 1e6) return (v / 1e6).toLocaleString('id-ID', { maximumFractionDigits: 1 }) + ' jt';
                if (v >= 1e3) return (v / 1e3).toLocaleString('id-ID', { maximumFractionDigits: 0 }) + ' rb';
                return String(Math.round(v));
            },
        };
    };
</script>
@endpush
