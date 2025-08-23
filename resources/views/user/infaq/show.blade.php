@extends('layouts.app')

@section('title', 'Detail Donasi - BUMDes Marketplace')

@section('content')
<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Success Message -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
            <div class="bg-green-600 text-white p-6 text-center">
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold mb-2">Terima Kasih atas Donasi Anda!</h1>
                <p class="text-green-100">Donasi Anda telah berhasil dikirim dan sedang menunggu verifikasi admin.</p>
            </div>
        </div>

        <!-- Donation Details -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Detail Donasi</h2>
            
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Donation Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Donasi</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">ID Donasi:</span>
                            <span class="font-medium">#{{ str_pad($infaq->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal:</span>
                            <span class="font-medium">{{ $infaq->created_at->format('d M Y H:i') }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jumlah Donasi:</span>
                            <span class="font-bold text-green-600 text-xl">Rp {{ number_format($infaq->amount, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Metode Pembayaran:</span>
                            <span class="font-medium">{{ $infaq->payment_method_label }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $infaq->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $infaq->status === 'verified' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $infaq->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $infaq->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ $infaq->status_label }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Donor Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Donatur</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nama:</span>
                            <span class="font-medium">
                                @if($infaq->anonymous)
                                    <em>Anonim</em>
                                @else
                                    {{ $infaq->donor_name }}
                                @endif
                            </span>
                        </div>
                        
                        @if($infaq->donor_phone && !$infaq->anonymous)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Telepon:</span>
                                <span class="font-medium">{{ $infaq->donor_phone }}</span>
                            </div>
                        @endif
                        
                        @if($infaq->donor_email && !$infaq->anonymous)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-medium">{{ $infaq->donor_email }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            @if($infaq->message)
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Pesan Donatur</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700 italic">"{{ $infaq->message }}"</p>
                    </div>
                </div>
            @endif
            
            @if($infaq->payment_proof)
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Bukti Pembayaran</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <img src="{{ asset('storage/' . $infaq->payment_proof) }}" 
                             alt="Bukti Pembayaran" 
                             class="max-w-md mx-auto rounded-lg shadow-md">
                    </div>
                </div>
            @endif
        </div>

        <!-- Status Information -->
        <div class="bg-white rounded-lg shadow-lg p-8 mt-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Informasi Status</h2>
            
            @if($infaq->status === 'pending')
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                    <div class="flex items-center mb-3">
                        <svg class="w-6 h-6 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-yellow-800">Menunggu Verifikasi</h3>
                    </div>
                    <p class="text-yellow-700">
                        Donasi Anda sedang dalam proses verifikasi oleh admin. Proses ini biasanya memakan waktu 1-2 hari kerja. 
                        Kami akan segera memproses donasi Anda setelah terverifikasi.
                    </p>
                </div>
            @elseif($infaq->status === 'verified')
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <div class="flex items-center mb-3">
                        <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-blue-800">Donasi Terverifikasi</h3>
                    </div>
                    <p class="text-blue-700">
                        Donasi Anda telah berhasil diverifikasi pada {{ $infaq->verified_at ? $infaq->verified_at->format('d M Y H:i') : '-' }}. 
                        Dana sedang dalam proses penyaluran kepada yang membutuhkan.
                    </p>
                </div>
            @elseif($infaq->status === 'completed')
                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                    <div class="flex items-center mb-3">
                        <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-green-800">Donasi Selesai</h3>
                    </div>
                    <p class="text-green-700">
                        Alhamdulillah, donasi Anda telah berhasil disalurkan kepada warga desa yang membutuhkan. 
                        Terima kasih atas kebaikan dan kepedulian Anda.
                    </p>
                </div>
            @elseif($infaq->status === 'rejected')
                <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                    <div class="flex items-center mb-3">
                        <svg class="w-6 h-6 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-red-800">Donasi Ditolak</h3>
                    </div>
                    <p class="text-red-700">
                        Maaf, donasi Anda tidak dapat diproses karena beberapa alasan. 
                        @if($infaq->admin_notes)
                            Alasan: {{ $infaq->admin_notes }}
                        @endif
                        Silakan hubungi admin untuk informasi lebih lanjut.
                    </p>
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="text-center mt-8 space-x-4">
            <a href="{{ route('infaq') }}" 
               class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                Kembali ke Infaq Online
            </a>
            <a href="{{ route('contact') }}" 
               class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                Hubungi Admin
            </a>
        </div>
    </div>
</section>
@endsection