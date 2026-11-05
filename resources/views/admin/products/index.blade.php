@extends('layouts.admin')

@section('title', 'Kelola Produk')

@section('content')
@php
    $card = 'bg-white rounded-2xl border border-gray-100 shadow-[0_1px_3px_rgba(37,61,78,0.06)]';
    $input = 'w-full h-11 px-4 text-sm border border-gray-200 rounded-lg focus:ring-[#3BB77E] focus:border-[#3BB77E]';
    $hasFilter = request()->hasAny(['search', 'category', 'status', 'village', 'low_stock']);
@endphp

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="font-heading text-2xl lg:text-[28px] font-bold">Kelola Produk</h1>
        <p class="text-sm text-gray-500 mt-1">{{ $products->total() }} produk {{ auth()->user()->isSuperAdmin() ? 'di semua desa' : 'di desa Anda' }}</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center justify-center gap-2 h-11 px-5 rounded-lg bg-[#3BB77E] hover:bg-[#2F9960] text-white text-sm font-bold transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14m-7-7h14"/></svg>
        Tambah Produk
    </a>
</div>

{{-- Filter --}}
<form method="GET" action="{{ route('admin.products.index') }}" class="{{ $card }} p-4 sm:p-5 mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-end">
    <div class="sm:col-span-2 {{ $villages->count() ? 'lg:col-span-3' : 'lg:col-span-4' }}">
        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Cari produk</label>
        <div class="relative">
            <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.2-5.2M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama produk..." class="{{ $input }} pl-10">
        </div>
    </div>
    <div class="lg:col-span-3">
        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Kategori</label>
        <select name="category" class="{{ $input }}">
            <option value="">Semua kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    @if($villages->count())
        <div class="lg:col-span-2">
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Desa</label>
            <select name="village" class="{{ $input }}">
                <option value="">Semua desa</option>
                @foreach ($villages as $v)
                    <option value="{{ $v->id }}" @selected(request('village') == $v->id)>{{ $v->name }}</option>
                @endforeach
            </select>
        </div>
    @endif
    <div class="{{ $villages->count() ? 'lg:col-span-2' : 'lg:col-span-3' }}">
        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Status</label>
        <select name="status" class="{{ $input }}">
            <option value="">Semua</option>
            <option value="active" @selected(request('status') == 'active')>Aktif</option>
            <option value="inactive" @selected(request('status') == 'inactive')>Nonaktif</option>
        </select>
    </div>
    <div class="lg:col-span-2 flex gap-2">
        <button type="submit" class="flex-1 h-11 rounded-lg bg-[#3BB77E] hover:bg-[#2F9960] text-white text-sm font-bold transition-colors">Terapkan</button>
        @if($hasFilter)
            <a href="{{ route('admin.products.index') }}" class="h-11 px-3 rounded-lg border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 flex items-center">Reset</a>
        @endif
    </div>
</form>

@if ($products->count() > 0)
    {{-- Kartu produk (gaya sama dengan tampilan toko) --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-5 gap-3 sm:gap-5">
        @foreach ($products as $product)
            @php $lowStock = $product->stock <= 10; @endphp
            <div class="bg-white rounded-2xl border border-gray-200 hover:border-[#3BB77E] hover:shadow-lg transition-all duration-300 group p-3 sm:p-4 flex flex-col min-w-0">
                {{-- Badge --}}
                <div class="flex items-start justify-between gap-2 mb-2">
                    <span class="text-[11px] font-bold px-2 py-1 rounded {{ $product->status === 'active' ? 'bg-[#DEF9EC] text-[#2F9960]' : 'bg-gray-100 text-gray-500' }}">
                        {{ $product->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                    </span>
                    @if($product->stock == 0)
                        <span class="text-[11px] font-bold px-2 py-1 rounded bg-[#FDE8EF] text-[#D6336C]">Habis</span>
                    @elseif($lowStock)
                        <span class="text-[11px] font-bold px-2 py-1 rounded bg-[#FFF4E0] text-[#B7791F]">Stok menipis</span>
                    @endif
                </div>

                <a href="{{ route('admin.products.show', $product) }}" class="flex flex-col flex-1">
                    <div class="mb-3 overflow-hidden rounded-lg">
                        @if ($product->images && count($product->images) > 0)
                            <img src="{{ $product->getImageDataUri(0) }}" alt="{{ $product->name }}"
                                 class="w-full h-28 sm:h-32 object-contain group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-28 sm:h-32 bg-gray-50 rounded flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                    </div>
                    <p class="text-[12px] text-gray-500 mb-1 truncate">{{ $product->category->name ?? 'Tanpa kategori' }}</p>
                    <h3 class="font-bold text-[14px] leading-tight line-clamp-2 mb-2 group-hover:text-[#3BB77E] transition-colors">{{ $product->name }}</h3>
                    <p class="text-[15px] sm:text-[17px] font-bold text-[#3BB77E] mb-1">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="text-[12px] text-gray-500 mb-3">
                        Stok: <span class="{{ $lowStock ? 'text-[#D6336C] font-semibold' : '' }}">{{ $product->stock }}</span>
                        @if(auth()->user()->isSuperAdmin() && $product->village)
                            · <span class="text-[#3BB77E]">{{ Str::limit($product->village->name, 16) }}</span>
                        @endif
                    </p>
                </a>

                {{-- Aksi --}}
                <div class="mt-auto flex items-center gap-1.5">
                    <a href="{{ route('admin.products.edit', $product) }}"
                       class="flex-1 flex items-center justify-center gap-1.5 h-9 rounded-md bg-[#DEF9EC] hover:bg-[#3BB77E] text-[#3BB77E] hover:text-white text-[13px] font-semibold transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.2 5.2l3.6 3.6M4 20l4.2-1 10.3-10.3a2.5 2.5 0 00-3.6-3.6L4.6 15.4 4 20z"/></svg>
                        Edit
                    </a>
                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Hapus produk" aria-label="Hapus produk"
                                class="w-9 h-9 flex items-center justify-center rounded-md text-gray-400 hover:text-white hover:bg-[#F74B81] border border-gray-200 hover:border-[#F74B81] transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.9 12.1A2 2 0 0116.1 21H7.9a2 2 0 01-2-1.9L5 7m5 4v6m4-6v6M4 7h16M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    @if($products->hasPages())
        <div class="mt-6">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @endif
@else
    <div class="{{ $card }} p-12 text-center">
        <div class="w-14 h-14 rounded-xl bg-[#DEF9EC] text-[#3BB77E] flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        </div>
        <h3 class="font-heading text-lg font-bold mb-1">{{ $hasFilter ? 'Produk tidak ditemukan' : 'Belum ada produk' }}</h3>
        <p class="text-sm text-gray-500 mb-6">{{ $hasFilter ? 'Coba ubah kata kunci atau hapus filter.' : 'Mulai tambahkan produk pertama desa Anda.' }}</p>
        <a href="{{ $hasFilter ? route('admin.products.index') : route('admin.products.create') }}" class="inline-flex h-11 px-5 items-center rounded-lg bg-[#3BB77E] hover:bg-[#2F9960] text-white text-sm font-bold transition-colors">
            {{ $hasFilter ? 'Hapus Filter' : 'Tambah Produk' }}
        </a>
    </div>
@endif
@endsection
