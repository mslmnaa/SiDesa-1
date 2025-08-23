@extends('layouts.admin')

@section('title', 'Pengaturan Desa')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Pengaturan Desa</h1>
        <p class="text-gray-600 mt-2">Kelola informasi desa dan kontak kepala desa</p>
    </div>
</div>

<!-- Success Message -->
@if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        </div>
    </div>
@endif

<div class="bg-white rounded-lg shadow">
    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6 p-8">
        @csrf
        
        <!-- Email Settings -->
        <div class="border-b border-gray-200 pb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Pengaturan Email Kontak</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Village Head Email -->
                <div>
                    <label for="village_head_email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Kepala Desa *
                    </label>
                    <input type="email" id="village_head_email" name="village_head_email" 
                           value="{{ old('village_head_email', $settings['village_head_email']) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('village_head_email') border-red-500 @enderror">
                    @error('village_head_email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        Email ini akan menerima pesan dari form kontak website
                    </p>
                </div>
            </div>
        </div>

        <!-- SMTP Email Configuration -->
        <div class="border-b border-gray-200 pb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Konfigurasi Email SMTP</h2>
            <p class="text-sm text-gray-600 mb-6">
                Konfigurasikan SMTP untuk mengirim email secara otomatis. Kosongkan untuk menggunakan log email saja.
            </p>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- SMTP Host -->
                <div>
                    <label for="smtp_host" class="block text-sm font-medium text-gray-700 mb-2">
                        SMTP Host
                    </label>
                    <input type="text" id="smtp_host" name="smtp_host" 
                           value="{{ old('smtp_host', $settings['smtp_host']) }}"
                           placeholder="smtp.gmail.com"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('smtp_host') border-red-500 @enderror">
                    @error('smtp_host')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SMTP Port -->
                <div>
                    <label for="smtp_port" class="block text-sm font-medium text-gray-700 mb-2">
                        SMTP Port
                    </label>
                    <input type="number" id="smtp_port" name="smtp_port" 
                           value="{{ old('smtp_port', $settings['smtp_port']) }}"
                           placeholder="587"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('smtp_port') border-red-500 @enderror">
                    @error('smtp_port')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SMTP Username -->
                <div>
                    <label for="smtp_username" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Username
                    </label>
                    <input type="email" id="smtp_username" name="smtp_username" 
                           value="{{ old('smtp_username', $settings['smtp_username']) }}"
                           placeholder="your-email@gmail.com"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('smtp_username') border-red-500 @enderror">
                    @error('smtp_username')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SMTP Password -->
                <div>
                    <label for="smtp_password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password / App Password
                    </label>
                    <input type="password" id="smtp_password" name="smtp_password" 
                           value="{{ old('smtp_password', $settings['smtp_password']) }}"
                           placeholder="App Password dari Gmail"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('smtp_password') border-red-500 @enderror">
                    @error('smtp_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SMTP Encryption -->
                <div>
                    <label for="smtp_encryption" class="block text-sm font-medium text-gray-700 mb-2">
                        Enkripsi
                    </label>
                    <select id="smtp_encryption" name="smtp_encryption"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('smtp_encryption') border-red-500 @enderror">
                        <option value="tls" {{ old('smtp_encryption', $settings['smtp_encryption']) == 'tls' ? 'selected' : '' }}>TLS (Recommended)</option>
                        <option value="ssl" {{ old('smtp_encryption', $settings['smtp_encryption']) == 'ssl' ? 'selected' : '' }}>SSL</option>
                    </select>
                    @error('smtp_encryption')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mail From Name -->
                <div>
                    <label for="mail_from_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Pengirim Email
                    </label>
                    <input type="text" id="mail_from_name" name="mail_from_name" 
                           value="{{ old('mail_from_name', $settings['mail_from_name']) }}"
                           placeholder="Website Desa"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('mail_from_name') border-red-500 @enderror">
                    @error('mail_from_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- SMTP Info Box -->
            <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Cara Setup Gmail SMTP</h3>
                        <div class="mt-1 text-sm text-yellow-700">
                            <ol class="list-decimal list-inside space-y-1">
                                <li>
                                    Buka link: 
                                    <a href="https://myaccount.google.com/security" target="_blank" class="text-blue-600 hover:text-blue-800 underline font-medium">
                                        Google Account Security
                                    </a>
                                </li>
                                <li>Aktifkan "2-Step Verification" (jika belum aktif)</li>
                                <li>
                                    Klik "App passwords" atau buka: 
                                    <a href="https://myaccount.google.com/apppasswords" target="_blank" class="text-blue-600 hover:text-blue-800 underline font-medium">
                                        App Passwords
                                    </a>
                                </li>
                                <li>Generate password untuk "Mail"</li>
                                <li>Copy 16-digit password ke kolom password di atas</li>
                                <li>Host: smtp.gmail.com, Port: 587, Encryption: TLS</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Village Information -->
        <div class="border-b border-gray-200 pb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Desa</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Village Name -->
                <div>
                    <label for="village_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Desa *
                    </label>
                    <input type="text" id="village_name" name="village_name" 
                           value="{{ old('village_name', $settings['village_name']) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('village_name') border-red-500 @enderror">
                    @error('village_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Village Head Name -->
                <div>
                    <label for="village_head_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Kepala Desa *
                    </label>
                    <input type="text" id="village_head_name" name="village_head_name" 
                           value="{{ old('village_head_name', $settings['village_head_name']) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('village_head_name') border-red-500 @enderror">
                    @error('village_head_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Village Phone -->
                <div>
                    <label for="village_phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Telepon Desa
                    </label>
                    <input type="text" id="village_phone" name="village_phone" 
                           value="{{ old('village_phone', $settings['village_phone']) }}"
                           placeholder="Contoh: (021) 1234567"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('village_phone') border-red-500 @enderror">
                    @error('village_phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Village Address -->
            <div class="mt-6">
                <label for="village_address" class="block text-sm font-medium text-gray-700 mb-2">
                    Alamat Desa
                </label>
                <textarea id="village_address" name="village_address" rows="3"
                          placeholder="Alamat lengkap kantor desa..."
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('village_address') border-red-500 @enderror">{{ old('village_address', $settings['village_address']) }}</textarea>
                @error('village_address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Information Box -->
        <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Informasi Penting</h3>
                    <div class="mt-1 text-sm text-blue-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Email kepala desa akan menerima semua pesan dari form kontak website</li>
                            <li>Pastikan email yang dimasukkan adalah email aktif yang sering dicek</li>
                            <li>Informasi desa akan ditampilkan di bagian kontak dan footer website</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-between items-center">
            <div class="flex space-x-4">
                <div>
                    <a href="{{ route('admin.settings.test-email') }}" 
                       class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Test Email
                    </a>
                    <p class="text-xs text-gray-500 mt-1">Test kirim email dengan konfigurasi saat ini</p>
                </div>
                <div>
                    <button type="button" onclick="clearSMTPFields()" 
                            class="inline-flex items-center bg-gray-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-600 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Reset SMTP
                    </button>
                    <p class="text-xs text-gray-500 mt-1">Kosongkan semua field SMTP (gunakan log)</p>
                </div>
            </div>
            <button type="submit" 
                    class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function clearSMTPFields() {
    if (confirm('Yakin ingin mengosongkan semua konfigurasi SMTP? Email akan menggunakan log driver.')) {
        document.getElementById('smtp_host').value = '';
        document.getElementById('smtp_port').value = '';
        document.getElementById('smtp_username').value = '';
        document.getElementById('smtp_password').value = '';
        document.getElementById('smtp_encryption').value = 'tls';
        document.getElementById('mail_from_name').value = '';
        
        // Show success message
        alert('Field SMTP telah dikosongkan. Jangan lupa klik "Simpan Pengaturan" untuk menyimpan perubahan.');
    }
}
</script>
@endpush