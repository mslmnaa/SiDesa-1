@extends('layouts.guest')

@section('title', 'Daftar - BUMDes Marketplace')

@section('content')
@php
    $field = 'w-full h-12 pl-11 pr-4 text-[15px] bg-white border rounded-xl placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#3BB77E]/30 focus:border-[#3BB77E] transition-colors';
    $border = fn ($name) => $errors->has($name) ? 'border-[#F74B81]' : 'border-gray-200';
    $icon = 'w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none';
@endphp

<div class="min-h-screen flex bg-white text-[#253D4E] font-sans">

    @include('auth.partials.brand-panel', [
        'headline' => 'Gabung dan<br>dukung produk<br><span class="text-[#2F9960]">asli desa.</span>',
        'subtitle' => 'Buat akun gratis untuk belanja, menyimpan favorit, dan melacak pesanan Anda.',
    ])

    {{-- Form --}}
    <main class="flex-1 flex flex-col min-h-screen">
        <div class="flex items-center justify-between px-5 sm:px-10 pt-6">
            <a href="{{ route('home') }}" class="lg:hidden inline-flex items-center gap-2">
                <span class="w-11 h-11 rounded-xl bg-white ring-1 ring-black/5 shadow-sm flex items-center justify-center overflow-hidden"><img src="{{ asset('images/Logo.svg') }}" alt="" class="w-11 h-11 scale-[1.55]"></span>
                <span class="font-heading text-2xl font-bold">BUMDes</span>
            </a>
            <a href="{{ route('home') }}" class="ml-auto inline-flex items-center gap-1.5 text-sm font-semibold text-gray-500 hover:text-[#3BB77E] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Beranda
            </a>
        </div>

        <div class="flex-1 flex items-center justify-center px-5 sm:px-10 py-10">
            <div class="w-full max-w-[460px]">
                <h2 class="font-heading text-[30px] sm:text-[34px] font-bold leading-tight">Buat akun baru</h2>
                <p class="mt-2 text-[15px] text-gray-500">Gratis, hanya butuh satu menit.</p>

                <form class="mt-8 space-y-5" action="{{ route('register') }}" method="POST"
                      x-data="{ show: false, loading: false, pw: '', pw2: '' }" @submit="loading = true">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-bold mb-2">Nama lengkap</label>
                        <div class="relative">
                            <svg class="{{ $icon }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <input id="name" name="name" type="text" autocomplete="name" required autofocus
                                   value="{{ old('name') }}" placeholder="Nama sesuai identitas"
                                   class="{{ $field }} {{ $border('name') }}">
                        </div>
                        @error('name')<p class="mt-2 text-sm text-[#D6336C] font-semibold">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold mb-2">Email</label>
                        <div class="relative">
                            <svg class="{{ $icon }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <input id="email" name="email" type="email" autocomplete="email" required
                                   value="{{ old('email') }}" placeholder="nama@email.com"
                                   class="{{ $field }} {{ $border('email') }}">
                        </div>
                        @error('email')<p class="mt-2 text-sm text-[#D6336C] font-semibold">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-bold mb-2">No. WhatsApp <span class="font-normal text-gray-400">(opsional)</span></label>
                        <div class="relative">
                            <svg class="{{ $icon }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <input id="phone" name="phone" type="tel" inputmode="tel" autocomplete="tel" maxlength="15"
                                   value="{{ old('phone') }}" placeholder="08xxxxxxxxxx"
                                   class="{{ $field }} {{ $border('phone') }}">
                        </div>
                        @error('phone')<p class="mt-2 text-sm text-[#D6336C] font-semibold">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-bold mb-2">Alamat <span class="font-normal text-gray-400">(opsional)</span></label>
                        <textarea id="address" name="address" rows="2" autocomplete="street-address"
                                  placeholder="Bisa diisi nanti saat checkout"
                                  class="w-full px-4 py-3 text-[15px] bg-white border rounded-xl placeholder-gray-400 resize-none focus:outline-none focus:ring-2 focus:ring-[#3BB77E]/30 focus:border-[#3BB77E] transition-colors {{ $border('address') }}">{{ old('address') }}</textarea>
                        @error('address')<p class="mt-2 text-sm text-[#D6336C] font-semibold">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-4">
                        <div>
                            <label for="password" class="block text-sm font-bold mb-2">Password</label>
                            <div class="relative">
                                <svg class="{{ $icon }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <input id="password" name="password" :type="show ? 'text' : 'password'" type="password" autocomplete="new-password" required minlength="8"
                                       x-model="pw" placeholder="Min. 8 karakter"
                                       class="{{ $field }} pr-12 {{ $border('password') }}">
                                <button type="button" @click="show = !show" :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'"
                                        class="absolute right-2 top-1/2 -translate-y-1/2 w-9 h-9 flex items-center justify-center rounded-lg text-gray-400 hover:text-[#253D4E] hover:bg-gray-100 transition-colors">
                                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.5 12C3.8 7.9 7.6 5 12 5s8.2 2.9 9.5 7c-1.3 4.1-5.1 7-9.5 7s-8.2-2.9-9.5-7z"/></svg>
                                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.9 18.8A10 10 0 0112 19c-4.4 0-8.2-2.9-9.5-7a10 10 0 012.3-3.8m3.3-2.3A9.9 9.9 0 0112 5c4.4 0 8.2 2.9 9.5 7a10 10 0 01-4 5.2M15 12a3 3 0 00-4.2-2.8M3 3l18 18"/></svg>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold mb-2">Ulangi password</label>
                            <div class="relative">
                                <svg class="{{ $icon }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <input id="password_confirmation" name="password_confirmation" :type="show ? 'text' : 'password'" type="password" autocomplete="new-password" required
                                       x-model="pw2" placeholder="Ketik ulang"
                                       class="{{ $field }} {{ $border('password') }}">
                            </div>
                        </div>
                    </div>

                    {{-- Bantuan password --}}
                    <div class="-mt-2 text-xs font-semibold space-y-1" aria-live="polite">
                        @error('password')
                            <p class="text-sm text-[#D6336C]">{{ $message }}</p>
                        @else
                            <p :class="pw.length >= 8 ? 'text-[#2F9960]' : 'text-gray-400'">
                                <span x-text="pw.length >= 8 ? '✓' : '•'">•</span> Minimal 8 karakter
                            </p>
                            <p x-show="pw2.length > 0" x-cloak :class="pw === pw2 ? 'text-[#2F9960]' : 'text-[#D6336C]'"
                               x-text="pw === pw2 ? '✓ Password cocok' : '✕ Password belum sama'"></p>
                        @enderror
                    </div>

                    <button type="submit" :disabled="loading"
                            class="w-full h-12 rounded-xl bg-[#3BB77E] hover:bg-[#2F9960] disabled:opacity-70 text-white text-[15px] font-bold shadow-[0_8px_20px_-8px_rgba(59,183,126,0.7)] transition-colors flex items-center justify-center gap-2">
                        <svg x-show="loading" x-cloak class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-opacity=".3" stroke-width="3"/><path d="M21 12a9 9 0 00-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
                        <span x-text="loading ? 'Memproses...' : 'Daftar'">Daftar</span>
                    </button>

                    <p class="text-xs text-center text-gray-400 leading-relaxed">
                        Dengan mendaftar, Anda setuju data Anda dipakai untuk memproses pesanan di BUMDes Marketplace.
                    </p>
                </form>

                <p class="mt-8 text-center text-[15px] text-gray-500">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-bold text-[#3BB77E] hover:text-[#2F9960]">Masuk</a>
                </p>
            </div>
        </div>

        <p class="px-5 sm:px-10 pb-6 text-center lg:text-left text-xs text-gray-400">&copy; {{ date('Y') }} BUMDes Marketplace</p>
    </main>
</div>
@endsection
