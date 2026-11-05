@extends('layouts.admin')

@section('title', 'Kelola Admin')

@section('content')
@php
    $card = 'bg-white rounded-2xl border border-gray-100 shadow-[0_1px_3px_rgba(37,61,78,0.06)]';
    $superCount = \App\Models\User::where('role', 'superadmin')->count();
    $villageAdminCount = \App\Models\User::where('role', 'admin')->count();
@endphp

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="font-heading text-2xl lg:text-[28px] font-bold">Kelola Admin</h1>
        <p class="text-sm text-gray-500 mt-1">Akun yang bisa masuk ke panel admin</p>
    </div>
    <a href="{{ route('admin.admins.create') }}" class="inline-flex items-center justify-center gap-2 h-11 px-5 rounded-lg bg-[#3BB77E] hover:bg-[#2F9960] text-white text-sm font-bold transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14m-7-7h14"/></svg>
        Tambah Admin
    </a>
</div>

{{-- Ringkasan --}}
<div class="grid grid-cols-2 lg:grid-cols-3 gap-3 lg:gap-4 mb-6">
    @foreach([
        ['Admin Desa', $villageAdminCount, 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
        ['Superadmin', $superCount, 'M9 12l2 2 4-4m5.6-4A12 12 0 0112 2.9 12 12 0 013.4 6 12 12 0 003 9c0 5.6 3.8 10.3 9 11.6 5.2-1.3 9-6 9-11.6 0-1-.1-2-.4-3z'],
        ['Total Akun Admin', $superCount + $villageAdminCount, 'M17 20h5v-2a3 3 0 00-5.4-1.9M17 20H7m10 0v-2c0-.7-.1-1.3-.4-1.9M7 20H2v-2a3 3 0 015.4-1.9M7 20v-2c0-.7.1-1.3.4-1.9m0 0a5 5 0 019.3 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
    ] as [$label, $count, $icon])
        <div class="{{ $card }} p-4 flex items-center gap-3 {{ $loop->last ? 'col-span-2 lg:col-span-1' : '' }}">
            <div class="w-10 h-10 rounded-xl bg-[#DEF9EC] text-[#3BB77E] flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="{{ $icon }}"/></svg>
            </div>
            <div>
                <p class="font-heading text-xl font-bold leading-tight">{{ $count }}</p>
                <p class="text-xs text-gray-500">{{ $label }}</p>
            </div>
        </div>
    @endforeach
</div>

<section class="{{ $card }} p-5 lg:p-6">
    @if($admins->count() > 0)
        <div class="hidden md:block overflow-x-auto -mx-5 lg:-mx-6 px-5 lg:px-6">
            <table class="w-full min-w-[820px] text-sm">
                <thead>
                    <tr class="bg-[#3BB77E] text-white text-xs">
                        <th class="text-left font-semibold py-3 pl-4 rounded-l-lg">Nama</th>
                        <th class="text-left font-semibold py-3 px-3">Peran</th>
                        <th class="text-left font-semibold py-3 px-3">Desa</th>
                        <th class="text-left font-semibold py-3 px-3">Telepon</th>
                        <th class="text-left font-semibold py-3 px-3">Dibuat</th>
                        <th class="text-right font-semibold py-3 pr-4 rounded-r-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($admins as $admin)
                        @php $canDelete = $admin->id !== auth()->id() && !$admin->isSuperAdmin(); @endphp
                        <tr class="hover:bg-[#F4F6FA]/60">
                            <td class="py-3 pl-2">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="w-10 h-10 rounded-full bg-[#DEF9EC] text-[#3BB77E] text-sm font-bold flex items-center justify-center flex-shrink-0">{{ strtoupper(mb_substr($admin->name, 0, 1)) }}</span>
                                    <div class="min-w-0">
                                        <p class="font-semibold truncate max-w-[220px]">{{ $admin->name }}@if($admin->id === auth()->id()) <span class="text-xs font-normal text-gray-400">(Anda)</span>@endif</p>
                                        <p class="text-xs text-gray-500 truncate max-w-[220px]">{{ $admin->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-3">
                                <span class="inline-block px-2 py-0.5 rounded-md text-xs font-bold {{ $admin->role === 'superadmin' ? 'bg-[#253D4E] text-white' : 'bg-[#DEF9EC] text-[#2F9960]' }}">
                                    {{ $admin->role === 'superadmin' ? 'Superadmin' : 'Admin Desa' }}
                                </span>
                            </td>
                            <td class="py-3 px-3">
                                @if($admin->village)
                                    <p class="font-semibold">{{ $admin->village->name }}</p>
                                    <p class="text-xs text-gray-500">{{ collect([$admin->village->district, $admin->village->city])->filter()->join(', ') }}</p>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="py-3 px-3 whitespace-nowrap">{{ $admin->phone ?? '-' }}</td>
                            <td class="py-3 px-3 whitespace-nowrap text-gray-600">{{ $admin->created_at->locale('id')->translatedFormat('j M Y') }}</td>
                            <td class="py-3 pr-2">
                                @include('admin.partials.row-actions', [
                                    'edit' => ($admin->isSuperAdmin() && $admin->id !== auth()->id()) ? null : route('admin.admins.edit', $admin),
                                    'delete' => $canDelete ? route('admin.admins.destroy', $admin) : null,
                                    'confirm' => 'Yakin ingin menghapus admin ' . $admin->name . '?',
                                ])
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="md:hidden divide-y divide-gray-100 -mx-1">
            @foreach($admins as $admin)
                @php $canDelete = $admin->id !== auth()->id() && !$admin->isSuperAdmin(); @endphp
                <div class="flex items-center gap-3 px-1 py-3">
                    <span class="w-10 h-10 rounded-full bg-[#DEF9EC] text-[#3BB77E] text-sm font-bold flex items-center justify-center flex-shrink-0">{{ strtoupper(mb_substr($admin->name, 0, 1)) }}</span>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold truncate">{{ $admin->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $admin->role === 'superadmin' ? 'Superadmin' : ($admin->village->name ?? 'Admin Desa') }}</p>
                    </div>
                    @include('admin.partials.row-actions', [
                        'edit' => ($admin->isSuperAdmin() && $admin->id !== auth()->id()) ? null : route('admin.admins.edit', $admin),
                        'delete' => $canDelete ? route('admin.admins.destroy', $admin) : null,
                        'confirm' => 'Yakin ingin menghapus admin ' . $admin->name . '?',
                    ])
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-sm text-gray-500 py-12">Belum ada admin.</p>
    @endif
</section>

@if($admins->hasPages())
    <div class="mt-6">
        {{ $admins->links() }}
    </div>
@endif
@endsection
