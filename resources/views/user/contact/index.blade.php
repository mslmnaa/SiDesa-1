@extends('layouts.app')

@section('title', 'Gabung Mitra - BUMDes Marketplace')

@section('content')
<div class="bg-gradient-to-b from-green-50 to-white min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                Bergabung Sebagai Mitra
            </h1>
            <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto">
                Tingkatkan penjualan produk desa Anda dengan bergabung di platform marketplace kami
            </p>
        </div>

        <!-- Benefits Section -->
        <div class="mb-12">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 text-center mb-8">
                Keuntungan Menjadi Mitra
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Benefit 1 -->
                <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Platform Gratis</h3>
                    <p class="text-gray-600">Bergabung tanpa biaya pendaftaran dan kelola produk Anda dengan mudah</p>
                </div>

                <!-- Benefit 2 -->
                <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Jangkauan Lebih Luas</h3>
                    <p class="text-gray-600">Produk desa Anda dapat diakses oleh pembeli dari berbagai wilayah</p>
                </div>

                <!-- Benefit 3 -->
                <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-lg mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Terpercaya & Aman</h3>
                    <p class="text-gray-600">Platform yang sudah terbukti membantu banyak desa memasarkan produknya</p>
                </div>

                <!-- Benefit 4 -->
                <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-center w-12 h-12 bg-yellow-100 rounded-lg mb-4">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Mudah Digunakan</h3>
                    <p class="text-gray-600">Dashboard sederhana untuk mengelola produk dan pesanan Anda</p>
                </div>

                <!-- Benefit 5 -->
                <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-center w-12 h-12 bg-red-100 rounded-lg mb-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Dukungan Admin</h3>
                    <p class="text-gray-600">Tim kami siap membantu Anda dalam mengelola toko online</p>
                </div>

                <!-- Benefit 6 -->
                <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-center w-12 h-12 bg-indigo-100 rounded-lg mb-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Tingkatkan Penjualan</h3>
                    <p class="text-gray-600">Raih peluang penjualan lebih banyak dengan eksposur yang lebih baik</p>
                </div>
            </div>
        </div>

        <!-- How to Join Section -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-12">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 text-center mb-8">
                Cara Bergabung
            </h2>
            <div class="max-w-3xl mx-auto">
                <div class="space-y-6">
                    <!-- Step 1 -->
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-bold text-lg">
                            1
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Hubungi Admin via WhatsApp</h3>
                            <p class="text-gray-600">Klik tombol "Hubungi Admin" di bawah untuk memulai percakapan dengan tim kami</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-bold text-lg">
                            2
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Konsultasi & Verifikasi</h3>
                            <p class="text-gray-600">Admin akan menjelaskan detail kemitraan dan melakukan verifikasi data desa Anda</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-bold text-lg">
                            3
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Aktivasi Akun</h3>
                            <p class="text-gray-600">Setelah disetujui, akun Anda akan diaktifkan dan Anda bisa mulai upload produk</p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-bold text-lg">
                            4
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Mulai Berjualan</h3>
                            <p class="text-gray-600">Unggah produk desa Anda dan mulai menjangkau pembeli dari berbagai daerah</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Button -->
        <div class="text-center">
            @if($whatsappUrl)
                <a href="{{ $whatsappUrl }}" target="_blank"
                   class="inline-flex items-center bg-green-600 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-green-700 transition-all transform hover:scale-105 shadow-lg">
                    <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Hubungi Admin via WhatsApp
                </a>
                <p class="mt-4 text-gray-600">
                    Atau hubungi langsung:
                    <span class="font-semibold text-gray-900">{{ $whatsappNumber ? \App\Helpers\WhatsappHelper::getDisplayPhoneNumber($whatsappNumber) : '-' }}</span>
                </p>
            @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 max-w-lg mx-auto">
                    <p class="text-yellow-800">
                        Nomor WhatsApp admin belum diatur. Silakan hubungi administrator untuk informasi lebih lanjut.
                    </p>
                </div>
            @endif
        </div>

        <!-- FAQ Section -->
        <div class="mt-16">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 text-center mb-8">
                Pertanyaan Umum
            </h2>
            <div class="max-w-3xl mx-auto space-y-4">
                <!-- FAQ 1 -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Apakah ada biaya untuk bergabung?</h3>
                    <p class="text-gray-600">Tidak ada biaya pendaftaran. Platform ini gratis untuk digunakan oleh desa-desa yang ingin memasarkan produknya.</p>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Produk apa saja yang bisa dijual?</h3>
                    <p class="text-gray-600">Berbagai produk dari desa seperti hasil pertanian, kerajinan tangan, produk olahan makanan, dan jasa wisata desa.</p>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Berapa lama proses verifikasi?</h3>
                    <p class="text-gray-600">Proses verifikasi biasanya memakan waktu 1-3 hari kerja setelah semua data lengkap diterima.</p>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Bagaimana sistem pembayaran?</h3>
                    <p class="text-gray-600">Pembayaran dilakukan langsung antara pembeli dan penjual. Admin akan memberikan panduan lengkap saat proses onboarding.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
