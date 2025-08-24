@extends('layouts.app')

@section('hero_fullscreen', true)

@section('title', 'Infaq Online - BUMDes Marketplace')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-green-600 to-green-800 text-white">
        <!-- Tambahkan padding top ekstra karena navbar fixed dan spacer dihilangkan -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-28 sm:pt-36 md:pt-40 pb-12 sm:pb-16 md:pb-20">
            <div class="text-center">
                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-6xl font-bold mb-4 sm:mb-6 leading-tight">Infaq Online
                </h1>
                <p class="text-base sm:text-lg md:text-xl lg:text-2xl mb-6 sm:mb-8 max-w-3xl mx-auto leading-relaxed px-2">
                    Berbagi kebaikan untuk warga desa yang membutuhkan. Mari bersama membantu sesama.
                </p>
                <a href="{{ route('infaq.create') }}"
                    class="bg-white text-green-600 px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-semibold text-base sm:text-lg hover:bg-gray-100 transition-colors inline-flex items-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                        </path>
                    </svg>
                    Mulai Berinfaq
                </a>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-12 sm:py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 sm:gap-8">
                <div class="bg-white rounded-lg shadow-lg p-6 sm:p-8 text-center">
                    <div
                        class="w-12 h-12 sm:w-16 sm:h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-green-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold text-green-600 mb-2">
                        Rp {{ number_format($totalCollected, 0, ',', '.') }}
                    </h3>
                    <p class="text-gray-600 text-sm sm:text-base">Total Dana Terkumpul</p>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-6 sm:p-8 text-center">
                    <div
                        class="w-12 h-12 sm:w-16 sm:h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-blue-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold text-blue-600 mb-2">{{ $totalDonors }}</h3>
                    <p class="text-gray-600 text-sm sm:text-base">Donatur</p>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-purple-600 mb-2">100%</h3>
                    <p class="text-gray-600">Disalurkan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Infaq Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Mengapa Infaq Online?</h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Platform Infaq Online BUMDes Marketplace hadir untuk memudahkan warga desa dalam berbagi kebaikan.
                        Dana yang terkumpul akan disalurkan langsung kepada warga desa yang membutuhkan bantuan.
                    </p>

                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-1 mr-3">
                                <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Transparan & Terpercaya</h3>
                                <p class="text-gray-600 text-sm">Setiap donasi diverifikasi dan dicatat dengan transparan
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-1 mr-3">
                                <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Mudah & Aman</h3>
                                <p class="text-gray-600 text-sm">Berbagai metode pembayaran yang mudah dan aman</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-1 mr-3">
                                <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Tepat Sasaran</h3>
                                <p class="text-gray-600 text-sm">Dana disalurkan langsung kepada yang membutuhkan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-100 to-green-200 rounded-2xl p-8">
                    <h3 class="text-2xl font-bold text-green-800 mb-4">Cara Kerja Infaq</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center font-semibold mr-4">
                                1</div>
                            <p class="text-green-700">Isi form donasi dengan nominal yang diinginkan</p>
                        </div>
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center font-semibold mr-4">
                                2</div>
                            <p class="text-green-700">Pilih metode pembayaran dan upload bukti</p>
                        </div>
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center font-semibold mr-4">
                                3</div>
                            <p class="text-green-700">Admin memverifikasi donasi Anda</p>
                        </div>
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center font-semibold mr-4">
                                4</div>
                            <p class="text-green-700">Dana disalurkan kepada yang membutuhkan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Donations Section -->
    @if ($recentDonations->count() > 0)
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Donasi Terbaru</h2>
                    <p class="text-xl text-gray-600">Para dermawan yang telah berbagi kebaikan</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($recentDonations as $donation)
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center mb-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-r from-green-400 to-green-600 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($donation->donor_name, 0, 2)) }}
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-semibold text-gray-900">{{ $donation->donor_name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $donation->created_at->format('d M Y') }}</p>
                                </div>
                            </div>

                            <div class="text-center py-4">
                                <p class="text-2xl font-bold text-green-600 mb-2">
                                    Rp {{ number_format($donation->amount, 0, ',', '.') }}
                                </p>
                                @if ($donation->message)
                                    <p class="text-gray-600 text-sm italic">"{{ $donation->message }}"</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Call to Action Section -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Mulai Berbagi Kebaikan Hari Ini</h2>
            <p class="text-xl text-gray-600 mb-8">
                Setiap kontribusi Anda, sekecil apapun, akan memberikan dampak besar bagi kehidupan warga desa yang
                membutuhkan.
            </p>
            <div class="space-x-4">
                <a href="{{ route('infaq.create') }}"
                    class="bg-green-600 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-green-700 transition-colors inline-flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                        </path>
                    </svg>
                    Berinfaq Sekarang
                </a>
                <a href="{{ route('contact') }}"
                    class="bg-gray-200 text-gray-700 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-300 transition-colors inline-flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                        </path>
                    </svg>
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>
@endsection
