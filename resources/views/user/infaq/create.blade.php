@extends('layouts.app')

@section('title', 'Form Infaq - BUMDes Marketplace')

@section('content')
<!-- Header -->
<section class="bg-gradient-to-r from-green-600 to-green-800 text-white py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center">
            <h1 class="text-4xl font-bold mb-4">Form Infaq Online</h1>
            <p class="text-xl">Berbagi kebaikan untuk sesama warga desa</p>
        </div>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-8">
                <form action="{{ route('infaq.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- Personal Information -->
                    <div class="border-b border-gray-200 pb-8">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Informasi Donatur</h2>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="donor_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap *
                                </label>
                                <input type="text" id="donor_name" name="donor_name" value="{{ old('donor_name') }}" required
                                       placeholder="Masukkan nama lengkap Anda"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('donor_name') border-red-500 @enderror">
                                @error('donor_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="donor_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nomor Telepon
                                </label>
                                <input type="tel" id="donor_phone" name="donor_phone" value="{{ old('donor_phone') }}"
                                       placeholder="Contoh: 08123456789"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('donor_phone') border-red-500 @enderror">
                                @error('donor_phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <label for="donor_email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email
                            </label>
                            <input type="email" id="donor_email" name="donor_email" value="{{ old('donor_email') }}"
                                   placeholder="email@example.com"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('donor_email') border-red-500 @enderror">
                            @error('donor_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6">
                            <div class="flex items-center">
                                <input type="checkbox" id="anonymous" name="anonymous" value="1" {{ old('anonymous') ? 'checked' : '' }}
                                       class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                                <label for="anonymous" class="ml-2 text-sm text-gray-700">
                                    Sembunyikan nama saya (donasi anonim)
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Donation Information -->
                    <div class="border-b border-gray-200 pb-8">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Informasi Donasi</h2>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jumlah Donasi *
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-3 text-gray-500">Rp</span>
                                    <input type="number" id="amount" name="amount" value="{{ old('amount') }}" required
                                           min="10000" step="1000" placeholder="10000"
                                           class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('amount') border-red-500 @enderror">
                                </div>
                                @error('amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Minimum donasi Rp 10.000</p>
                            </div>
                            
                            <div>
                                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                                    Metode Pembayaran *
                                </label>
                                <select id="payment_method" name="payment_method" required onchange="togglePaymentProof()"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('payment_method') border-red-500 @enderror">
                                    <option value="">Pilih metode pembayaran</option>
                                    <option value="transfer_bank" {{ old('payment_method') == 'transfer_bank' ? 'selected' : '' }}>Transfer Bank</option>
                                    <option value="e_wallet" {{ old('payment_method') == 'e_wallet' ? 'selected' : '' }}>E-Wallet (Dana/GoPay/OVO)</option>
                                    <option value="qris" {{ old('payment_method') == 'qris' ? 'selected' : '' }}>QRIS</option>
                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Tunai</option>
                                </select>
                                @error('payment_method')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                Pesan (Opsional)
                            </label>
                            <textarea id="message" name="message" rows="3" placeholder="Tuliskan pesan atau doa untuk warga desa yang membutuhkan..."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="border-b border-gray-200 pb-8">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Informasi Pembayaran</h2>
                        
                        <!-- Bank Transfer Info -->
                        <div id="bank-info" class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg hidden">
                            <h3 class="font-semibold text-blue-800 mb-3">Rekening Transfer</h3>
                            <div class="space-y-2 text-sm">
                                <p><span class="font-medium">Bank BCA:</span> 1234567890 a.n. BUMDes Marketplace</p>
                                <p><span class="font-medium">Bank Mandiri:</span> 1234567890 a.n. BUMDes Marketplace</p>
                                <p><span class="font-medium">Bank BRI:</span> 1234567890 a.n. BUMDes Marketplace</p>
                            </div>
                        </div>
                        
                        <!-- E-Wallet Info -->
                        <div id="ewallet-info" class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg hidden">
                            <h3 class="font-semibold text-green-800 mb-3">E-Wallet</h3>
                            <div class="space-y-2 text-sm">
                                <p><span class="font-medium">DANA:</span> 08123456789</p>
                                <p><span class="font-medium">GoPay:</span> 08123456789</p>
                                <p><span class="font-medium">OVO:</span> 08123456789</p>
                            </div>
                        </div>
                        
                        <!-- QRIS Info -->
                        <div id="qris-info" class="mb-6 p-4 bg-purple-50 border border-purple-200 rounded-lg hidden">
                            <h3 class="font-semibold text-purple-800 mb-3">Pembayaran QRIS</h3>
                            <div class="text-center">
                                <img src="{{ asset('images/qris.jpeg') }}" alt="QRIS Code" class="mx-auto mb-3 max-w-xs rounded-lg border">
                                <p class="text-sm text-purple-700">Scan QR Code di atas dengan aplikasi pembayaran digital Anda</p>
                            </div>
                        </div>
                        
                        <!-- Cash Info -->
                        <div id="cash-info" class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg hidden">
                            <h3 class="font-semibold text-yellow-800 mb-3">Pembayaran Tunai</h3>
                            <p class="text-sm text-yellow-700">
                                Silakan datang langsung ke kantor BUMDes pada jam kerja (Senin-Jumat, 08:00-16:00).
                                Alamat: Jl. Desa Digital No. 123, Kecamatan Pembangunan.
                            </p>
                        </div>
                        
                        <!-- Payment Proof Upload -->
                        <div id="payment-proof-section" class="hidden">
                            <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-2">
                                Bukti Pembayaran *
                            </label>
                            <input type="file" id="payment_proof" name="payment_proof" accept="image/*"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('payment_proof') border-red-500 @enderror">
                            @error('payment_proof')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Upload foto bukti transfer/pembayaran (Format: JPG, PNG. Max: 2MB)</p>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center pt-4">
                        <button type="submit" 
                                class="bg-green-600 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 focus:ring-opacity-50 transition-colors">
                            <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Kirim Donasi
                        </button>
                        <p class="mt-4 text-sm text-gray-500">
                            Dengan mengirim donasi, Anda setuju bahwa dana akan disalurkan untuk membantu warga desa yang membutuhkan.
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
function togglePaymentProof() {
    const paymentMethod = document.getElementById('payment_method').value;
    const bankInfo = document.getElementById('bank-info');
    const ewalletInfo = document.getElementById('ewallet-info');
    const cashInfo = document.getElementById('cash-info');
    const paymentProofSection = document.getElementById('payment-proof-section');
    const paymentProofInput = document.getElementById('payment_proof');
    
    // Hide all info sections
    bankInfo.classList.add('hidden');
    ewalletInfo.classList.add('hidden');
    const qrisInfo = document.getElementById('qris-info');
    qrisInfo.classList.add('hidden');
    cashInfo.classList.add('hidden');
    paymentProofSection.classList.add('hidden');
    
    // Remove required attribute
    paymentProofInput.removeAttribute('required');
    
    if (paymentMethod === 'transfer_bank') {
        bankInfo.classList.remove('hidden');
        paymentProofSection.classList.remove('hidden');
        paymentProofInput.setAttribute('required', 'required');
    } else if (paymentMethod === 'e_wallet') {
        ewalletInfo.classList.remove('hidden');
        paymentProofSection.classList.remove('hidden');
        paymentProofInput.setAttribute('required', 'required');
    } else if (paymentMethod === 'qris') {
        qrisInfo.classList.remove('hidden');
        paymentProofSection.classList.remove('hidden');
        paymentProofInput.setAttribute('required', 'required');
    } else if (paymentMethod === 'cash') {
        cashInfo.classList.remove('hidden');
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    togglePaymentProof();
});
</script>
@endsection