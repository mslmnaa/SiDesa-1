@extends('layouts.admin')

@section('title', 'Kelola Kategori')

@section('content')
@php
    $card = 'bg-white rounded-2xl border border-gray-100 shadow-[0_1px_3px_rgba(37,61,78,0.06)]';
    $input = 'w-full h-11 px-4 text-sm border border-gray-200 rounded-lg focus:ring-[#3BB77E] focus:border-[#3BB77E]';
@endphp

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="font-heading text-2xl lg:text-[28px] font-bold">Kelola Kategori</h1>
        <p class="text-sm text-gray-500 mt-1">{{ $categories->total() }} kategori produk</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center justify-center gap-2 h-11 px-5 rounded-lg bg-[#3BB77E] hover:bg-[#2F9960] text-white text-sm font-bold transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14m-7-7h14"/></svg>
        Tambah Kategori
    </a>
</div>

{{-- Pencarian --}}
<form method="GET" action="{{ route('admin.categories.index') }}" class="{{ $card }} p-4 sm:p-5 mb-6 flex flex-col sm:flex-row gap-3">
    <div class="relative flex-1">
        <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.2-5.2M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori..." class="{{ $input }} pl-10">
    </div>
    <div class="flex gap-2">
        <button type="submit" class="flex-1 sm:flex-none h-11 px-6 rounded-lg bg-[#3BB77E] hover:bg-[#2F9960] text-white text-sm font-bold transition-colors">Cari</button>
        @if(request('search'))
            <a href="{{ route('admin.categories.index') }}" class="h-11 px-4 rounded-lg border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 flex items-center">Reset</a>
        @endif
    </div>
</form>

@if ($categories->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3 sm:gap-4">
        @foreach ($categories as $category)
            <div class="{{ $card }} p-4 flex items-center gap-4 hover:border-[#BCE3C9] transition-colors">
                {{-- Ikon kategori (seperti di halaman toko) --}}
                <a href="{{ route('admin.categories.show', $category) }}" class="w-16 h-16 rounded-xl bg-[#F4F6FA] flex items-center justify-center flex-shrink-0 overflow-hidden">
                    @if ($category->image)
                        <img src="{{ asset($category->image) }}" alt="" class="w-12 h-12 object-contain">
                    @else
                        <svg class="w-8 h-8 text-[#3BB77E]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    @endif
                </a>

                <div class="min-w-0 flex-1">
                    <a href="{{ route('admin.categories.show', $category) }}" class="font-bold text-[15px] leading-tight hover:text-[#3BB77E] truncate block">{{ $category->name }}</a>
                    @if($category->description)
                        <p class="text-xs text-gray-500 truncate">{{ $category->description }}</p>
                    @endif
                    <div class="mt-1.5 flex items-center gap-2 text-xs">
                        <span class="font-semibold text-[#3BB77E]">{{ $category->products_count }} produk</span>
                        @if($category->type)
                            <span class="px-1.5 py-0.5 rounded bg-[#F4F6FA] text-gray-500">{{ $category->type === 'jasa' ? 'Jasa' : 'Barang' }}</span>
                        @endif
                    </div>
                </div>

                {{-- Aksi --}}
                <div class="flex items-center gap-1 flex-shrink-0">
                    <a href="{{ route('admin.categories.edit', $category) }}" title="Edit kategori" aria-label="Edit kategori"
                       class="w-9 h-9 flex items-center justify-center rounded-lg bg-[#DEF9EC] text-[#3BB77E] hover:bg-[#3BB77E] hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.2 5.2l3.6 3.6M4 20l4.2-1 10.3-10.3a2.5 2.5 0 00-3.6-3.6L4.6 15.4 4 20z"/></svg>
                    </a>
                    @if ($category->products_count == 0)
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Hapus kategori" aria-label="Hapus kategori"
                                    class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-400 hover:text-white hover:bg-[#F74B81] hover:border-[#F74B81] transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.9 12.1A2 2 0 0116.1 21H7.9a2 2 0 01-2-1.9L5 7m5 4v6m4-6v6M4 7h16M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
                            </button>
                        </form>
                    @else
                        <span title="Tidak bisa dihapus karena masih ada produk" class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-100 text-gray-200 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.9 12.1A2 2 0 0116.1 21H7.9a2 2 0 01-2-1.9L5 7m5 4v6m4-6v6M4 7h16M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
                        </span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @if($categories->hasPages())
        <div class="mt-6">
            {{ $categories->appends(request()->query())->links() }}
        </div>
    @endif
@else
    <div class="{{ $card }} p-12 text-center">
        <div class="w-14 h-14 rounded-xl bg-[#DEF9EC] text-[#3BB77E] flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
        </div>
        <h3 class="font-heading text-lg font-bold mb-1">{{ request('search') ? 'Kategori tidak ditemukan' : 'Belum ada kategori' }}</h3>
        <p class="text-sm text-gray-500 mb-6">{{ request('search') ? 'Coba kata kunci lain.' : 'Tambahkan kategori untuk mengelompokkan produk.' }}</p>
        <a href="{{ request('search') ? route('admin.categories.index') : route('admin.categories.create') }}" class="inline-flex h-11 px-5 items-center rounded-lg bg-[#3BB77E] hover:bg-[#2F9960] text-white text-sm font-bold transition-colors">
            {{ request('search') ? 'Lihat Semua' : 'Tambah Kategori' }}
        </a>
    </div>
@endif
@endsection
