# 🚚 Alur Sistem Pengiriman Biteship

Dokumentasi lengkap alur pengiriman menggunakan Biteship API di SiDesa Marketplace.

---

## 📊 Flow Diagram

```
┌─────────────────────────────────────────────────────────────────────┐
│                         CHECKOUT PROCESS                            │
└─────────────────────────────────────────────────────────────────────┘
                                    │
                                    ▼
                    User pilih produk dari keranjang
                                    │
                                    ▼
                    User isi alamat pengiriman (dengan Nominatim)
                                    │
                                    ▼
        ┌───────────────────────────────────────────────────┐
        │  BITESHIP: Get Shipping Rates                     │
        │  POST /api/biteship/rates                         │
        │  - Origin: Village coordinates                    │
        │  - Destination: User location (lat/long)          │
        │  - Items: Products dengan weight, value           │
        └───────────────────────────────────────────────────┘
                                    │
                                    ▼
                    User pilih kurir & layanan
                    (JNE REG, JNE YES, JNT, dll)
                                    │
                                    ▼
                    User pilih metode pembayaran
                                    │
                                    ▼
        ┌───────────────────────────────────────────────────┐
        │  MIDTRANS: Process Payment                        │
        │  Status: pending → paid                           │
        └───────────────────────────────────────────────────┘
                                    │
                                    ▼
┌─────────────────────────────────────────────────────────────────────┐
│                      SHIPPING PROCESS                               │
└─────────────────────────────────────────────────────────────────────┘

        STATUS: pending_payment → paid → processing
                                    │
                                    ▼
        ┌───────────────────────────────────────────────────┐
        │  ADMIN VILLAGE: Input Resi Number                 │
        │  Route: /admin/shipping/{order}/create            │
        │  - Input courier code (jne, jnt, dll)             │
        │  - Input resi/waybill number                      │
        └───────────────────────────────────────────────────┘
                                    │
                                    ▼
        ┌───────────────────────────────────────────────────┐
        │  BITESHIP: Track Shipment (Optional)              │
        │  GET /api/biteship/tracking/{waybill_id}          │
        │  - Get status dari Biteship                       │
        │  - Update shipping_status order                   │
        └───────────────────────────────────────────────────┘
                                    │
                                    ▼
                    STATUS: shipped → in_transit
                                    │
                                    ▼
        ┌───────────────────────────────────────────────────┐
        │  USER: Track Order                                │
        │  Route: /orders/{order}/tracking                  │
        │  - Lihat resi number                              │
        │  - Lihat shipping history                         │
        │  - Link ke website kurir untuk tracking           │
        └───────────────────────────────────────────────────┘
                                    │
                                    ▼
                    STATUS: delivered → completed
```

---

## 🔄 Status Flow

### Payment Status
```
pending → paid → failed
```

### Order Status
```
pending → processing → shipped → completed
                            └─→ cancelled
```

### Shipping Status (Biteship)
```
pending → on_process → in_transit → delivered
                                  └→ failed
```

**Mapping Biteship Status:**
- `confirmed`, `allocated`, `picking_up` → **on_process**
- `picked`, `dropping_off` → **in_transit**
- `delivered` → **delivered**
- `cancelled`, `rejected`, `returned` → **failed**

---

## 🎯 Implementation Status

### ✅ SUDAH TERIMPLEMENTASI

#### 1. **Checkout - Get Shipping Rates**
- ✅ File: `resources/views/user/orders/checkout.blade.php`
- ✅ API: `POST /api/biteship/rates`
- ✅ Service: `BiteshipService::getShippingRates()`
- ✅ Features:
  - Search lokasi dengan Nominatim (OpenStreetMap)
  - Get coordinates (latitude/longitude)
  - Get rates dari Biteship berdasarkan koordinat
  - Display multiple couriers & services
  - Calculate total payment

#### 2. **Order Creation**
- ✅ File: `app/Http/Controllers/User/Order/OrderController.php`
- ✅ Menyimpan data:
  - `shipping_cost` - Biaya kirim
  - `shipping_service` - Kode service (jne-reg, jnt-ez, dll)
  - `shipping_etd` - Estimasi waktu tiba
  - Alamat lengkap dengan coordinates

#### 3. **Payment Integration**
- ✅ Midtrans Snap integration
- ✅ Webhook untuk update payment status
- ✅ Auto update order status setelah pembayaran

#### 4. **Database Structure**
- ✅ Table: `orders`
  - `shipping_courier` - Kode kurir (jne, jnt, dll)
  - `shipping_resi` - Nomor resi
  - `shipping_status` - Status pengiriman
  - `shipping_tracking_number` - Tracking ID dari Biteship
  - `shipping_history` - JSON history tracking
  - `shipped_at` - Waktu pengiriman
  - `delivered_at` - Waktu diterima

- ✅ Table: `villages`
  - `latitude` - Koordinat latitude desa
  - `longitude` - Koordinat longitude desa
  - `origin_postal_code` - Kode pos

- ✅ Table: `shipping_addresses`
  - `latitude` - Koordinat tujuan
  - `longitude` - Koordinat tujuan
  - `postal_code` - Kode pos

---

## ⚠️ BELUM TERIMPLEMENTASI (UNTUK MODE TESTING)

### Mode 1: MANUAL TRACKING (Saat ini)
**Status:** ✅ Sudah ada di `ShippingController`

Alur:
1. Admin village input resi number manual
2. Sistem track menggunakan BinderbyteService (API pihak ketiga)
3. User bisa lihat tracking di website kurir

**Cocok untuk:**
- Testing/sandbox mode
- Budget terbatas
- Volume order kecil

### Mode 2: BITESHIP CREATE ORDER (Belum diimplementasi)
**Status:** ⚠️ Perlu diimplementasi

Alur yang seharusnya:
1. Setelah payment **paid**, admin village bisa:
   - **Option A:** Create shipment via Biteship API
   - **Option B:** Input resi manual (seperti sekarang)

2. Jika pakai Biteship Create Order:
```php
// Contoh implementasi
$result = $this->biteshipService->createOrder([
    'shipper_name' => $village->name,
    'shipper_phone' => $village->phone,
    'shipper_email' => $village->email ?? 'noreply@sidesa.com',
    'shipper_organization' => 'SiDesa',

    'origin_name' => $village->name,
    'origin_phone' => $village->phone,
    'origin_address' => $village->origin_address,
    'origin_postal_code' => $village->origin_postal_code,
    'origin_latitude' => $village->latitude,
    'origin_longitude' => $village->longitude,

    'destination_name' => $order->shippingAddress->recipient_name,
    'destination_phone' => $order->shippingAddress->phone,
    'destination_email' => $order->user->email,
    'destination_address' => $order->shippingAddress->full_address,
    'destination_postal_code' => $order->shippingAddress->postal_code,
    'destination_latitude' => $order->shippingAddress->latitude,
    'destination_longitude' => $order->shippingAddress->longitude,

    'courier_company' => $order->shipping_courier, // jne, jnt, dll
    'courier_type' => $order->shipping_service, // REG, YES, dll
    'delivery_type' => 'now',

    'items' => $order->items->map(function($item) {
        return [
            'name' => $item->product_name,
            'description' => $item->product_name,
            'value' => $item->price,
            'length' => $item->product->length ?? 10,
            'width' => $item->product->width ?? 10,
            'height' => $item->product->height ?? 10,
            'weight' => $item->product->weight,
            'quantity' => $item->quantity,
        ];
    })->toArray(),

    'reference_id' => $order->order_number,
]);

if ($result['success']) {
    // Save tracking info
    $order->update([
        'shipping_tracking_number' => $result['data']['id'],
        'shipping_resi' => $result['data']['courier']['waybill_id'],
        'shipping_status' => 'on_process',
        'status' => 'shipped',
        'shipped_at' => now(),
    ]);
}
```

**Keuntungan Biteship Create Order:**
- ✅ Otomatis dapat resi number dari kurir
- ✅ Tracking terintegrasi langsung
- ✅ Update status real-time dari Biteship
- ✅ Bisa print label pengiriman
- ✅ Bisa request pickup dari kurir

**Kekurangan:**
- ❌ Perlu biaya per shipment creation
- ❌ Sandbox mode terbatas
- ❌ Tidak semua kurir support di semua area

---

## 🧪 UNTUK TESTING/SANDBOX

### Opsi 1: Manual Input Resi (Current Implementation)
**File:** `app/Http/Controllers/Admin/ShippingController.php`

**Flow:**
1. Order dibayar via Midtrans (bisa pakai test card)
2. Admin village login
3. Ke halaman order detail
4. Klik "Input Resi"
5. Pilih kurir (jne, jnt, dll)
6. Input nomor resi manual (bisa resi palsu untuk testing)
7. Sistem update status → shipped

**Tracking:**
- Saat ini pakai BinderbyteService
- Perlu ganti ke Biteship tracking untuk konsistensi

### Opsi 2: Biteship Create Order (Perlu Implementasi)
**Catatan:** Biteship sandbox/development mode ada limitasi:
- Terbatas create order per hari
- Tidak semua kurir tersedia
- Biaya tetap ada (walaupun dev mode)

**Rekomendasi untuk testing:**
- Pakai **Manual Input** dulu
- Tambahkan fitur "Test Mode" checkbox
- Jika test mode aktif:
  - Skip Biteship create order
  - Generate resi palsu
  - Mock tracking response

---

## 📝 Checklist Implementasi Lengkap

### ✅ Phase 1: Checkout & Payment (DONE)
- [x] Nominatim geocoding untuk search lokasi
- [x] Biteship get shipping rates
- [x] Display courier options
- [x] Midtrans payment integration
- [x] Save shipping data ke order

### ⚠️ Phase 2: Shipping Management (PARTIAL)
- [x] Admin dashboard untuk manage orders
- [x] Manual resi input
- [ ] **TODO:** Biteship create order integration
- [ ] **TODO:** Switch tracking dari Binderbyte ke Biteship
- [ ] **TODO:** Auto-update tracking dengan cron job

### 📋 Phase 3: Tracking (PARTIAL)
- [x] User view tracking page
- [x] Show resi number
- [x] Link ke website kurir
- [ ] **TODO:** Real-time update dari Biteship webhook
- [ ] **TODO:** Email/notif saat status berubah

---

## 🔧 File-File Penting

### Backend
1. **Service Layer**
   - `app/Services/BiteshipService.php` - Main Biteship API service
   - `app/Services/BinderbyteService.php` - Tracking service (perlu diganti)

2. **Controllers**
   - `app/Http/Controllers/Api/BiteshipController.php` - API endpoints
   - `app/Http/Controllers/Admin/ShippingController.php` - Admin shipping management
   - `app/Http/Controllers/User/Order/OrderController.php` - User checkout

3. **Models**
   - `app/Models/Order.php` - Order model
   - `app/Models/Village.php` - Village dengan coordinates
   - `app/Models/ShippingAddress.php` - Alamat pengiriman

### Frontend
1. **Views**
   - `resources/views/user/orders/checkout.blade.php` - Checkout page
   - `resources/views/user/orders/tracking.blade.php` - Tracking page
   - `resources/views/admin/shipping/create.blade.php` - Input resi
   - `resources/views/admin/orders/show.blade.php` - Order detail

### Config & Routes
- `config/biteship.php` - Biteship configuration
- `routes/web.php` - API routes

---

## 💡 Rekomendasi

### Untuk Development/Testing:
1. ✅ **Gunakan mode manual input resi** (sudah ada)
2. ⚠️ **Update tracking ke Biteship** (ganti dari Binderbyte)
3. 📝 **Tambahkan test mode checkbox** untuk skip Biteship create order

### Untuk Production:
1. 🚀 **Implementasi Biteship create order** untuk auto resi
2. 📧 **Email notification** saat status berubah
3. 🔄 **Cron job** untuk auto-update tracking tiap 1-2 jam
4. 🎫 **Print shipping label** dari Biteship

---

## 🎬 Testing Flow

### Test Checkout:
1. Login sebagai user
2. Add produk ke cart (dari village yang sudah set coordinates)
3. Checkout
4. Isi alamat dengan search lokasi (coba "Jakarta" atau kota lain)
5. Pilih kurir dan layanan
6. Bayar dengan Midtrans test card: `4811 1111 1111 1114`
7. Order status → paid

### Test Shipping (Manual):
1. Login sebagai admin village
2. Buka order yang sudah paid
3. Klik "Input Resi"
4. Pilih courier: jne
5. Input resi: TESTJNE123456 (bebas)
6. Submit
7. Order status → shipped

### Test Tracking:
1. Login sebagai user (pembeli)
2. Buka "My Orders"
3. Klik order yang sudah shipped
4. Lihat tracking info
5. Klik link "Lacak di website JNE" (akan redirect ke JNE.co.id)

---

## 🚨 Important Notes

### Biteship Environment
```env
BITESHIP_ENVIRONMENT=development  # atau production
```

- **Development:** Testing, limited features, may have costs
- **Production:** Full features, production rates

### API Key
- Development key: `biteship_test.xxx`
- Production key: `biteship_live.xxx`

### Coordinates Requirement
⚠️ **WAJIB:** Setiap village harus set coordinates di shipping settings!

Path: Admin → Pengaturan Lokasi Pengiriman
- Isi province, city, postal code
- Klik "Auto-isi Koordinat" atau input manual
- Save

Tanpa coordinates → checkout akan error!

---

## 📞 Support

- Biteship Docs: https://biteship.com/docs
- Biteship Dashboard: https://app.biteship.com
- Email support: support@biteship.com
