# 🚀 Production Deployment - Quick Fix Guide

Panduan cepat untuk fix issue deployment dan test Biteship production mode.

---

## ✅ Fix JavaScript Error

**Error:**
```
Uncaught ReferenceError: showBiteshipForm is not defined
```

**Cause:** Script tidak ter-load karena `@push('scripts')` tidak work di layout

**Fix:** ✅ Sudah diperbaiki! Script sekarang inline.

**Action di Server Production:**

```bash
# 1. Pull latest code
git pull origin salman-2

# 2. Clear all cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# 3. Restart services (if needed)
sudo service php8.1-fpm restart
sudo service nginx reload
```

---

## 🔐 Update API Key ke Production

**File `.env` di production:**

```env
# Biteship Production Mode
BITESHIP_API_KEY=biteship_live.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoic2lkZXNhIiwidXNlcklkIjoiNjkwZjhmNTg0MzcyNDI4M2Y0MGY5NmI5IiwiaWF0IjoxNzYyNjczMTMyfQ.1k_RJXHd89Ho6nyCVQZqQ1ehsBLa-ui3FArCTSx0v6w
BITESHIP_BASE_URL=https://api.biteship.com/v1
BITESHIP_ENVIRONMENT=production
```

**⚠️ IMPORTANT:**
- Production key: `biteship_live.xxx` (bukan `biteship_test.xxx`)
- Environment: `production` (bukan `development`)

---

## 🧪 Testing Production Biteship

### Step 1: Verify Configuration

```bash
# SSH ke server production
ssh user@your-server.com

# Test config
php artisan tinker
>>> config('biteship.api_key')
# Should return: biteship_live.eyJhbGc...

>>> config('biteship.environment')
# Should return: production

>>> exit
```

### Step 2: Create Test Order

```
1. Checkout produk dengan alamat REAL
   - Gunakan alamat rumah Anda sendiri (untuk test)
   - Pilih lokasi via Nominatim
   - Pilih kurir (JNE/J&T/dll)

2. Bayar via Midtrans
   - Production: Real payment
   - Sandbox: Test card 4811 1111 1111 1114

3. Order jadi status 'paid'
```

### Step 3: Create Biteship Shipment (AUTO)

```
1. Login admin village
2. Go to Orders → Klik order yang paid
3. Klik "Proses Pengiriman"
4. Pilih "Biteship Auto" ✅
5. Review informasi:
   - Origin: Desa coordinates
   - Destination: Customer address
   - Courier: Sesuai pilihan customer
   - Items: Product details
6. ✅ Centang checkbox konfirmasi
7. Klik "Buat Shipment via Biteship"
```

**Expected Result:**
```
✅ Success message: "Shipment berhasil dibuat via Biteship! Nomor resi: JNE00XXXXX"
✅ Resi number auto-generated
✅ Order status → 'shipped'
```

### Step 4: Verify di Biteship Dashboard

```
1. Login https://app.biteship.com
2. Navigate to Orders
3. ✅ Lihat order yang baru dibuat
4. ✅ Check status & tracking
5. ✅ Check saldo terpotong
```

### Step 5: Monitor Auto-Update

```
# Wait 2 hours, atau run manual:
php artisan tracking:update

# Check log:
tail -f storage/logs/tracking-updates.log

# Expected:
🚀 Starting automatic tracking update...
📦 Found 1 order(s) to update.
Processing Order #ORDER-20250109-XXX...
  ✅ Status updated: on_process → in_transit
```

---

## 🐛 Troubleshooting

### Issue 1: JavaScript Error Masih Muncul

**Fix:**
```bash
# Clear browser cache
Ctrl + Shift + R (hard refresh)

# Clear Laravel cache
php artisan view:clear
php artisan cache:clear
```

### Issue 2: Biteship API Error "Unauthorized"

**Check:**
```bash
php artisan tinker
>>> config('biteship.api_key')
# Pastikan: biteship_live.xxx (bukan biteship_test)
```

**Fix:**
```bash
# Edit .env
nano .env
# Update API_KEY

# Clear cache
php artisan config:clear && php artisan config:cache
```

### Issue 3: Create Shipment Failed "Insufficient Balance"

**Check:**
- Login https://app.biteship.com
- Check saldo di dashboard
- Minimum: Rp 50,000

**Fix:**
- Top up saldo Biteship
- Atau gunakan mode "Manual Input Resi" untuk testing

### Issue 4: Coordinates Invalid

**Error:** "Invalid origin/destination coordinates"

**Fix:**
```
1. Login admin village
2. Go to Pengaturan Lokasi Pengiriman
3. Verify coordinates:
   - Latitude: Valid (-90 to 90)
   - Longitude: Valid (-180 to 180)
4. Use "Auto-isi Koordinat" button
5. Save
```

---

## 📊 Production vs Testing Comparison

| Aspect | Testing Mode | Production Mode |
|--------|-------------|-----------------|
| **API Key** | `biteship_test.xxx` | `biteship_live.xxx` |
| **Environment** | `development` | `production` |
| **Resi Generation** | Manual (fake) | Auto (real dari kurir) |
| **Tracking Update** | ❌ Tidak work | ✅ Auto-update |
| **Cost** | Free (no shipment) | Ada biaya per shipment |
| **Saldo** | Tidak perlu | Perlu top up |

---

## ✅ Production Checklist

Sebelum test production:

- [ ] API key production di `.env`
- [ ] Environment = `production`
- [ ] Clear all cache di server
- [ ] Village coordinates sudah set
- [ ] Biteship saldo >= Rp 50,000
- [ ] Test dengan alamat real (bisa rumah sendiri)
- [ ] Cron job sudah setup untuk auto-update
- [ ] Monitor log: `tail -f storage/logs/laravel.log`

---

## 🎯 Quick Commands

```bash
# Clear cache
php artisan config:clear && php artisan cache:clear && php artisan view:clear

# Test config
php artisan tinker
>>> config('biteship.api_key')
>>> config('biteship.environment')

# Manual tracking update
php artisan tracking:update

# Check log
tail -f storage/logs/laravel.log
tail -f storage/logs/tracking-updates.log

# Restart services
sudo service php8.1-fpm restart
sudo service nginx reload
```

---

## 💡 Tips Production

1. **Test dengan Item Murah:**
   - Dokumen kecil
   - Same city (cheaper)
   - Kirim ke rumah sendiri

2. **Monitor Saldo:**
   - Check Biteship dashboard regular
   - Set alert jika saldo < Rp 100,000

3. **Backup Resi:**
   - Screenshot resi number
   - Save di note untuk reference

4. **Customer Communication:**
   - Inform customer: "Tracking auto-update tiap 2 jam"
   - Give realistic delivery estimate

---

**Ready untuk production testing! 🚀**

Sekarang button "Biteship Auto" sudah bisa diklik!
