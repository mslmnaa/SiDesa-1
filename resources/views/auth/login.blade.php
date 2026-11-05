@extends('layouts.guest')

@section('title', 'Masuk - BUMDes Marketplace')

@section('content')
@php
    $fromCart = session('intended') || request()->get('redirect') === 'cart' || str_contains(url()->previous(), 'cart');
    $field = 'w-full h-12 pl-11 pr-4 text-[15px] bg-white border rounded-xl placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#3BB77E]/30 focus:border-[#3BB77E] transition-colors';
@endphp

<div class="min-h-screen flex bg-white text-[#253D4E] font-sans">

    @include('auth.partials.brand-panel')

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
            <div class="w-full max-w-[420px]">
                <h2 class="font-heading text-[30px] sm:text-[34px] font-bold leading-tight">Selamat datang kembali</h2>
                <p class="mt-2 text-[15px] text-gray-500">
                    Masuk untuk lanjut belanja produk desa.
                </p>

                @if($fromCart)
                    <div class="mt-6 flex items-start gap-3 rounded-xl bg-[#DEF9EC] border border-[#BCE3C9] px-4 py-3 text-sm">
                        <svg class="w-5 h-5 text-[#3BB77E] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 2.3c-.6.6-.2 1.7.7 1.7H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <p><span class="font-bold">Keranjang menunggu.</span> Masuk dulu untuk melihat dan checkout belanjaan Anda.</p>
                    </div>
                @endif

                @if(session('success'))
                    <div class="mt-6 rounded-xl bg-[#DEF9EC] border border-[#BCE3C9] px-4 py-3 text-sm font-semibold text-[#2F9960]">{{ session('success') }}</div>
                @endif

                <form class="mt-8 space-y-5" action="{{ route('login') }}" method="POST" x-data="{ show: false, loading: false }" @submit="loading = true">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-bold mb-2">Email</label>
                        <div class="relative">
                            <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <input id="email" name="email" type="email" autocomplete="email" required autofocus
                                   value="{{ old('email') }}" placeholder="nama@email.com"
                                   class="{{ $field }} {{ $errors->has('email') ? 'border-[#F74B81]' : 'border-gray-200' }}">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-[#D6336C] font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold mb-2">Password</label>
                        <div class="relative">
                            <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            <input id="password" name="password" :type="show ? 'text' : 'password'" type="password" autocomplete="current-password" required
                                   placeholder="Masukkan password"
                                   class="{{ $field }} pr-12 {{ $errors->has('password') ? 'border-[#F74B81]' : 'border-gray-200' }}">
                            <button type="button" @click="show = !show" :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 w-9 h-9 flex items-center justify-center rounded-lg text-gray-400 hover:text-[#253D4E] hover:bg-gray-100 transition-colors">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.5 12C3.8 7.9 7.6 5 12 5s8.2 2.9 9.5 7c-1.3 4.1-5.1 7-9.5 7s-8.2-2.9-9.5-7z"/></svg>
                                <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.9 18.8A10 10 0 0112 19c-4.4 0-8.2-2.9-9.5-7a10 10 0 012.3-3.8m3.3-2.3A9.9 9.9 0 0112 5c4.4 0 8.2 2.9 9.5 7a10 10 0 01-4 5.2M15 12a3 3 0 00-4.2-2.8M3 3l18 18"/></svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-[#D6336C] font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="inline-flex items-center gap-2.5 text-sm cursor-pointer select-none">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-[#3BB77E] focus:ring-[#3BB77E]">
                            Ingat saya
                        </label>
                        <a href="{{ route('contact') }}" class="text-sm font-semibold text-[#3BB77E] hover:text-[#2F9960]">Lupa password?</a>
                    </div>

                    <button type="submit" :disabled="loading"
                            class="w-full h-12 rounded-xl bg-[#3BB77E] hover:bg-[#2F9960] disabled:opacity-70 text-white text-[15px] font-bold shadow-[0_8px_20px_-8px_rgba(59,183,126,0.7)] transition-colors flex items-center justify-center gap-2">
                        <svg x-show="loading" x-cloak class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-opacity=".3" stroke-width="3"/><path d="M21 12a9 9 0 00-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
                        <span x-text="loading ? 'Memproses...' : 'Masuk'">Masuk</span>
                    </button>
                </form>

                <p class="mt-8 text-center text-[15px] text-gray-500">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-bold text-[#3BB77E] hover:text-[#2F9960]">Daftar gratis</a>
                </p>
            </div>
        </div>

        <p class="px-5 sm:px-10 pb-6 text-center lg:text-left text-xs text-gray-400">&copy; {{ date('Y') }} BUMDes Marketplace</p>
    </main>
</div>
@endsection
