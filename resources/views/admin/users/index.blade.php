@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('content')
@php
    $card = 'bg-white rounded-2xl border border-gray-100 shadow-[0_1px_3px_rgba(37,61,78,0.06)]';
    $input = 'w-full h-11 px-4 text-sm border border-gray-200 rounded-lg focus:ring-[#3BB77E] focus:border-[#3BB77E]';
@endphp

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="font-heading text-2xl lg:text-[28px] font-bold">Kelola Pengguna</h1>
        <p class="text-sm text-gray-500 mt-1">{{ number_format($totalUsers, 0, ',', '.') }} akun pembeli · Admin desa dikelola di menu <a href="{{ route('admin.admins.index') }}" class="font-semibold text-[#3BB77E] hover:underline">Admin Desa</a></p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center gap-2 h-11 px-5 rounded-lg bg-[#3BB77E] hover:bg-[#2F9960] text-white text-sm font-bold transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14m-7-7h14"/></svg>
        Tambah Pengguna
    </a>
</div>

{{-- Pencarian --}}
<form method="GET" action="{{ route('admin.users.index') }}" class="{{ $card }} p-4 sm:p-5 mb-6 flex flex-col sm:flex-row gap-3">
    <div class="relative flex-1">
        <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.2-5.2M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau nomor telepon..." class="{{ $input }} pl-10">
    </div>
    <div class="flex gap-2">
        <button type="submit" class="flex-1 sm:flex-none h-11 px-6 rounded-lg bg-[#3BB77E] hover:bg-[#2F9960] text-white text-sm font-bold transition-colors">Cari</button>
        @if(request('search'))
            <a href="{{ route('admin.users.index') }}" class="h-11 px-4 rounded-lg border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 flex items-center">Reset</a>
        @endif
    </div>
</form>

<section class="{{ $card }} p-5 lg:p-6">
    @if($users->count() > 0)
        <div class="hidden md:block overflow-x-auto -mx-5 lg:-mx-6 px-5 lg:px-6">
            <table class="w-full min-w-[760px] text-sm">
                <thead>
                    <tr class="bg-[#3BB77E] text-white text-xs">
                        <th class="text-left font-semibold py-3 pl-4 rounded-l-lg">Pengguna</th>
                        <th class="text-left font-semibold py-3 px-3">Kontak</th>
                        <th class="text-center font-semibold py-3 px-3">Keranjang</th>
                        <th class="text-left font-semibold py-3 px-3">Bergabung</th>
                        <th class="text-right font-semibold py-3 pr-4 rounded-r-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($users as $user)
                        <tr class="hover:bg-[#F4F6FA]/60">
                            <td class="py-3 pl-2">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="w-10 h-10 rounded-full bg-[#DEF9EC] text-[#3BB77E] text-sm font-bold flex items-center justify-center flex-shrink-0">{{ strtoupper(mb_substr($user->name, 0, 2)) }}</span>
                                    <div class="min-w-0">
                                        <p class="font-semibold truncate max-w-[220px]">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500 truncate max-w-[220px]">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-3">
                                <p>{{ $user->phone ?? '-' }}</p>
                                @if($user->address)<p class="text-xs text-gray-500 truncate max-w-[220px]">{{ $user->address }}</p>@endif
                            </td>
                            <td class="py-3 px-3 text-center font-semibold">{{ $user->carts->count() }}</td>
                            <td class="py-3 px-3 whitespace-nowrap text-gray-600">{{ $user->created_at->locale('id')->translatedFormat('j M Y') }}</td>
                            <td class="py-3 pr-2">
                                @include('admin.partials.row-actions', [
                                    'show' => route('admin.users.show', $user),
                                    'edit' => route('admin.users.edit', $user),
                                    'delete' => route('admin.users.destroy', $user),
                                    'confirm' => 'Yakin ingin menghapus pengguna ' . $user->name . '?',
                                ])
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="md:hidden divide-y divide-gray-100 -mx-1">
            @foreach($users as $user)
                <div class="flex items-center gap-3 px-1 py-3">
                    <span class="w-10 h-10 rounded-full bg-[#DEF9EC] text-[#3BB77E] text-sm font-bold flex items-center justify-center flex-shrink-0">{{ strtoupper(mb_substr($user->name, 0, 2)) }}</span>
                    <a href="{{ route('admin.users.show', $user) }}" class="min-w-0 flex-1">
                        <p class="text-sm font-semibold truncate">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                    </a>
                    @include('admin.partials.row-actions', [
                        'edit' => route('admin.users.edit', $user),
                        'delete' => route('admin.users.destroy', $user),
                        'confirm' => 'Yakin ingin menghapus pengguna ' . $user->name . '?',
                    ])
                </div>
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center justify-center text-center py-12">
            <div class="w-12 h-12 rounded-xl bg-[#DEF9EC] text-[#3BB77E] flex items-center justify-center mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <p class="text-sm font-semibold">{{ request('search') ? 'Pengguna tidak ditemukan' : 'Belum ada pengguna' }}</p>
            <p class="text-xs text-gray-500">{{ request('search') ? 'Coba kata kunci lain.' : 'Akun pembeli yang mendaftar akan muncul di sini.' }}</p>
        </div>
    @endif
</section>

@if($users->hasPages())
    <div class="mt-6">
        {{ $users->appends(request()->query())->links() }}
    </div>
@endif
@endsection
