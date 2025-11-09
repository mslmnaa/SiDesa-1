# 🚀 Production Testing Guide - Biteship Integration

Panduan lengkap untuk testing sistem pengiriman Biteship di production dengan shipment REAL.

---

## ⚠️ PENTING - Baca Ini Dulu!

### Testing vs Production:

| Aspect | Testing Mode | Production Mode |
|--------|--------------|-----------------|
| **Resi Number** | Manual input (palsu) | Real dari Biteship/Kurir |
| **Tracking Update** | ❌ Tidak update (resi palsu) | ✅ Update otomatis real-time |
| **Biaya** | ✅ Gratis | ❌ Potong saldo Biteship |
| **Status Auto-Update** | ❌ Tidak work | ✅ Work via cron job |
| **Customer Experience** | Link ke kurir (mungkin 404) | ✅ Tracking real work |

### Jawaban Pertanyaan Anda:

**Q: "Bagaimana cek di production apakah sistem pengiriman berhasil?"**

**A:** Ada 2 cara:

1. **Testing Mode (Manual Resi):**
   - Input resi palsu seperti `TEST123`
   - Cek flow order: checkout → bayar → admin input resi → shipped
   - ❌ Tracking **TIDAK** update otomatis (normal, karena resi palsu)
   - ✅ Flow order berjalan dengan baik
   - ✅ UI/UX bisa dicek
   - **Use case:** Testing flow tanpa biaya

2. **Production Mode (Real Shipment):**
   - Buat shipment real via Biteship
   - Dapat resi real dari kurir (JNE00XXXXX)
   - ✅ Tracking update otomatis dari Biteship
   - ✅ Customer bisa track real
   - ✅ Status auto-update setiap 2 jam
   - **Use case:** Testing full system dengan shipment nyata

---

## 🎯 Production Testing Scenarios

### Scenario 1: Testing Flow (No Real Shipment)

**Goal:** Verify sistem berjalan tanpa biaya

**Steps:**

1. **Checkout & Payment**
   ```
   1. User checkout produk
   2. Pilih lokasi tujuan
   3. Pilih kurir JNE REG
   4. Bayar via Midtrans (bisa pakai test card jika sandbox)
   5. ✅ Order status = 'processing', payment = 'paid'
   ```

2. **Manual Input Resi**
   ```
   1. Login admin village
   2. Buka order yang paid
   3. Pilih "Input Resi Manual"
   4. Courier: jne
   5. Resi: TEST-JNE-20250109-001 (palsu)
   6. Submit
   7. ✅ Order status = 'shipped'
   ```

3. **User View Tracking**
   ```
   1. Login user
   2. My Orders → Klik order
   3. ✅ Lihat resi number
   4. ✅ Lihat link "Lacak di JNE"
   5. ⚠️ Link mungkin 404 (normal, resi palsu)
   ```

**Result:**
- ✅ Flow order berjalan
- ✅ UI/UX berfungsi
- ❌ Tracking tidak real (expected)
- ✅ **No cost**

**Good For:**
- Demo/presentation
- UI testing
- Flow validation
- Development testing

---

### Scenario 2: Production Test (Real Shipment)

**Goal:** Test full system dengan tracking real

**⚠️ Warning:** Ini akan potong saldo Biteship!

**Prerequisites:**
1. Biteship saldo >= Rp 50,000
2. Alamat origin & destination real
3. Koordinat valid
4. Cron job sudah setup

**Steps:**

#### Phase 1: Setup

```bash
# 1. Verify .env production
BITESHIP_API_KEY=biteship_live.xxx  # Production key
BITESHIP_ENVIRONMENT=production

# 2. Verify cron job
crontab -l
# Should have: * * * * * cd /path && php artisan schedule:run

# 3. Test command manual
php artisan tracking:update
```

#### Phase 2: Create Real Order

```
1. User checkout produk dengan:
   - Alamat tujuan REAL (misal: rumah Anda sendiri)
   - Coordinates valid dari Nominatim
   - Pilih kurir tersedia (JNE, J&T, dll)

2. Bayar dengan Midtrans:
   - Production: Real payment
   - Sandbox: Test card

3. ✅ Order jadi status 'paid'
```

#### Phase 3: Create Biteship Shipment

```
1. Login admin village
2. Buka order yang paid
3. Pilih "Biteship Auto" (bukan manual!)
4. Review info:
   - Origin: Desa coordinates (verify correct)
   - Destination: Customer address (verify correct)
   - Courier: Sesuai pilihan customer
   - Items: Product details

5. ✅ Centang checkbox konfirmasi
6. Submit "Buat Shipment via Biteship"

7. Expected Result:
   ✅ Success message dengan resi real
   ✅ Resi format: JNE00123456 (contoh)
   ✅ Order status → 'shipped'
   ✅ shipping_tracking_number saved
   ✅ shipping_resi saved
```

#### Phase 4: Verify Biteship Dashboard

```
1. Login ke https://app.biteship.com
2. Navigate to Orders
3. ✅ Lihat order yang baru dibuat
4. ✅ Check status: confirmed/allocated
5. ✅ Check courier details
6. ✅ Check waybill number
```

#### Phase 5: Tracking Auto-Update

```
Wait 2 hours (scheduler interval)

Check hasil:
1. Database:
   SELECT shipping_status, tracking_updated_at
   FROM orders WHERE order_number = 'XXX';

   ✅ shipping_status updated
   ✅ tracking_updated_at adalah 2 jam yang lalu

2. Log file:
   tail -f storage/logs/tracking-updates.log

   Expected:
   ✅ Status updated: on_process → in_transit

3. User view:
   - Login user
   - My Orders → Order detail
   - ✅ Status terbaru muncul
   - ✅ Tracking history tampil
```

#### Phase 6: Delivery Test

```
Option A: Wait for real delivery (1-3 hari)
   ✅ Saat barang delivered
   ✅ Cron job auto-detect
   ✅ Order status → 'completed'
   ✅ delivered_at timestamp set

Option B: Manual test with real resi
   1. Copy resi number real
   2. Track di website kurir
   3. Verify status sama dengan di Biteship
```

**Result:**
- ✅ Shipment created real
- ✅ Resi number valid
- ✅ Tracking auto-update work
- ✅ Status sync dengan kurir
- ✅ Order auto-complete saat delivered
- ❌ **Cost:** Saldo Biteship terpotong

---

## 📊 Verification Checklist

### ✅ Checkout & Rates
- [ ] User bisa search lokasi (Nominatim)
- [ ] Lokasi auto-fill form
- [ ] Biteship rates loaded
- [ ] Multiple courier options tampil
- [ ] Bisa pilih courier & service
- [ ] Total amount correct

### ✅ Payment
- [ ] Midtrans redirect work
- [ ] Payment success update order
- [ ] payment_status = 'paid'
- [ ] status = 'processing'

### ✅ Shipping - Manual Mode
- [ ] Admin bisa input resi manual
- [ ] Order status → 'shipped'
- [ ] shipped_at timestamp set
- [ ] User bisa lihat tracking page

### ✅ Shipping - Biteship Auto (Production)
- [ ] Can create shipment via Biteship
- [ ] Resi auto-generated
- [ ] shipping_tracking_number saved
- [ ] Tampil di Biteship dashboard
- [ ] Saldo Biteship terpotong

### ✅ Auto-Update Tracking
- [ ] Cron job setup di server
- [ ] Command berjalan setiap 2 jam
- [ ] Log file ter-create
- [ ] Status update otomatis
- [ ] shipping_history update
- [ ] tracking_updated_at update

### ✅ Order Completion
- [ ] Saat delivered, status → 'completed'
- [ ] delivered_at set otomatis
- [ ] completed_at set otomatis
- [ ] Customer dapat notifikasi (if implemented)

---

## 🧪 Quick Test Commands

### Test 1: Verify Configuration
```bash
php artisan tinker
>>> config('biteship.api_key')
>>> config('biteship.environment')
>>> exit
```

### Test 2: Manual Tracking Update
```bash
# Update all shipped orders
php artisan tracking:update

# Update specific order
php artisan tracking:update --order_id=123
```

### Test 3: Check Scheduler
```bash
# List scheduled tasks
php artisan schedule:list

# Run scheduler once
php artisan schedule:run

# Check log
tail -f storage/logs/tracking-updates.log
```

### Test 4: Database Verification
```sql
-- Check orders with tracking
SELECT
    id,
    order_number,
    shipping_courier,
    shipping_resi,
    shipping_status,
    status,
    tracking_updated_at
FROM orders
WHERE status = 'shipped'
ORDER BY created_at DESC;

-- Check delivered orders
SELECT
    order_number,
    delivered_at,
    completed_at
FROM orders
WHERE shipping_status = 'delivered';
```

---

## 📈 Monitoring Production

### Daily Checks:

1. **Tracking Update Log**
   ```bash
   # Check last 50 updates
   tail -n 50 storage/logs/tracking-updates.log

   # Check today's updates
   grep "$(date +%Y-%m-%d)" storage/logs/tracking-updates.log
   ```

2. **Database Stats**
   ```sql
   -- Orders by shipping status
   SELECT shipping_status, COUNT(*) as count
   FROM orders
   WHERE status = 'shipped'
   GROUP BY shipping_status;

   -- Today's deliveries
   SELECT COUNT(*) as delivered_today
   FROM orders
   WHERE DATE(delivered_at) = CURDATE();
   ```

3. **Biteship Dashboard**
   - Login https://app.biteship.com
   - Check order list
   - Verify tracking status
   - Check saldo remaining

### Weekly Checks:

1. **Cron Job Health**
   ```bash
   # Check crontab
   crontab -l

   # Check last run
   ls -lh storage/logs/tracking-updates.log
   ```

2. **Error Rate**
   ```bash
   # Count errors in log
   grep -c "Failed" storage/logs/tracking-updates.log

   # Show error details
   grep "Failed" storage/logs/tracking-updates.log
   ```

---

## 🐛 Common Issues in Production

### Issue 1: Status tidak update otomatis

**Check:**
```bash
# 1. Cron job running?
crontab -l
ps aux | grep "schedule:run"

# 2. Command work manual?
php artisan tracking:update

# 3. Log ada error?
tail -f storage/logs/laravel.log
```

**Fix:**
- Setup cron job jika belum
- Check API key valid
- Verify resi number real (bukan testing)

### Issue 2: Biteship create shipment gagal

**Error:** "Insufficient balance"

**Fix:**
- Top up saldo Biteship
- Minimum Rp 50,000

**Error:** "Invalid coordinates"

**Fix:**
- Check village coordinates valid
- Verify destination coordinates dari Nominatim

### Issue 3: Tracking "Resi not found"

**Cause:**
- Resi baru (< 1 jam)
- Resi belum terdaftar di kurir

**Fix:**
- Wait 1-2 jam setelah shipment created
- Verify resi di website kurir manual

---

## 💰 Cost Estimation

### Biteship Pricing (Estimate):

| Courier | Service | Jakarta-Bandung | Estimasi |
|---------|---------|-----------------|----------|
| JNE | REG | 1kg | Rp 10,000 - 15,000 |
| JNE | YES | 1kg | Rp 18,000 - 25,000 |
| J&T | REG | 1kg | Rp 8,000 - 12,000 |
| SiCepat | REG | 1kg | Rp 9,000 - 13,000 |

**Note:** Harga aktual bisa berbeda, check di Biteship rates API.

### Testing Budget:

**Recommended:**
- Top up Rp 100,000 untuk 5-10 test shipments
- Test dengan jarak dekat (same city) = cheaper
- Test dengan weight kecil (< 1kg) = cheaper

---

## 🎯 Success Criteria

### Testing Mode Success:
- ✅ Checkout flow complete
- ✅ Payment work
- ✅ Manual resi input work
- ✅ Order status change correct
- ✅ UI/UX berfungsi baik

### Production Mode Success:
- ✅ Biteship shipment created
- ✅ Real resi generated
- ✅ Tracking auto-update work
- ✅ Status sync dengan kurir
- ✅ Order auto-complete when delivered
- ✅ Customer satisfied dengan tracking

---

## 📝 Testing Checklist

### Pre-Production:
- [ ] Test semua flow di staging/local
- [ ] Verify .env production correct
- [ ] Setup cron job
- [ ] Top up Biteship saldo
- [ ] Test tracking command manual

### Production Testing:
- [ ] Create 1 test order dengan alamat real
- [ ] Use Biteship create shipment
- [ ] Verify resi di Biteship dashboard
- [ ] Wait 2 hours, check auto-update
- [ ] Verify tracking page untuk customer
- [ ] Monitor logs untuk error

### Post-Testing:
- [ ] Document hasil testing
- [ ] Note any issues found
- [ ] Fix issues before launch
- [ ] Train admin cara pakai sistem
- [ ] Prepare customer guide

---

## 📚 Resources

- **Biteship Dashboard:** https://app.biteship.com
- **Biteship Docs:** https://biteship.com/docs
- **Biteship API Status:** https://status.biteship.com
- **Midtrans Dashboard:** https://dashboard.midtrans.com

---

**Ready untuk production! 🚀**

**Remember:**
- Testing mode (manual resi) = Free, tracking tidak update
- Production mode (Biteship auto) = Ada biaya, tracking real-time

Pilih sesuai kebutuhan!
