@extends('layouts.admin')

@section('title', 'Kelola Desa')

@section('content')
@php
    $card = 'bg-white rounded-2xl border border-gray-100 shadow-[0_1px_3px_rgba(37,61,78,0.06)]';
@endphp

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="font-heading text-2xl lg:text-[28px] font-bold">Kelola Desa</h1>
        <p class="text-sm text-gray-500 mt-1">{{ $villages->total() }} desa/BUMDes terdaftar</p>
    </div>
    <a href="{{ route('admin.villages.create') }}" class="inline-flex items-center justify-center gap-2 h-11 px-5 rounded-lg bg-[#3BB77E] hover:bg-[#2F9960] text-white text-sm font-bold transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14m-7-7h14"/></svg>
        Tambah Desa
    </a>
</div>

<section class="{{ $card }} p-5 lg:p-6">
    @if($villages->count() > 0)
        <div class="hidden md:block overflow-x-auto -mx-5 lg:-mx-6 px-5 lg:px-6">
            <table class="w-full min-w-[820px] text-sm">
                <thead>
                    <tr class="bg-[#3BB77E] text-white text-xs">
                        <th class="text-left font-semibold py-3 pl-4 rounded-l-lg">Desa</th>
                        <th class="text-left font-semibold py-3 px-3">Lokasi</th>
                        <th class="text-center font-semibold py-3 px-3">Produk</th>
                        <th class="text-left font-semibold py-3 px-3">Kontak</th>
                        <th class="text-center font-semibold py-3 px-3">Status</th>
                        <th class="text-right font-semibold py-3 pr-4 rounded-r-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($villages as $village)
                        <tr class="hover:bg-[#F4F6FA]/60">
                            <td class="py-3 pl-2">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="w-10 h-10 rounded-full bg-[#F4F6FA] flex items-center justify-center flex-shrink-0 overflow-hidden">
                                        @if($village->logo)
                                            <img src="{{ asset($village->logo) }}" alt="" class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-5 h-5 text-[#3BB77E]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        @endif
                                    </span>
                                    <div class="min-w-0">
                                        <p class="font-semibold truncate max-w-[220px]">{{ $village->name }}</p>
                                        <p class="text-xs text-gray-500 truncate max-w-[220px]">{{ $village->slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-3">
                                <p>{{ collect([$village->district, $village->city])->filter()->join(', ') ?: '-' }}</p>
                                <p class="text-xs text-gray-500">{{ $village->province }}</p>
                            </td>
                            <td class="py-3 px-3 text-center font-semibold">{{ $village->products_count }}</td>
                            <td class="py-3 px-3">
                                <p>{{ $village->phone ?? '-' }}</p>
                                <p class="text-xs text-gray-500 truncate max-w-[220px]">{{ $village->email }}</p>
                            </td>
                            <td class="py-3 px-3 text-center">
                                <form action="{{ route('admin.villages.toggle-status', $village) }}" method="POST">
                                    @csrf
                                    <button type="submit" title="Klik untuk mengubah status"
                                            class="inline-block px-2 py-0.5 rounded-md text-xs font-bold transition-colors {{ $village->status === 'active' ? 'bg-[#DEF9EC] text-[#2F9960] hover:bg-[#BCE3C9]' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                                        {{ $village->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                                    </button>
                                </form>
                            </td>
                            <td class="py-3 pr-2">
                                @include('admin.partials.row-actions', [
                                    'show' => route('admin.villages.show', $village),
                                    'edit' => route('admin.villages.edit', $village),
                                    'delete' => route('admin.villages.destroy', $village),
                                    'confirm' => 'Yakin ingin menghapus ' . $village->name . '?',
                                ])
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="md:hidden divide-y divide-gray-100 -mx-1">
            @foreach($villages as $village)
                <div class="flex items-center gap-3 px-1 py-3">
                    <span class="w-10 h-10 rounded-full bg-[#F4F6FA] flex items-center justify-center flex-shrink-0 overflow-hidden">
                        @if($village->logo)
                            <img src="{{ asset($village->logo) }}" alt="" class="w-full h-full object-cover">
                        @endif
                    </span>
                    <a href="{{ route('admin.villages.show', $village) }}" class="min-w-0 flex-1">
                        <p class="text-sm font-semibold truncate">{{ $village->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $village->products_count }} produk · {{ $village->status === 'active' ? 'Aktif' : 'Nonaktif' }}</p>
                    </a>
                    @include('admin.partials.row-actions', [
                        'edit' => route('admin.villages.edit', $village),
                        'delete' => route('admin.villages.destroy', $village),
                        'confirm' => 'Yakin ingin menghapus ' . $village->name . '?',
                    ])
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-sm text-gray-500 py-12">Belum ada desa terdaftar.</p>
    @endif
</section>

@if($villages->hasPages())
    <div class="mt-6">
        {{ $villages->links() }}
    </div>
@endif
@endsection
