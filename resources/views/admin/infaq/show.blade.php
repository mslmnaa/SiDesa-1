@extends('layouts.admin')

@section('title', 'Detail Infaq')

@section('content')
<!-- Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Detail Infaq #{{ str_pad($infaq->id, 6, '0', STR_PAD_LEFT) }}</h1>
        <p class="text-gray-600 mt-2">Kelola dan verifikasi donasi infaq</p>
    </div>
    <a href="{{ route('admin.infaq.index') }}" 
       class="bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition-colors">
        Kembali
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Information -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Donation Details -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Informasi Donasi</h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">ID Donasi</label>
                        <p class="text-lg font-semibold">#{{ str_pad($infaq->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jumlah Donasi</label>
                        <p class="text-2xl font-bold text-green-600">Rp {{ number_format($infaq->amount, 0, ',', '.') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                        <p class="text-gray-900">{{ $infaq->payment_method_label }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Donasi</label>
                        <p class="text-gray-900">{{ $infaq->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $infaq->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $infaq->status === 'verified' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $infaq->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $infaq->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ $infaq->status_label }}
                        </span>
                    </div>
                    
                    @if($infaq->verified_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Verifikasi</label>
                            <p class="text-gray-900">{{ $infaq->verified_at->format('d M Y H:i') }}</p>
                        </div>
                    @endif
                    
                    @if($infaq->verifier)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Diverifikasi Oleh</label>
                            <p class="text-gray-900">{{ $infaq->verifier->name }}</p>
                        </div>
                    @endif
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Donasi Anonim</label>
                        <p class="text-gray-900">{{ $infaq->anonymous ? 'Ya' : 'Tidak' }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Donor Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Informasi Donatur</h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Donatur</label>
                        <p class="text-gray-900">{{ $infaq->donor_name }}</p>
                    </div>
                    
                    @if($infaq->donor_phone)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                            <p class="text-gray-900">{{ $infaq->donor_phone }}</p>
                        </div>
                    @endif
                </div>
                
                <div class="space-y-4">
                    @if($infaq->donor_email)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="text-gray-900">{{ $infaq->donor_email }}</p>
                        </div>
                    @endif
                </div>
            </div>
            
            @if($infaq->message)
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pesan Donatur</label>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700 italic">"{{ $infaq->message }}"</p>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Payment Proof -->
        @if($infaq->payment_proof)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Bukti Pembayaran</h2>
                <div class="text-center">
                    <img src="{{ asset('storage/' . $infaq->payment_proof) }}" 
                         alt="Bukti Pembayaran" 
                         class="max-w-full max-h-96 mx-auto rounded-lg shadow-lg">
                    <p class="text-sm text-gray-500 mt-2">Klik gambar untuk memperbesar</p>
                </div>
            </div>
        @endif
        
        <!-- Admin Notes -->
        @if($infaq->admin_notes)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Catatan Admin</h2>
                <div class="bg-yellow-50 rounded-lg p-4">
                    <p class="text-gray-700">{{ $infaq->admin_notes }}</p>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Action Panel -->
    <div class="space-y-6">
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
            
            @if($infaq->status === 'pending')
                <div class="space-y-3">
                    <form method="POST" action="{{ route('admin.infaq.verify', $infaq) }}" class="w-full">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors"
                                onclick="return confirm('Apakah Anda yakin ingin memverifikasi donasi ini?')">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Verifikasi Donasi
                        </button>
                    </form>
                    
                    <button type="button" 
                            onclick="document.getElementById('reject-modal').classList.remove('hidden')"
                            class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Tolak Donasi
                    </button>
                </div>
            @elseif($infaq->status === 'verified')
                <form method="POST" action="{{ route('admin.infaq.complete', $infaq) }}" class="w-full">
                    @csrf
                    <button type="submit" 
                            class="w-full bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition-colors"
                            onclick="return confirm('Apakah dana sudah disalurkan kepada yang membutuhkan?')">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Tandai Selesai
                    </button>
                </form>
            @elseif($infaq->status === 'completed')
                <div class="text-center text-green-600">
                    <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <p class="font-semibold">Donasi Selesai</p>
                    <p class="text-sm text-gray-500">Dana telah disalurkan</p>
                </div>
            @elseif($infaq->status === 'rejected')
                <div class="text-center text-red-600">
                    <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <p class="font-semibold">Donasi Ditolak</p>
                </div>
            @endif
        </div>
        
        <!-- Update Status Form -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Update Status</h3>
            
            <form method="POST" action="{{ route('admin.infaq.update-status', $infaq) }}" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Baru</label>
                    <select name="status" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                        <option value="pending" {{ $infaq->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="verified" {{ $infaq->status === 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                        <option value="completed" {{ $infaq->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="rejected" {{ $infaq->status === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Admin</label>
                    <textarea name="admin_notes" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500"
                              placeholder="Tambahkan catatan jika diperlukan...">{{ $infaq->admin_notes }}</textarea>
                </div>
                
                <button type="submit" 
                        class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                    Update Status
                </button>
            </form>
        </div>
        
        <!-- Payment Information -->
        @if(in_array($infaq->payment_method, ['transfer_bank', 'e_wallet']))
            <div class="bg-blue-50 rounded-lg p-4">
                <h4 class="font-semibold text-blue-800 mb-2">Informasi Pembayaran</h4>
                @if($infaq->payment_method === 'transfer_bank')
                    <div class="text-sm text-blue-700">
                        <p><strong>Bank BCA:</strong> 1234567890</p>
                        <p><strong>Bank Mandiri:</strong> 1234567890</p>
                        <p><strong>Bank BRI:</strong> 1234567890</p>
                        <p class="mt-2">a.n. BUMDes Marketplace</p>
                    </div>
                @else
                    <div class="text-sm text-blue-700">
                        <p><strong>DANA:</strong> 08123456789</p>
                        <p><strong>GoPay:</strong> 08123456789</p>
                        <p><strong>OVO:</strong> 08123456789</p>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div id="reject-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <form method="POST" action="{{ route('admin.infaq.reject', $infaq) }}">
            @csrf
            <h3 class="text-lg font-bold text-gray-900 mb-4">Tolak Donasi</h3>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan *</label>
                <textarea name="admin_notes" rows="4" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-red-500 focus:border-red-500"
                          placeholder="Jelaskan alasan penolakan donasi ini..."></textarea>
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="flex-1 bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                    Tolak Donasi
                </button>
                <button type="button" 
                        onclick="document.getElementById('reject-modal').classList.add('hidden')"
                        class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection