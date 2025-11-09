# 📱 Biteship View Implementation Guide

Panduan lengkap untuk mengintegrasikan Biteship ke frontend/view checkout.

## 📋 Overview

Saat ini checkout view masih menggunakan **RajaOngkir** untuk perhitungan ongkir. Biteship API sudah siap di backend, tinggal diimplementasikan ke view.

---

## ✅ Yang Sudah Selesai

### Backend Integration ✅
- ✅ `BiteshipService.php` - Service lengkap
- ✅ `BiteshipController.php` - API Controller
- ✅ API Routes (`/api/biteship/rates`, `/api/biteship/tracking`, dll)
- ✅ Config file (`config/biteship.php`)
- ✅ Migration untuk coordinates (villages & shipping_addresses)
- ✅ Model updates (Village & ShippingAddress fillable)

### Yang Masih Perlu Dikerjakan 🔨
- ❌ Update `checkout.blade.php` untuk gunakan Biteship API
- ❌ JavaScript untuk call Biteship rates
- ❌ Set coordinates di Village settings
- ❌ Save coordinates saat user input address

---

## 🛠️ Step-by-Step Implementation

### Step 1: Run Migration

```bash
php artisan migrate
```

Ini akan menambahkan kolom `latitude` dan `longitude` ke table:
- `villages`
- `shipping_addresses`

### Step 2: Set Village Coordinates di Admin Panel

Untuk setiap village, admin perlu set coordinates:

**Option A: Manual Input**
Edit form di admin village settings, tambahkan field:
- Latitude (contoh: -6.175110)
- Longitude (contoh: 106.865036)

**Option B: Auto-detect via Google Maps API**
Atau gunakan postal code search dari Biteship:

```javascript
// Search postal code untuk get coordinates
fetch('/api/biteship/postal-code/search?q=Jakarta Selatan')
    .then(res => res.json())
    .then(data => {
        if (data.success && data.data.length > 0) {
            const area = data.data[0];
            villageLatitude = area.latitude;
            villageLongitude = area.longitude;
        }
    });
```

### Step 3: Update Checkout View untuk Biteship

#### Option 1: Replace RajaOngkir with Biteship

Edit `resources/views/user/orders/checkout.blade.php`:

**Ubah fungsi `calculateAllShipping()`:**

```javascript
async function calculateAllShipping(destinationPostalCode, destinationLat, destinationLng) {
    const shippingSection = document.getElementById('shipping-options-section');
    const shippingLoading = document.getElementById('shipping-loading');
    const shippingOptions = document.getElementById('shipping-options');

    shippingSection.style.display = 'block';
    shippingLoading.style.display = 'block';
    shippingOptions.innerHTML = '';

    let allShippingServices = [];

    try {
        // Calculate shipping for each village using Biteship
        for (const village of villagesOrigin) {
            if (!village.latitude || !village.longitude) {
                continue; // Skip villages without coordinates
            }

            // Prepare cart items for this village
            const villageItems = cartItems
                .filter(item => item.product.village_id === village.village_id)
                .map(item => ({
                    name: item.product.name,
                    description: item.product.name,
                    value: item.product.price * item.quantity,
                    weight: (item.product.weight || 1000) * item.quantity, // gram
                    length: item.product.length || 10, // cm
                    width: item.product.width || 10,
                    height: item.product.height || 10,
                    quantity: item.quantity
                }));

            const response = await fetch('/api/biteship/rates', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    origin_latitude: village.latitude,
                    origin_longitude: village.longitude,
                    destination_latitude: destinationLat,
                    destination_longitude: destinationLng,
                    destination_postal_code: destinationPostalCode,
                    couriers: 'jne,jnt,sicepat,tiki,anteraja,ninja',
                    items: villageItems
                })
            });

            const data = await response.json();

            if (data.success && data.data.length > 0) {
                // Add village info to each service
                data.data.forEach(service => {
                    service.village_name = village.village_name;
                    service.village_id = village.village_id;
                    service.display_name = `${service.courier_name} - ${service.courier_service_name}`;
                    service.display_cost = `Rp ${service.price.toLocaleString('id-ID')}`;
                    service.display_etd = service.duration || 'Estimasi tidak tersedia';
                    allShippingServices.push(service);
                });
            }
        }

        shippingLoading.style.display = 'none';

        if (allShippingServices.length > 0) {
            displayShippingOptions(allShippingServices);
        } else {
            shippingOptions.innerHTML = '<p class="text-sm text-red-600">Tidak ada layanan pengiriman tersedia. Pastikan desa penjual sudah setting koordinat lokasi.</p>';
        }
    } catch (error) {
        console.error('Error calculating shipping:', error);
        shippingLoading.style.display = 'none';
        shippingOptions.innerHTML = '<p class="text-sm text-red-600">Gagal menghitung ongkir. Silakan coba lagi.</p>';
    }
}
```

**Update fungsi `displayShippingOptions()`:**

```javascript
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
                <input type="radio" name="shipping_option" value="${service.price}"
                       data-service="${service.courier_code} - ${service.courier_service_code}"
                       data-etd="${service.duration || ''}"
                       class="w-4 h-4 text-green-600"
                       onchange="selectShipping(${service.price}, '${service.courier_code} - ${service.courier_service_code}', '${service.duration || ''}')">
                <div class="ml-3 flex-1">
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-900">${service.display_name}</span>
                        <span class="font-bold text-green-600">${service.display_cost}</span>
                    </div>
                    <p class="text-xs text-gray-500">Estimasi: ${service.display_etd}</p>
                    ${service.description ? `<p class="text-xs text-gray-400 mt-1">${service.description}</p>` : ''}
                </div>
            `;
            villageDiv.appendChild(serviceDiv);
        });

        container.appendChild(villageDiv);
    });
}
```

**Update trigger untuk calculate shipping:**

Biteship butuh coordinates, jadi kita perlu auto-detect coordinates dari postal code:

```javascript
// When city changes, get coordinates then calculate shipping
document.getElementById('city_id').addEventListener('change', async function() {
    const cityId = this.value;
    const cityName = this.options[this.selectedIndex]?.dataset.name || '';
    const postalCode = document.getElementById('postal_code').value;

    document.getElementById('city_name').value = cityName;

    if (cityId && postalCode) {
        // Get coordinates from postal code search
        try {
            const coordsResponse = await fetch(`/api/biteship/postal-code/search?q=${cityName}`);
            const coordsData = await coordsResponse.json();

            if (coordsData.success && coordsData.data.length > 0) {
                const area = coordsData.data[0];
                const destinationLat = area.latitude;
                const destinationLng = area.longitude;

                // Save coordinates (optional, for order record)
                window.destinationCoordinates = {
                    latitude: destinationLat,
                    longitude: destinationLng
                };

                // Calculate shipping with coordinates
                await calculateAllShipping(postalCode, destinationLat, destinationLng);
            } else {
                alert('Tidak dapat menemukan koordinat untuk area tersebut. Silakan coba lagi.');
            }
        } catch (error) {
            console.error('Error getting coordinates:', error);
            alert('Gagal mendapatkan koordinat lokasi.');
        }
    }
});
```

#### Option 2: Hybrid (RajaOngkir + Biteship)

Atau bisa buat switch untuk user pilih mau pakai service mana:

```html
<!-- Add shipping service selector -->
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Layanan Cek Ongkir</label>
    <select id="shipping-service-type" class="w-full px-4 py-2 border rounded-lg">
        <option value="rajaongkir">RajaOngkir (City-based)</option>
        <option value="biteship">Biteship (Coordinates-based - Lebih Akurat)</option>
    </select>
</div>
```

---

### Step 4: Update OrderController untuk Save Coordinates

Edit `app/Http/Controllers/User/Order/OrderController.php`:

Pada method `store()`, saat create shipping address, tambahkan coordinates:

```php
// Create shipping address
$shippingAddress = ShippingAddress::create([
    'user_id' => auth()->id(),
    'label' => 'Order Address',
    'recipient_name' => $validated['recipient_name'],
    'phone' => $validated['phone'],
    'province_id' => $validated['province_id'],
    'province_name' => $validated['province_name'],
    'city_id' => $validated['city_id'],
    'city_name' => $validated['city_name'],
    'district' => $validated['district'],
    'postal_code' => $validated['postal_code'],
    'full_address' => $validated['full_address'],
    'is_default' => false,
    'latitude' => $request->input('latitude'), // Add this
    'longitude' => $request->input('longitude'), // Add this
]);
```

Dan tambahkan hidden fields di form checkout:

```html
<input type="hidden" name="latitude" id="destination_latitude">
<input type="hidden" name="longitude" id="destination_longitude">
```

---

## 📱 Complete Biteship Checkout Flow

```
1. User pilih produk → Add to Cart
   ↓
2. User klik Checkout
   ↓
3. User isi alamat pengiriman
   ↓
4. User pilih City/Postal Code
   ↓
5. JavaScript call Biteship Postal Code Search API
   → Get destination coordinates
   ↓
6. JavaScript call Biteship Rates API
   → Send: origin coords (dari village) + destination coords + items
   → Receive: Shipping rates dari berbagai kurir
   ↓
7. Display shipping options
   ↓
8. User pilih kurir & service
   ↓
9. User submit order
   ↓
10. Save order dengan shipping info + coordinates
    ↓
11. Redirect ke payment
```

---

## 🎯 Benefits of Using Biteship

### RajaOngkir (Current)
- ❌ City-based calculation (kurang akurat)
- ❌ Terbatas 3 kurir (JNE, POS, TIKI)
- ❌ Hanya untuk cek ongkir
- ✅ Lebih simple (tidak butuh coordinates)

### Biteship (New)
- ✅ Coordinates-based (LEBIH AKURAT)
- ✅ 15+ kurir tersedia
- ✅ Real-time rates langsung dari kurir
- ✅ Bisa create order langsung ke kurir
- ✅ Live tracking terintegrasi
- ❌ Butuh setup coordinates

---

## 🔧 Quick Setup Checklist

### Backend (DONE ✅)
- [x] Install Guzzle HTTP Client
- [x] Create `config/biteship.php`
- [x] Create `BiteshipService.php`
- [x] Create `BiteshipController.php`
- [x] Add API routes
- [x] Create migration for coordinates
- [x] Update Village & ShippingAddress models
- [x] Update `.env.example`

### Frontend (TODO ⏳)
- [ ] Get Biteship API key from https://biteship.com
- [ ] Update `.env` with API key
- [ ] Run migration: `php artisan migrate`
- [ ] Update village settings form (add lat/lng fields)
- [ ] Set coordinates untuk setiap village
- [ ] Update `checkout.blade.php` dengan Biteship JS
- [ ] Test checkout flow dengan Biteship
- [ ] Verify shipping rates accuracy

---

## 💻 Example JavaScript (Full Implementation)

Berikut contoh lengkap JavaScript untuk `checkout.blade.php` dengan Biteship:

```javascript
<script>
// Configuration
const USE_BITESHIP = true; // Set true untuk gunakan Biteship, false untuk RajaOngkir
const BITESHIP_COURIERS = 'jne,jnt,sicepat,tiki,anteraja,ninja,lion';

// Data
const subtotalProduct = {{ $cartItems->sum(function($item) { return $item->quantity * $item->product->price; }) }};
const villagesOrigin = @json($villagesOrigin);
const cartItemsData = @json($cartItems->map(function($item) {
    return [
        'village_id' => $item->product->village_id,
        'name' => $item->product->name,
        'price' => $item->product->price,
        'weight' => $item->product->weight ?? 1000,
        'quantity' => $item->quantity
    ];
}));

let selectedShippingCost = 0;
let destinationCoordinates = null;

// When city selected
document.getElementById('city_id').addEventListener('change', async function() {
    const cityId = this.value;
    const cityName = this.options[this.selectedIndex]?.dataset.name || '';
    const postalCode = document.getElementById('postal_code').value;

    document.getElementById('city_name').value = cityName;

    if (!cityId || !postalCode) return;

    if (USE_BITESHIP) {
        await calculateShippingBiteship(cityName, postalCode);
    } else {
        await calculateShippingRajaOngkir(cityId);
    }
});

// Calculate shipping using Biteship
async function calculateShippingBiteship(cityName, postalCode) {
    // Step 1: Get destination coordinates
    try {
        const coordsResponse = await fetch(`/api/biteship/postal-code/search?q=${encodeURIComponent(cityName)}`);
        const coordsData = await coordsResponse.json();

        if (!coordsData.success || coordsData.data.length === 0) {
            alert('Lokasi tidak ditemukan. Silakan pilih kota lain.');
            return;
        }

        const area = coordsData.data[0];
        destinationCoordinates = {
            latitude: area.latitude,
            longitude: area.longitude,
            postal_code: area.postal_code || postalCode
        };

        // Save to hidden fields
        document.getElementById('destination_latitude').value = destinationCoordinates.latitude;
        document.getElementById('destination_longitude').value = destinationCoordinates.longitude;

        // Step 2: Get shipping rates
        await fetchBiteshipRates();

    } catch (error) {
        console.error('Error:', error);
        alert('Gagal mendapatkan ongkir. Silakan coba lagi.');
    }
}

// Fetch Biteship rates for all villages
async function fetchBiteshipRates() {
    const shippingSection = document.getElementById('shipping-options-section');
    const shippingLoading = document.getElementById('shipping-loading');
    const shippingOptions = document.getElementById('shipping-options');

    shippingSection.style.display = 'block';
    shippingLoading.style.display = 'block';
    shippingOptions.innerHTML = '';

    let allRates = [];

    for (const village of villagesOrigin) {
        if (!village.latitude || !village.longitude) {
            console.warn(`Village ${village.village_name} doesn't have coordinates`);
            continue;
        }

        // Get items for this village
        const villageItems = cartItemsData
            .filter(item => item.village_id === village.village_id)
            .map(item => ({
                name: item.name,
                description: item.name,
                value: item.price * item.quantity,
                weight: item.weight * item.quantity,
                quantity: item.quantity
            }));

        try {
            const response = await fetch('/api/biteship/rates', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    origin_latitude: village.latitude,
                    origin_longitude: village.longitude,
                    destination_latitude: destinationCoordinates.latitude,
                    destination_longitude: destinationCoordinates.longitude,
                    destination_postal_code: destinationCoordinates.postal_code,
                    couriers: BITESHIP_COURIERS,
                    items: villageItems
                })
            });

            const data = await response.json();

            if (data.success && data.data.length > 0) {
                data.data.forEach(rate => {
                    allRates.push({
                        ...rate,
                        village_id: village.village_id,
                        village_name: village.village_name
                    });
                });
            }
        } catch (error) {
            console.error(`Error fetching rates for ${village.village_name}:`, error);
        }
    }

    shippingLoading.style.display = 'none';

    if (allRates.length > 0) {
        displayBiteshipRates(allRates);
    } else {
        shippingOptions.innerHTML = '<p class="text-sm text-red-600">Tidak ada layanan pengiriman tersedia.</p>';
    }
}

// Display Biteship rates
function displayBiteshipRates(rates) {
    const container = document.getElementById('shipping-options');
    container.innerHTML = '';

    // Group by village
    const grouped = rates.reduce((acc, rate) => {
        if (!acc[rate.village_id]) {
            acc[rate.village_id] = {
                village_name: rate.village_name,
                rates: []
            };
        }
        acc[rate.village_id].rates.push(rate);
        return acc;
    }, {});

    Object.values(grouped).forEach(village => {
        const villageDiv = document.createElement('div');
        villageDiv.className = 'mb-4';
        villageDiv.innerHTML = `<h3 class="text-sm font-semibold text-gray-900 mb-2">📍 ${village.village_name}</h3>`;

        village.rates.forEach(rate => {
            const rateDiv = document.createElement('label');
            rateDiv.className = 'flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors mb-2';

            const serviceCode = `${rate.courier_code}-${rate.courier_service_code}`;

            rateDiv.innerHTML = `
                <input type="radio" name="shipping_option" value="${rate.price}"
                       data-service="${serviceCode}"
                       data-etd="${rate.duration || ''}"
                       class="w-4 h-4 text-green-600"
                       onchange="selectShipping(${rate.price}, '${serviceCode}', '${rate.duration || ''}')">
                <div class="ml-3 flex-1">
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-900">${rate.courier_name} - ${rate.courier_service_name}</span>
                        <span class="font-bold text-green-600">Rp ${rate.price.toLocaleString('id-ID')}</span>
                    </div>
                    <p class="text-xs text-gray-500">Estimasi: ${rate.duration || 'N/A'}</p>
                </div>
            `;
            villageDiv.appendChild(rateDiv);
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
    validateForm();
}

// Update total
function updateTotal() {
    const total = subtotalProduct + selectedShippingCost;
    document.getElementById('shipping-cost-display').textContent = 'Rp ' + selectedShippingCost.toLocaleString('id-ID');
    document.getElementById('total-display').textContent = 'Rp ' + total.toLocaleString('id-ID');
}
</script>
```

---

## 🎓 Summary

**Biteship sudah READY di backend!** ✅

Tinggal:
1. Dapatkan API key dari Biteship
2. Set coordinates di village settings
3. Update `checkout.blade.php` dengan JavaScript di atas
4. Test & enjoy! 🚀

**Read full documentation:** `BITESHIP_INTEGRATION.md`

---

Happy Shipping with Biteship! 📦🚚
