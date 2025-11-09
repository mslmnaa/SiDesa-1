# 🧪 Biteship Integration Testing Guide

Panduan lengkap untuk testing integrasi Biteship di SiDesa Marketplace.

---

## 📋 Prerequisites

### 1. Environment Setup
Pastikan `.env` sudah dikonfigurasi:

```env
BITESHIP_API_KEY=biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...
BITESHIP_BASE_URL=https://api.biteship.com/v1
BITESHIP_ENVIRONMENT=development

MIDTRANS_SERVER_KEY=your_midtrans_server_key
MIDTRANS_CLIENT_KEY=your_midtrans_client_key
MIDTRANS_IS_PRODUCTION=false
```

### 2. Database
Jalankan migration:
```bash
php artisan migrate
```

### 3. Village Coordinates
**WAJIB:** Setiap desa harus punya koordinat!

Login sebagai admin village → Pengaturan Lokasi Pengiriman:
- Pilih Province & City
- Isi Postal Code
- Klik "Auto-isi Koordinat" atau input manual latitude/longitude
- Save

---

## 🎯 Testing Flow Lengkap

### Phase 1: Checkout & Get Shipping Rates ✅

#### Test Case 1.1: Search Lokasi
1. Login sebagai user
2. Add produk ke cart (dari desa yang sudah set coordinates)
3. Go to checkout
4. Di "Alamat Pengiriman", search lokasi:
   - Coba: "Jakarta", "Bandung", "Surabaya"
   - Coba: "Jalan Sudirman", "Mall Taman Anggrek"
5. **Expected:** Muncul list lokasi dari Nominatim
6. Pilih salah satu lokasi
7. **Expected:** Form address auto terisi

#### Test Case 1.2: Get Shipping Rates
1. Setelah pilih lokasi, tunggu loading
2. **Expected:** Muncul pilihan kurir & layanan
3. **Verify:** Console log shows:
   ```
   Biteship Request for village: BUMDes Maju Jaya
   Biteship Response for village: BUMDes Maju Jaya {success: true, data: [...]}
   Total rates collected: 3 (atau lebih)
   ```
4. **Check:** Rates ditampilkan dengan:
   - Nama kurir (JNE, J&T, dll)
   - Nama service (REG, YES, OKE, dll)
   - Harga
   - Estimasi waktu

#### Test Case 1.3: Pilih Kurir & Checkout
1. Pilih salah satu kurir (misal: JNE REG)
2. **Expected:** Total amount update (subtotal + ongkir)
3. Pilih metode pembayaran: Midtrans
4. Klik "Bayar Sekarang"
5. **Expected:** Redirect ke Midtrans payment page

---

### Phase 2: Payment ✅

#### Test Case 2.1: Midtrans Payment (Sandbox)
1. Di halaman Midtrans, pilih "Credit Card"
2. Gunakan test card: `4811 1111 1111 1114`
   - CVV: `123`
   - Exp: Any future date (e.g., `12/25`)
3. Klik "Pay"
4. **Expected:** Payment success
5. **Expected:** Redirect ke order confirmation page
6. **Verify Database:**
   ```sql
   SELECT order_number, payment_status, status, shipping_service, shipping_cost
   FROM orders
   WHERE order_number = 'ORDER-XXXXX';
   ```
   - `payment_status` = 'paid'
   - `status` = 'processing'
   - `shipping_service` = 'jne-reg' (atau yang dipilih)
   - `shipping_cost` = nilai ongkir

---

### Phase 3: Shipping Management

#### Test Case 3.1: Manual Input Resi (RECOMMENDED FOR TESTING)

**Kenapa manual?**
- ✅ Gratis, no cost
- ✅ Bisa pakai resi palsu untuk testing
- ✅ Tidak perlu saldo Biteship
- ✅ Perfect untuk development/testing

**Steps:**
1. Login sebagai admin village
2. Navigate: Admin Dashboard → Orders
3. Find order yang status = 'processing' dan payment_status = 'paid'
4. Klik order number untuk detail
5. Klik "Input Nomor Resi" atau "Proses Pengiriman"
6. Pilih metode: **"Input Resi Manual"** (default)
7. Pilih courier: `jne`
8. Input resi number: `TESTJNE123456789` (bebas, untuk testing)
9. Klik "Simpan & Kirim Order"
10. **Expected:**
    - Success message: "Nomor resi berhasil ditambahkan"
    - Order status → 'shipped'
    - Shipping status → 'on_process'
    - shipped_at = current timestamp
11. **Verify Database:**
    ```sql
    SELECT shipping_courier, shipping_resi, shipping_status, status, shipped_at
    FROM orders
    WHERE order_number = 'ORDER-XXXXX';
    ```

**Expected Result:**
```
shipping_courier: jne
shipping_resi: TESTJNE123456789
shipping_status: on_process
status: shipped
shipped_at: 2025-01-09 10:30:00
```

#### Test Case 3.2: Biteship Create Shipment (OPTIONAL - PRODUCTION)

**⚠️ Warning:**
- Perlu saldo Biteship
- Akan membuat shipment real
- Biaya akan dipotong
- Hanya untuk production/demo

**Steps:**
1. Login sebagai admin village
2. Find order yang belum shipped (status = 'processing', payment = 'paid')
3. Klik "Input Nomor Resi"
4. Pilih metode: **"Biteship Auto"**
5. Review informasi:
   - Kurir & layanan (dari checkout customer)
   - Biaya shipment
   - Data origin & destination
6. Centang checkbox konfirmasi
7. Klik "Buat Shipment via Biteship"
8. **Expected:**
    - Success message: "Shipment berhasil dibuat via Biteship! Nomor resi: XXX"
    - Resi number otomatis dari Biteship
    - Order status → 'shipped'
9. **Verify Database:**
    ```sql
    SELECT shipping_tracking_number, shipping_resi, shipping_courier
    FROM orders
    WHERE order_number = 'ORDER-XXXXX';
    ```

**Expected Result:**
```
shipping_tracking_number: biteship_order_id (dari Biteship)
shipping_resi: JNE00XXXXXXXXX (waybill dari kurir)
shipping_courier: jne
```

---

### Phase 4: Tracking

#### Test Case 4.1: User View Tracking
1. Login sebagai user (pembeli)
2. Navigate: My Account → My Orders
3. Klik order yang sudah shipped
4. **Expected:** Tampil:
   - Order details
   - Shipping information
   - Resi number
   - Courier name
   - Link "Lacak di website [kurir]"
5. Klik link tracking
6. **Expected:** Redirect ke website kurir (JNE.co.id, J&T.co.id, dll)

#### Test Case 4.2: Biteship Tracking API
**Note:** Hanya work jika:
- Shipment dibuat via Biteship, ATAU
- Resi number valid & ada di sistem Biteship

**Steps:**
1. Login sebagai admin
2. Buka order detail yang sudah shipped
3. Klik "Update Tracking"
4. **Expected (jika resi valid):**
   - Tracking data updated
   - Shipping history updated
   - Status updated (on_process / in_transit / delivered)

**Expected (jika resi testing/palsu):**
- Error: "Gagal update tracking: Resi tidak ditemukan"
- Ini normal untuk testing dengan resi palsu

---

## 📊 Test Scenarios

### Scenario 1: Happy Path - Manual Resi (RECOMMENDED)
```
User checkout → Pilih kurir JNE REG
    ↓
Bayar via Midtrans (test card)
    ↓
Admin input resi manual: TESTJNE123
    ↓
Order status → shipped
    ↓
User lihat tracking (link ke JNE.co.id)
    ↓
✅ SUCCESS
```

### Scenario 2: Production Path - Biteship Auto
```
User checkout → Pilih kurir JNE REG
    ↓
Bayar via Midtrans (real payment in production)
    ↓
Admin create shipment via Biteship
    ↓
Biteship create order ke JNE
    ↓
Dapat resi otomatis: JNE00XXXXX
    ↓
Order status → shipped
    ↓
User tracking via Biteship API (real-time)
    ↓
✅ SUCCESS
```

---

## 🐛 Common Issues & Solutions

### Issue 1: "Lokasi tidak ditemukan"
**Cause:** Nominatim API issue or network problem

**Solution:**
- Check internet connection
- Try different search term (use city name, not detailed address)
- Wait a moment and retry

### Issue 2: "Tidak ada layanan pengiriman tersedia"
**Cause:**
- Village coordinates not set
- Biteship API error

**Solution:**
- Verify village has latitude/longitude set
- Check console logs for Biteship API response
- Verify `BITESHIP_API_KEY` in `.env`

### Issue 3: "Gagal membuat shipment"
**Cause:**
- Insufficient Biteship balance
- Invalid coordinates
- Courier not available in area

**Solution:**
- Top up Biteship balance
- Verify coordinates are correct
- Use "Manual Input" for testing instead

### Issue 4: "Tracking tidak update"
**Cause:**
- Using fake/test resi number
- Resi not yet registered in courier system

**Solution:**
- Normal behavior for test resi
- For real shipment, wait 1-2 hours after shipment created
- Use Biteship create shipment for real-time tracking

---

## ✅ Testing Checklist

### Pre-Testing
- [ ] `.env` configured with Biteship & Midtrans keys
- [ ] Database migrated
- [ ] Village coordinates set
- [ ] Test user account created
- [ ] Products available in catalog

### Checkout Flow
- [ ] Search location works (Nominatim)
- [ ] Location auto-fills form
- [ ] Shipping rates loaded from Biteship
- [ ] Multiple courier options displayed
- [ ] Can select courier and service
- [ ] Total amount calculated correctly
- [ ] Shipping service saved in order (e.g., 'jne-reg')

### Payment Flow
- [ ] Redirect to Midtrans works
- [ ] Test card payment succeeds
- [ ] Webhook updates order status
- [ ] Payment status = 'paid'
- [ ] Order status = 'processing'

### Shipping - Manual Input
- [ ] Admin can access shipping form
- [ ] Can input courier and resi manually
- [ ] Order status → 'shipped'
- [ ] Shipping status → 'on_process'
- [ ] shipped_at timestamp saved

### Shipping - Biteship Auto (Optional)
- [ ] Can switch to Biteship mode
- [ ] Shows correct courier from checkout
- [ ] Confirmation checkbox works
- [ ] Shipment created successfully
- [ ] Resi number auto-generated
- [ ] Tracking ID saved

### Tracking
- [ ] User can view tracking page
- [ ] Resi number displayed
- [ ] Link to courier website works
- [ ] Shipping history shown (if available)
- [ ] Status badge shows correct color

---

## 📝 Test Data Examples

### Test Card Midtrans
```
Card Number: 4811 1111 1111 1114
CVV: 123
Exp Date: 12/25
```

### Test Locations
```
- Jakarta Pusat
- Bandung
- Surabaya
- Jalan Sudirman Jakarta
- Mall Taman Anggrek
```

### Test Resi Numbers (for manual testing)
```
TESTJNE123456789
TESTJNT987654321
TESTSICEPAT111222
```

---

## 🎯 Success Criteria

✅ **Checkout:** User can search location, get shipping rates, and checkout
✅ **Payment:** Midtrans payment works and updates order
✅ **Shipping:** Admin can input resi (manual or Biteship auto)
✅ **Tracking:** User can see tracking info
✅ **Database:** All shipping data saved correctly

---

## 🚀 Production Checklist

Before going to production:

- [ ] Change `BITESHIP_ENVIRONMENT=production`
- [ ] Use production API key: `biteship_live.xxx`
- [ ] Change `MIDTRANS_IS_PRODUCTION=true`
- [ ] Top up Biteship balance (if using auto shipment)
- [ ] Test with real addresses
- [ ] Set up cron job for tracking updates
- [ ] Configure email notifications
- [ ] Add error monitoring (Sentry, etc)

---

## 📞 Support

### Biteship
- Dashboard: https://app.biteship.com
- Docs: https://biteship.com/docs
- Support: support@biteship.com

### Midtrans
- Dashboard: https://dashboard.midtrans.com
- Docs: https://docs.midtrans.com
- Support: support@midtrans.com

---

## 📚 Related Documentation

- `BITESHIP_INTEGRATION.md` - Detailed API integration guide
- `BITESHIP_SHIPPING_FLOW.md` - Complete shipping flow documentation
- `MIDTRANS_TESTING.md` - Midtrans payment testing guide

---

**Happy Testing! 🎉**
