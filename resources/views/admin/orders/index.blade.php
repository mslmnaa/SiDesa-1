@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')
@section('page_title', 'Manajemen Pesanan')

@section('content')
@php
    $card = 'bg-white rounded-2xl border border-gray-100 shadow-[0_1px_3px_rgba(37,61,78,0.06)]';
    $input = 'w-full h-11 px-4 text-sm border border-gray-200 rounded-lg focus:ring-[#3BB77E] focus:border-[#3BB77E]';

    // Kartu status sekaligus jadi filter cepat
    $tiles = [
        ['key' => '', 'label' => 'Semua Pesanan', 'count' => $stats['total'], 'dot' => 'bg-[#253D4E]',
         'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'],
        ['key' => 'pending', 'label' => 'Menunggu', 'count' => $stats['pending'], 'dot' => 'bg-[#F74B81]',
         'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['key' => 'processing', 'label' => 'Diproses', 'count' => $stats['processing'], 'dot' => 'bg-[#3B82F6]',
         'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
        ['key' => 'shipped', 'label' => 'Dikirim', 'count' => $stats['shipped'], 'dot' => 'bg-[#FDC040]',
         'icon' => 'M2 6h11v9H2V6zm11 3h4l3 3v3h-7V9zM6 19a2 2 0 100-4 2 2 0 000 4zm11 0a2 2 0 100-4 2 2 0 000 4z'],
        ['key' => 'completed', 'label' => 'Selesai', 'count' => $stats['completed'], 'dot' => 'bg-[#3BB77E]',
         'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['key' => 'cancelled', 'label' => 'Dibatalkan', 'count' => $stats['cancelled'], 'dot' => 'bg-gray-400',
         'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
    ];

    $statusMap = [
        'pending' => ['Menunggu', 'text-[#F74B81]'],
        'processing' => ['Diproses', 'text-[#3B82F6]'],
        'shipped' => ['Dikirim', 'text-[#B7791F]'],
        'completed' => ['Selesai', 'text-[#2F9960]'],
        'cancelled' => ['Dibatalkan', 'text-gray-400'],
    ];
    $paymentMap = [
        'paid' => ['Lunas', 'bg-[#DEF9EC] text-[#2F9960]'],
        'refunded' => ['Refund', 'bg-[#FFF4E0] text-[#B7791F]'],
        'unpaid' => ['Belum Bayar', 'bg-[#FDE8EF] text-[#D6336C]'],
    ];
    $currentStatus = (string) request('status');
@endphp

{{-- Ringkasan status (klik untuk memfilter) --}}
<div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-6 gap-3 lg:gap-4 mb-6">
    @foreach($tiles as $t)
        @php $active = $currentStatus === $t['key']; @endphp
        <a href="{{ route('admin.orders.index', array_filter(['status' => $t['key'], 'payment_status' => request('payment_status'), 'search' => request('search')])) }}"
           class="{{ $card }} p-4 flex items-center gap-3 transition-colors {{ $active ? 'ring-2 ring-[#3BB77E] border-transparent' : 'hover:border-[#BCE3C9]' }}">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 {{ $active ? 'bg-[#3BB77E] text-white' : 'bg-[#DEF9EC] text-[#3BB77E]' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="{{ $t['icon'] }}"/></svg>
            </div>
            <div class="min-w-0">
                <p class="font-heading text-xl font-bold leading-tight">{{ number_format($t['count'], 0, ',', '.') }}</p>
                <p class="flex items-center gap-1.5 text-xs text-gray-500 truncate"><span class="w-1.5 h-1.5 rounded-full {{ $t['dot'] }}"></span>{{ $t['label'] }}</p>
            </div>
        </a>
    @endforeach
</div>

{{-- Filter --}}
<form method="GET" action="{{ route('admin.orders.index') }}" class="{{ $card }} p-4 sm:p-5 mb-6 grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
    <div class="md:col-span-5">
        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Cari pesanan</label>
        <div class="relative">
            <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.2-5.2M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="No. order atau nama pelanggan" class="{{ $input }} pl-10">
        </div>
    </div>
    <div class="md:col-span-3">
        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Status pesanan</label>
        <select name="status" class="{{ $input }}">
            <option value="">Semua status</option>
            @foreach($statusMap as $key => [$label])
                <option value="{{ $key }}" @selected($currentStatus === $key)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="md:col-span-2">
        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Pembayaran</label>
        <select name="payment_status" class="{{ $input }}">
            <option value="">Semua</option>
            @foreach($paymentMap as $key => [$label])
                <option value="{{ $key }}" @selected(request('payment_status') === $key)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="md:col-span-2 flex gap-2">
        <button type="submit" class="flex-1 h-11 rounded-lg bg-[#3BB77E] hover:bg-[#2F9960] text-white text-sm font-bold transition-colors">Terapkan</button>
        @if(request()->hasAny(['search', 'status', 'payment_status']))
            <a href="{{ route('admin.orders.index') }}" class="h-11 px-3 rounded-lg border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 flex items-center" title="Hapus filter">Reset</a>
        @endif
    </div>
</form>

{{-- Daftar pesanan --}}
<section class="{{ $card }} p-5 lg:p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="font-heading text-lg font-bold">Daftar Pesanan</h2>
        <span class="text-xs text-gray-500">{{ $orders->total() }} pesanan</span>
    </div>

    @if($orders->count())
        {{-- Tabel (tablet & desktop) --}}
        <div class="hidden md:block overflow-x-auto -mx-5 lg:-mx-6 px-5 lg:px-6">
            <table class="w-full min-w-[860px] text-sm">
                <thead>
                    <tr class="bg-[#3BB77E] text-white text-xs">
                        <th class="text-left font-semibold py-3 pl-4 rounded-l-lg">No. Order</th>
                        <th class="text-left font-semibold py-3 px-3">Pelanggan</th>
                        <th class="text-left font-semibold py-3 px-3">Tanggal</th>
                        <th class="text-right font-semibold py-3 px-3">Total</th>
                        <th class="text-center font-semibold py-3 px-3">Pembayaran</th>
                        <th class="text-center font-semibold py-3 px-3">Status</th>
                        <th class="text-left font-semibold py-3 px-3">Pengiriman</th>
                        <th class="text-center font-semibold py-3 pr-4 rounded-r-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($orders as $order)
                        @php
                            [$sLabel, $sClass] = $statusMap[$order->status] ?? [ucfirst($order->status), 'text-gray-500'];
                            [$pLabel, $pClass] = $paymentMap[$order->payment_status] ?? [ucfirst($order->payment_status), 'bg-gray-100 text-gray-500'];
                        @endphp
                        <tr class="hover:bg-[#F4F6FA]/60">
                            <td class="py-3 pl-4">
                                <p class="font-semibold">{{ $order->order_number }}</p>
                                <p class="text-xs text-gray-500">{{ $order->items->count() }} produk</p>
                            </td>
                            <td class="py-3 px-3">
                                <p class="font-semibold truncate max-w-[180px]">{{ $order->user->name ?? '-' }}</p>
                                <p class="text-xs text-gray-500 truncate max-w-[180px]">{{ $order->user->email ?? '' }}</p>
                            </td>
                            <td class="py-3 px-3 whitespace-nowrap">
                                <p>{{ $order->created_at->locale('id')->translatedFormat('j M Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }}</p>
                            </td>
                            <td class="py-3 px-3 text-right whitespace-nowrap font-bold">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="py-3 px-3 text-center">
                                <span class="inline-block px-2 py-0.5 rounded-md text-xs font-bold {{ $pClass }}">{{ $pLabel }}</span>
                            </td>
                            <td class="py-3 px-3 text-center">
                                <span class="inline-flex items-center gap-1.5 text-xs font-bold {{ $sClass }}"><span class="w-1.5 h-1.5 rounded-full bg-current"></span>{{ $sLabel }}</span>
                            </td>
                            <td class="py-3 px-3">
                                @if($order->shipping_service || $order->shipping_courier)
                                    <p class="font-semibold text-xs uppercase">{{ $order->shipping_courier }} {{ $order->shipping_service }}</p>
                                    <p class="text-xs text-gray-500">Ongkir Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</p>
                                    @if($order->shipping_tracking_number)
                                        <p class="text-xs text-[#3BB77E] font-semibold">Resi: {{ $order->shipping_tracking_number }}</p>
                                    @endif
                                @else
                                    <span class="text-xs text-gray-400">Belum diatur</span>
                                @endif
                            </td>
                            <td class="py-3 pr-4 text-center">
                                <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center gap-1.5 h-8 px-3 rounded-lg bg-[#DEF9EC] text-[#3BB77E] hover:bg-[#3BB77E] hover:text-white text-xs font-bold transition-colors">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Kartu (HP) --}}
        <div class="md:hidden divide-y divide-gray-100 -mx-1">
            @foreach($orders as $order)
                @php
                    [$sLabel, $sClass] = $statusMap[$order->status] ?? [ucfirst($order->status), 'text-gray-500'];
                    [$pLabel, $pClass] = $paymentMap[$order->payment_status] ?? [ucfirst($order->payment_status), 'bg-gray-100 text-gray-500'];
                @endphp
                <a href="{{ route('admin.orders.show', $order) }}" class="block px-1 py-3">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-sm font-bold truncate">{{ $order->order_number }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $order->user->name ?? '-' }} · {{ $order->created_at->locale('id')->translatedFormat('j M Y') }}</p>
                        </div>
                        <p class="text-sm font-bold whitespace-nowrap">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    </div>
                    <div class="mt-2 flex items-center gap-2">
                        <span class="inline-block px-2 py-0.5 rounded-md text-[11px] font-bold {{ $pClass }}">{{ $pLabel }}</span>
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold {{ $sClass }}"><span class="w-1.5 h-1.5 rounded-full bg-current"></span>{{ $sLabel }}</span>
                        <span class="ml-auto text-xs font-bold text-[#3BB77E]">Detail →</span>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center justify-center text-center py-12">
            <div class="w-12 h-12 rounded-xl bg-[#DEF9EC] text-[#3BB77E] flex items-center justify-center mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <p class="text-sm font-semibold">Tidak ada pesanan</p>
            <p class="text-xs text-gray-500">{{ request()->hasAny(['search', 'status', 'payment_status']) ? 'Coba ubah atau hapus filter.' : 'Pesanan dari pembeli akan muncul di sini.' }}</p>
        </div>
    @endif
</section>

@if($orders->hasPages())
    <div class="mt-6">
        {{ $orders->appends(request()->query())->links() }}
    </div>
@endif
@endsection
