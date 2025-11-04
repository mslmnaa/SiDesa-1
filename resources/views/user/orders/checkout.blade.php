@extends('layouts.app')

@section('title', 'Checkout - BUMDes Marketplace')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Checkout</h1>
            <p class="text-gray-600 mt-2 text-sm sm:text-base">Review pesanan Anda dan selesaikan pembayaran</p>
        </div>

        <!-- Warning if any village hasn't set shipping origin -->
        @if($villagesOrigin->where('has_origin', false)->count() > 0)
            <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Ongkos Kirim Belum Tersedia</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>Beberapa desa penjual belum mengatur lokasi pengiriman. Ongkos kirim tidak dapat dihitung untuk produk dari desa:</p>
                            <ul class="list-disc list-inside mt-1">
                                @foreach($villagesOrigin->where('has_origin', false) as $village)
                                    <li>{{ $village['village_name'] }}</li>
                                @endforeach
                            </ul>
                            <p class="mt-2">Silakan hubungi penjual atau pilih produk dari desa lain.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('user.orders.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                <!-- Order Items -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Produk yang Dipesan -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="px-6 py-4 border-b bg-green-50">
                            <h2 class="text-lg font-semibold text-gray-900">Produk yang Dipesan</h2>
                        </div>

                        <div class="divide-y divide-gray-200">
                            @foreach($cartItems as $item)
                                <div class="p-4 sm:p-6">
                                    <div class="flex items-start space-x-4">
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0">
                                            @if($item->product->images && count($item->product->images) > 0)
                                                <img src="{{ $item->product->getImageDataUri(0) }}"
                                                     alt="{{ $item->product->name }}"
                                                     class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded-lg">
                                            @else
                                                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Product Info -->
                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-semibold text-gray-900 mb-1 text-sm sm:text-base">
                                                {{ $item->product->name }}
                                            </h3>
                                            <p class="text-xs sm:text-sm text-gray-500 mb-1">
                                                {{ $item->product->category->name }}
                                            </p>
                                            <p class="text-xs sm:text-sm text-gray-500 mb-2">
                                                <span class="inline-flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    {{ $item->product->village->name }}
                                                </span>
                                            </p>
                                            <div class="flex items-center gap-4 text-sm">
                                                <span class="text-gray-600">{{ $item->quantity }}x</span>
                                                <span class="font-bold text-green-600">
                                                    Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Subtotal -->
                                        <div class="text-right">
                                            <p class="text-sm text-gray-500 mb-1">Subtotal</p>
                                            <p class="font-bold text-gray-900">
                                                Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Alamat Pengiriman -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Alamat Pengiriman</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nama Penerima -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Penerima *</label>
                                <input type="text" name="recipient_name" required value="{{ old('recipient_name', auth()->user()->name) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                @error('recipient_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nomor Telepon -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon *</label>
                                <input type="text" name="phone" required value="{{ old('phone', auth()->user()->phone) }}"
                                       placeholder="08xxxxxxxxxx"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kode Pos -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kode Pos *</label>
                                <input type="text" name="postal_code" id="postal_code" required value="{{ old('postal_code') }}"
                                       placeholder="12345"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                @error('postal_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Provinsi -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Provinsi *</label>
                                <select name="province_id" id="province_id" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                    <option value="">Pilih Provinsi</option>
                                </select>
                                <input type="hidden" name="province_name" id="province_name">
                                @error('province_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kota/Kabupaten -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kota/Kabupaten *</label>
                                <select name="city_id" id="city_id" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                    <option value="">Pilih Kota</option>
                                </select>
                                <input type="hidden" name="city_name" id="city_name">
                                @error('city_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kecamatan -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kecamatan</label>
                                <input type="text" name="district" value="{{ old('district') }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                            </div>

                            <!-- Alamat Lengkap -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap *</label>
                                <textarea name="full_address" rows="3" required
                                          placeholder="Nama jalan, nomor rumah, RT/RW, dll..."
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">{{ old('full_address') }}</textarea>
                                @error('full_address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Pilihan Kurir & Ongkir -->
                    <div class="bg-white rounded-lg shadow-lg p-6" id="shipping-options-section" style="display:none;">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Pilih Kurir & Layanan</h2>
                        <div id="shipping-loading" class="text-center py-4">
                            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-green-600"></div>
                            <p class="text-sm text-gray-600 mt-2">Menghitung ongkir...</p>
                        </div>
                        <div id="shipping-options" class="space-y-3"></div>
                        <input type="hidden" name="shipping_service" id="shipping_service" required>
                        <input type="hidden" name="shipping_cost" id="shipping_cost" value="0">
                        <input type="hidden" name="shipping_etd" id="shipping_etd">
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Metode Pembayaran</h2>

                        <div class="space-y-3">
                            <div class="p-4 border-2 border-green-500 rounded-lg bg-green-50">
                                <input type="hidden" name="payment_method" value="midtrans">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 mt-1">
                                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900 mb-1">Pembayaran Online - Midtrans</h3>
                                        <p class="text-sm text-gray-600 mb-3">Bayar dengan berbagai metode pembayaran yang aman dan terpercaya</p>

                                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                            <div class="flex items-center gap-2 text-xs bg-white px-3 py-2 rounded border border-gray-200">
                                                <span>💳</span>
                                                <span class="font-medium">Credit Card</span>
                                            </div>
                                            <div class="flex items-center gap-2 text-xs bg-white px-3 py-2 rounded border border-gray-200">
                                                <span>🏦</span>
                                                <span class="font-medium">Virtual Account</span>
                                            </div>
                                            <div class="flex items-center gap-2 text-xs bg-white px-3 py-2 rounded border border-gray-200">
                                                <span>📱</span>
                                                <span class="font-medium">GoPay</span>
                                            </div>
                                            <div class="flex items-center gap-2 text-xs bg-white px-3 py-2 rounded border border-gray-200">
                                                <span>🛒</span>
                                                <span class="font-medium">ShopeePay</span>
                                            </div>
                                            <div class="flex items-center gap-2 text-xs bg-white px-3 py-2 rounded border border-gray-200">
                                                <span>📲</span>
                                                <span class="font-medium">QRIS</span>
                                            </div>
                                            <div class="flex items-center gap-2 text-xs bg-white px-3 py-2 rounded border border-gray-200">
                                                <span>🏪</span>
                                                <span class="font-medium">Indomaret</span>
                                            </div>
                                        </div>

                                        <div class="mt-3 flex items-center gap-2 text-xs text-green-700">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Pembayaran dijamin aman oleh Midtrans</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('payment_method')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Catatan -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Catatan (Opsional)</h2>
                        <textarea name="customer_notes" rows="4"
                                  placeholder="Tambahkan catatan untuk penjual..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('customer_notes') }}</textarea>
                        @error('customer_notes')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-lg p-6 lg:sticky lg:top-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h2>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Item</span>
                                <span class="font-semibold">{{ $cartItems->sum('quantity') }} produk</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal Produk</span>
                                <span class="font-semibold" id="subtotal-display">
                                    Rp {{ number_format($cartItems->sum(function($item) { return $item->quantity * $item->product->price; }), 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Ongkos Kirim</span>
                                <span class="font-semibold text-blue-600" id="shipping-cost-display">Rp 0</span>
                            </div>
                            <hr>
                            <div class="flex justify-between text-lg font-bold">
                                <span class="text-gray-900">Total Pembayaran</span>
                                <span class="text-green-600" id="total-display">
                                    Rp {{ number_format($cartItems->sum(function($item) { return $item->quantity * $item->product->price; }), 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <button type="submit" id="submit-order-btn" disabled
                                class="w-full py-3 px-4 rounded-lg font-semibold transition-colors flex items-center justify-center gap-2 bg-gray-300 text-gray-500 cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <span id="submit-btn-text">Lengkapi Data Terlebih Dahulu</span>
                        </button>

                        <!-- Validation Status -->
                        <div id="validation-status" class="mt-4 space-y-2 text-sm">
                            <div id="status-address" class="flex items-center gap-2 text-red-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <span>Alamat pengiriman belum lengkap</span>
                            </div>
                            <div id="status-shipping" class="flex items-center gap-2 text-red-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <span>Kurir & layanan belum dipilih</span>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="mt-6 p-4 bg-green-50 rounded-lg">
                            <h3 class="font-semibold text-green-900 mb-2 text-sm">📋 Cara Pembayaran:</h3>
                            <ul class="text-xs text-green-800 space-y-1">
                                <li>• Klik tombol "Lanjut ke Pembayaran"</li>
                                <li>• Pilih metode pembayaran yang Anda inginkan</li>
                                <li>• Selesaikan pembayaran sesuai instruksi</li>
                                <li>• Order otomatis diproses setelah pembayaran berhasil</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Data produk dan villages untuk perhitungan ongkir
const subtotalProduct = {{ $cartItems->sum(function($item) { return $item->quantity * $item->product->price; }) }};
const villagesOrigin = @json($villagesOrigin);

let selectedShippingCost = 0;

// Load provinces on page load
document.addEventListener('DOMContentLoaded', function() {
    loadProvinces();
});

// Load provinces
async function loadProvinces() {
    try {
        const response = await fetch('/api/rajaongkir/provinces');
        const data = await response.json();

        if (data.success) {
            const select = document.getElementById('province_id');
            select.innerHTML = '<option value="">Pilih Provinsi</option>';

            data.data.forEach(province => {
                const option = document.createElement('option');
                option.value = province.province_id;
                option.textContent = province.province;
                option.dataset.name = province.province;
                select.appendChild(option);
            });
        }
    } catch (error) {
        console.error('Error loading provinces:', error);
        alert('Gagal memuat data provinsi');
    }
}

// When province changes, load cities
document.getElementById('province_id').addEventListener('change', function() {
    const provinceId = this.value;
    const provinceName = this.options[this.selectedIndex]?.dataset.name || '';
    document.getElementById('province_name').value = provinceName;

    // Hide shipping options when province changes
    document.getElementById('shipping-options-section').style.display = 'none';
    document.getElementById('shipping-options').innerHTML = '';
    selectedShippingCost = 0;
    updateTotal();

    if (provinceId) {
        loadCities(provinceId);
    } else {
        const citySelect = document.getElementById('city_id');
        citySelect.innerHTML = '<option value="">Pilih Kota</option>';
        document.getElementById('city_name').value = '';
    }
});

// Load cities
async function loadCities(provinceId) {
    try {
        const response = await fetch(`/api/rajaongkir/cities?province_id=${provinceId}`);
        const data = await response.json();

        if (data.success) {
            const select = document.getElementById('city_id');
            select.innerHTML = '<option value="">Pilih Kota</option>';

            data.data.forEach(city => {
                const option = document.createElement('option');
                option.value = city.city_id;
                option.textContent = `${city.type} ${city.city_name}`;
                option.dataset.name = `${city.type} ${city.city_name}`;
                option.dataset.postalCode = city.postal_code || '';
                select.appendChild(option);
            });
        }
    } catch (error) {
        console.error('Error loading cities:', error);
        alert('Gagal memuat data kota');
    }
}

// When city changes, auto-fill postal code and calculate shipping
document.getElementById('city_id').addEventListener('change', async function() {
    const cityId = this.value;
    const cityName = this.options[this.selectedIndex]?.dataset.name || '';
    const postalCode = this.options[this.selectedIndex]?.dataset.postalCode || '';

    document.getElementById('city_name').value = cityName;

    // Auto-fill postal code if available
    const postalCodeInput = document.getElementById('postal_code');
    if (postalCode && !postalCodeInput.value) {
        postalCodeInput.value = postalCode;
    }

    if (cityId) {
        await calculateAllShipping(cityId);
    } else {
        document.getElementById('shipping-options-section').style.display = 'none';
        selectedShippingCost = 0;
        updateTotal();
    }
});

// Calculate shipping for all villages
async function calculateAllShipping(destinationCityId) {
    const shippingSection = document.getElementById('shipping-options-section');
    const shippingLoading = document.getElementById('shipping-loading');
    const shippingOptions = document.getElementById('shipping-options');

    shippingSection.style.display = 'block';
    shippingLoading.style.display = 'block';
    shippingOptions.innerHTML = '';

    let allShippingServices = [];

    try {
        // Calculate shipping for each village
        for (const village of villagesOrigin) {
            if (!village.origin_city_id) {
                continue; // Skip villages without origin city
            }

            const response = await fetch('/api/rajaongkir/calculate-cost', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    origin: village.origin_city_id,
                    destination: destinationCityId,
                    weight: village.total_weight,
                    couriers: ['jne', 'pos', 'tiki']
                })
            });

            const data = await response.json();

            if (data.success && data.data.length > 0) {
                // Add village info to each service
                data.data.forEach(service => {
                    service.village_name = village.village_name;
                    service.village_id = village.village_id;
                    allShippingServices.push(service);
                });
            }
        }

        shippingLoading.style.display = 'none';

        if (allShippingServices.length > 0) {
            displayShippingOptions(allShippingServices);
        } else {
            shippingOptions.innerHTML = '<p class="text-sm text-red-600">Tidak ada layanan pengiriman tersedia atau desa penjual belum setting lokasi pengiriman.</p>';
        }
    } catch (error) {
        console.error('Error calculating shipping:', error);
        shippingLoading.style.display = 'none';
        shippingOptions.innerHTML = '<p class="text-sm text-red-600">Gagal menghitung ongkir. Silakan coba lagi.</p>';
    }
}

// Display shipping options
function displayShippingOptions(services) {
    const container = document.getElementById('shipping-options');
    container.innerHTML = '';

    // Group by village
    const groupedByVillage = services.reduce((acc, service) => {
        if (!acc[service.village_id]) {
            acc[service.village_id] = {
                village_name: service.village_name,
                services: []
            };
        }
        acc[service.village_id].services.push(service);
        return acc;
    }, {});

    // Display services grouped by village
    Object.values(groupedByVillage).forEach(village => {
        const villageDiv = document.createElement('div');
        villageDiv.className = 'mb-4';
        villageDiv.innerHTML = `<h3 class="text-sm font-semibold text-gray-900 mb-2">📍 ${village.village_name}</h3>`;

        village.services.forEach(service => {
            const serviceDiv = document.createElement('label');
            serviceDiv.className = 'flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors mb-2';
            serviceDiv.innerHTML = `
                <input type="radio" name="shipping_option" value="${service.cost}"
                       data-service="${service.courier} - ${service.service}"
                       data-etd="${service.etd}"
                       class="w-4 h-4 text-green-600"
                       onchange="selectShipping(${service.cost}, '${service.courier} - ${service.service}', '${service.etd}')">
                <div class="ml-3 flex-1">
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-900">${service.display_name}</span>
                        <span class="font-bold text-green-600">${service.display_cost}</span>
                    </div>
                    <p class="text-xs text-gray-500">Estimasi: ${service.display_etd}</p>
                </div>
            `;
            villageDiv.appendChild(serviceDiv);
        });

        container.appendChild(villageDiv);
    });
}

// Select shipping
function selectShipping(cost, service, etd) {
    selectedShippingCost = cost;
    document.getElementById('shipping_cost').value = cost;
    document.getElementById('shipping_service').value = service;
    document.getElementById('shipping_etd').value = etd;
    updateTotal();

    // Validate form after shipping selection
    validateForm();
}

// Update total display
function updateTotal() {
    const total = subtotalProduct + selectedShippingCost;
    document.getElementById('shipping-cost-display').textContent = 'Rp ' + selectedShippingCost.toLocaleString('id-ID');
    document.getElementById('total-display').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

// Validation state
let validationState = {
    address: false,
    shipping: false
};

// Validate form and update button state
function validateForm() {
    // Check address fields
    const recipientName = document.querySelector('input[name="recipient_name"]').value.trim();
    const phone = document.querySelector('input[name="phone"]').value.trim();
    const provinceId = document.getElementById('province_id').value;
    const cityId = document.getElementById('city_id').value;
    const postalCode = document.querySelector('input[name="postal_code"]').value.trim();
    const fullAddress = document.querySelector('textarea[name="full_address"]').value.trim();

    validationState.address = recipientName && phone && provinceId && cityId && postalCode && fullAddress;

    // Check shipping service
    const shippingService = document.getElementById('shipping_service').value;
    validationState.shipping = shippingService && shippingService.trim() !== '';

    // Update status indicators
    updateStatusIndicator('status-address', validationState.address, 'Alamat pengiriman sudah lengkap', 'Alamat pengiriman belum lengkap');
    updateStatusIndicator('status-shipping', validationState.shipping, 'Kurir & layanan sudah dipilih', 'Kurir & layanan belum dipilih');

    // Update submit button
    const submitBtn = document.getElementById('submit-order-btn');
    const submitBtnText = document.getElementById('submit-btn-text');
    const allValid = validationState.address && validationState.shipping;

    if (allValid) {
        submitBtn.disabled = false;
        submitBtn.className = 'w-full py-3 px-4 rounded-lg font-semibold transition-colors flex items-center justify-center gap-2 bg-green-600 text-white hover:bg-green-700';
        submitBtn.querySelector('svg').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>';
        submitBtnText.textContent = 'Lanjut ke Pembayaran';
    } else {
        submitBtn.disabled = true;
        submitBtn.className = 'w-full py-3 px-4 rounded-lg font-semibold transition-colors flex items-center justify-center gap-2 bg-gray-300 text-gray-500 cursor-not-allowed';
        submitBtn.querySelector('svg').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>';
        submitBtnText.textContent = 'Lengkapi Data Terlebih Dahulu';
    }
}

// Update status indicator
function updateStatusIndicator(elementId, isValid, validText, invalidText) {
    const element = document.getElementById(elementId);
    if (isValid) {
        element.className = 'flex items-center gap-2 text-green-600';
        element.querySelector('svg').innerHTML = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>';
        element.querySelector('span').textContent = validText;
    } else {
        element.className = 'flex items-center gap-2 text-red-600';
        element.querySelector('svg').innerHTML = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>';
        element.querySelector('span').textContent = invalidText;
    }
}

// Setup event listeners for real-time validation
function setupValidationListeners() {
    // Address fields
    const addressFields = [
        'input[name="recipient_name"]',
        'input[name="phone"]',
        'input[name="postal_code"]',
        'textarea[name="full_address"]'
    ];

    addressFields.forEach(selector => {
        const element = document.querySelector(selector);
        if (element) {
            element.addEventListener('input', validateForm);
            element.addEventListener('blur', validateForm);
        }
    });

    // Province and City
    document.getElementById('province_id').addEventListener('change', validateForm);
    document.getElementById('city_id').addEventListener('change', validateForm);

    // Initial validation
    validateForm();
}

// Initialize validation on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setupValidationListeners);
} else {
    setupValidationListeners();
}
</script>
@endsection
