@extends('layouts.app')

@section('title', 'Riwayat Infaq - BUMDes Marketplace')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Riwayat Infaq</h1>
                    <p class="text-gray-600 mt-2">Semua riwayat donasi infaq yang telah Anda berikan</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('profile') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                        ← Kembali ke Profile
                    </a>
                    <a href="{{ route('infaq.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Infaq Baru
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-8">
                @if($infaqs->count() > 0)
                    <div class="space-y-4">
                        @foreach($infaqs as $infaq)
                            <div class="bg-gray-50 rounded-xl border border-gray-200 overflow-hidden">
                                <div class="p-6">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <!-- Status Badge -->
                                            <div class="flex items-center gap-3 mb-4">
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                    {{ $infaq->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                       ($infaq->status === 'verified' ? 'bg-blue-100 text-blue-800' : 
                                                       ($infaq->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                       'bg-red-100 text-red-800')) }}">
                                                    {{ $infaq->status_label }}
                                                </span>
                                                <span class="text-sm text-gray-500">
                                                    {{ $infaq->created_at->format('d M Y, H:i') }}
                                                </span>
                                            </div>

                                            <!-- Amount and Payment Method -->
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                <div>
                                                    <p class="text-sm text-gray-600">Jumlah Donasi</p>
                                                    <p class="text-xl font-bold text-green-600">
                                                        Rp {{ number_format($infaq->amount, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-600">Metode Pembayaran</p>
                                                    <p class="text-base font-semibold text-gray-900">
                                                        {{ $infaq->payment_method_label }}
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Message -->
                                            @if($infaq->message)
                                                <div class="mb-4">
                                                    <p class="text-sm text-gray-600 mb-1">Pesan</p>
                                                    <p class="text-gray-900 bg-white rounded-lg p-3 border">
                                                        "{{ $infaq->message }}"
                                                    </p>
                                                </div>
                                            @endif

                                            <!-- Anonymous Status -->
                                            @if($infaq->anonymous)
                                                <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.464 6.464M9.878 9.878a3 3 0 00-4.243 4.243m7.073 7.073L6.464 6.464M19.072 19.072L6.464 6.464"/>
                                                    </svg>
                                                    Donasi Anonim
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Action Button -->
                                        <div class="ml-4">
                                            <a href="{{ route('infaq.show', $infaq) }}" 
                                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                Detail
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Payment Proof Preview -->
                                    @if($infaq->payment_proof)
                                        <div class="mt-4 pt-4 border-t border-gray-200">
                                            <p class="text-sm text-gray-600 mb-2">Bukti Pembayaran</p>
                                            <img src="{{ asset('storage/' . $infaq->payment_proof) }}" 
                                                 alt="Bukti Pembayaran"
                                                 class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $infaqs->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <div class="w-20 h-20 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Belum Ada Riwayat Infaq</h3>
                        <p class="text-gray-600 mb-6">Anda belum pernah melakukan donasi infaq. Mulai berbagi kebaikan sekarang!</p>
                        <a href="{{ route('infaq.create') }}" 
                           class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Mulai Berinfaq
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection