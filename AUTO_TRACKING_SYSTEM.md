# 🔄 Auto-Update Tracking System

Sistem otomatis untuk update status pengiriman dari Biteship API tanpa perlu manual klik button.

---

## 🎯 Masalah Yang Diselesaikan

### ❌ Sebelumnya (Manual):
- Admin harus klik button "Update Tracking" manual
- Status tidak update otomatis
- Customer tidak tahu status terkini
- Admin bisa ubah status manual (tidak akurat)

### ✅ Sekarang (Otomatis):
- ✅ Status update otomatis setiap 2 jam
- ✅ Data langsung dari Biteship/Kurir
- ✅ Customer selalu lihat status terkini
- ✅ Admin tidak perlu action apapun
- ✅ Order otomatis jadi "completed" saat delivered

---

## 📊 Cara Kerja

### Flow Otomatis:

```
Setiap 2 jam (via cron job)
    ↓
Laravel Scheduler menjalankan: php artisan tracking:update
    ↓
Command mencari semua order dengan:
    - status = 'shipped'
    - shipping_resi ada
    - shipping_status != 'delivered'
    ↓
Untuk setiap order:
    ↓
Call Biteship API: GET /trackings/{resi}
    ↓
Parse response & update:
    - shipping_status (on_process/in_transit/delivered)
    - shipping_history (array tracking detail)
    - tracking_updated_at (timestamp)
    ↓
Jika status = 'delivered':
    - Set delivered_at = now
    - Set status = 'completed'
    - Set completed_at = now
    ↓
Log hasil ke: storage/logs/tracking-updates.log
```

---

## 🚀 Setup & Deployment

### 1. **Local Development**

Testing command manual:

```bash
# Update semua order yang sedang shipped
php artisan tracking:update

# Update order tertentu saja
php artisan tracking:update --order_id=123
```

Testing scheduler (run sekali):

```bash
php artisan schedule:run
```

Testing scheduler (continuous):

```bash
php artisan schedule:work
```

### 2. **Production Setup**

**WAJIB:** Setup cron job di server!

#### Opsi A: Linux Server (VPS, Dedicated)

Edit crontab:

```bash
crontab -e
```

Tambahkan baris ini:

```cron
* * * * * cd /path/to/your-project && php artisan schedule:run >> /dev/null 2>&1
```

Contoh path real:

```cron
* * * * * cd /var/www/sidesa && php artisan schedule:run >> /dev/null 2>&1
```

**Penjelasan:**
- `* * * * *` = Setiap menit (Laravel scheduler akan handle kapan command dijalankan)
- `cd /path/to/project` = Masuk ke folder project
- `php artisan schedule:run` = Jalankan scheduler
- `>> /dev/null 2>&1` = Buang output (optional)

**Verify cron berjalan:**

```bash
# Lihat crontab yang aktif
crontab -l

# Monitor log
tail -f storage/logs/tracking-updates.log

# Check process
ps aux | grep "schedule:run"
```

#### Opsi B: Shared Hosting (cPanel, Plesk)

1. Login ke cPanel
2. Go to **Cron Jobs**
3. Add new cron job:
   - **Minute:** `*` (every minute)
   - **Hour:** `*`
   - **Day:** `*`
   - **Month:** `*`
   - **Weekday:** `*`
   - **Command:** `/usr/bin/php /home/username/public_html/artisan schedule:run`

4. Save

**Path examples:**
- cPanel: `/home/username/public_html/artisan`
- Plesk: `/var/www/vhosts/domain.com/httpdocs/artisan`

#### Opsi C: Hosting Platform (Heroku, Railway, etc)

**Heroku:**

Create `Procfile`:

```
web: vendor/bin/heroku-php-apache2 public/
worker: php artisan queue:work
cron: php artisan schedule:work
```

Enable worker dyno di dashboard.

**Railway/Render:**

Add to build config:

```yaml
crons:
  - schedule: "* * * * *"
    command: "php artisan schedule:run"
```

### 3. **Verify Setup Berhasil**

Check apakah cron berjalan:

```bash
# Check log file
tail -f storage/logs/tracking-updates.log

# Check Laravel log
tail -f storage/logs/laravel.log

# Manual run untuk test
php artisan tracking:update
```

Expected output:

```
🚀 Starting automatic tracking update...
📦 Found 3 order(s) to update.
Processing Order #ORDER-20250109-001 (Resi: JNE00123456)...
  ✅ Status updated: on_process → in_transit
Processing Order #ORDER-20250109-002 (Resi: JNT789012)...
  ℹ️  Status unchanged: in_transit
Processing Order #ORDER-20250109-003 (Resi: SICEPAT456)...
  🎉 Order DELIVERED!
  ✅ Status updated: in_transit → delivered

✅ Update completed!
   Success: 3
   Failed: 0
```

---

## ⏰ Schedule Configuration

Default: **Setiap 2 jam**

Untuk mengubah frekuensi, edit `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule): void
{
    // Setiap 2 jam (default)
    $schedule->command('tracking:update')->everyTwoHours();

    // Opsi lain:
    // $schedule->command('tracking:update')->hourly();          // Setiap jam
    // $schedule->command('tracking:update')->everyFourHours();  // Setiap 4 jam
    // $schedule->command('tracking:update')->daily();           // Setiap hari
    // $schedule->command('tracking:update')->twiceDaily(9, 21); // 2x sehari (jam 9 & 21)
    // $schedule->command('tracking:update')->cron('0 */3 * * *'); // Custom cron
}
```

**Rekomendasi:**
- **Development:** Manual run (`php artisan tracking:update`)
- **Production - High Volume:** Every 1-2 hours
- **Production - Low Volume:** Every 4 hours or twice daily

---

## 📝 Monitoring & Logging

### Check Logs

```bash
# Tracking update log
tail -f storage/logs/tracking-updates.log

# Laravel general log
tail -f storage/logs/laravel.log

# Last 50 lines
tail -n 50 storage/logs/tracking-updates.log
```

### Log Format

**Success:**
```json
{
  "message": "Tracking updated successfully",
  "context": {
    "order_id": 123,
    "order_number": "ORDER-20250109-001",
    "old_status": "on_process",
    "new_status": "in_transit",
    "status_changed": true
  }
}
```

**Failed:**
```json
{
  "message": "Tracking update failed",
  "context": {
    "order_id": 123,
    "order_number": "ORDER-20250109-001",
    "resi": "JNE00123456",
    "error": "Resi not found"
  }
}
```

### Database Check

```sql
-- Check last tracking update time
SELECT
    order_number,
    shipping_resi,
    shipping_status,
    tracking_updated_at
FROM orders
WHERE status = 'shipped'
ORDER BY tracking_updated_at DESC;

-- Check delivered orders
SELECT
    order_number,
    shipping_status,
    delivered_at,
    status
FROM orders
WHERE shipping_status = 'delivered'
ORDER BY delivered_at DESC;
```

---

## 🧪 Testing

### Test Command Manual

```bash
# 1. Buat order dummy dengan resi palsu
# 2. Set status = 'shipped', shipping_resi = 'TEST123'

# 3. Run command
php artisan tracking:update

# Expected: Error "Resi not found" (normal untuk resi palsu)
```

### Test Dengan Resi Real (Production)

```bash
# 1. Buat order via Biteship create shipment
# 2. Dapat resi real dari kurir (misal: JNE00123456)
# 3. Wait 1-2 hours untuk resi terdaftar di sistem kurir
# 4. Run command
php artisan tracking:update

# Expected: Status update success
```

### Test Scheduler

```bash
# Run scheduler once
php artisan schedule:run

# Check output
cat storage/logs/tracking-updates.log
```

---

## 🔧 Troubleshooting

### Issue 1: Command tidak jalan otomatis

**Cause:** Cron job tidak di-setup

**Fix:**
1. Check crontab: `crontab -l`
2. Pastikan ada entry untuk `schedule:run`
3. Check path ke artisan benar
4. Test manual: `php artisan schedule:run`

### Issue 2: Log "No orders to update"

**Cause:** Tidak ada order dengan status shipped

**Fix:**
- Normal jika memang belum ada order shipped
- Check database: `SELECT * FROM orders WHERE status = 'shipped'`

### Issue 3: Error "Resi not found"

**Cause:**
- Resi testing/palsu (tidak real)
- Resi belum terdaftar di sistem kurir (terlalu baru)

**Fix:**
- Normal untuk resi testing
- Untuk resi real, tunggu 1-2 jam setelah shipment created
- Verify resi di website kurir manual

### Issue 4: Status tidak update

**Cause:**
- Biteship API error
- API key invalid
- Resi tidak valid

**Fix:**
1. Check log: `tail -f storage/logs/laravel.log`
2. Test API manual: `php artisan tracking:update --order_id=123`
3. Verify API key di `.env`

---

## 🎯 Production Checklist

Sebelum production, pastikan:

- [ ] Cron job sudah di-setup di server
- [ ] Test cron berjalan: `crontab -l`
- [ ] Test command manual: `php artisan tracking:update`
- [ ] Check log file created: `storage/logs/tracking-updates.log`
- [ ] Monitor log setelah 2 jam pertama
- [ ] Verify status update di database
- [ ] Test dengan order real (bukan testing resi)

---

## 📊 Status Mapping

Biteship → SiDesa:

| Biteship Status | SiDesa shipping_status | Order status | Keterangan |
|----------------|----------------------|--------------|------------|
| `confirmed` | `on_process` | `shipped` | Kurir terima order |
| `allocated` | `on_process` | `shipped` | Driver dialokasikan |
| `picking_up` | `on_process` | `shipped` | Sedang pickup |
| `picked` | `in_transit` | `shipped` | Barang sudah dipickup |
| `dropping_off` | `in_transit` | `shipped` | Dalam perjalanan |
| `delivered` | `delivered` | **`completed`** | ✅ Terkirim |
| `cancelled` | `failed` | `shipped` | Dibatalkan |
| `rejected` | `failed` | `shipped` | Ditolak |
| `returned` | `failed` | `shipped` | Dikembalikan |

**Auto-Complete:**
- Ketika `shipping_status` = `delivered`
- Order `status` otomatis jadi `completed`
- `delivered_at` dan `completed_at` di-set otomatis

---

## 💡 Best Practices

### 1. Frequency
- **Don't:** Update setiap menit (waste API calls)
- **Do:** Update setiap 1-4 jam (balance antara freshness & cost)

### 2. Error Handling
- **Don't:** Stop command jika 1 order error
- **Do:** Continue ke order berikutnya, log error

### 3. Monitoring
- **Don't:** Ignore logs
- **Do:** Monitor `tracking-updates.log` secara berkala

### 4. Testing
- **Don't:** Test di production tanpa backup
- **Do:** Test di staging/local dulu dengan resi real

---

## 🚨 Important Notes

### Untuk Testing (Development):
- ❌ Resi palsu (`TEST123`) **TIDAK** akan update status
- ✅ Ini normal behavior
- ✅ Status tetap `on_process` karena Biteship tidak kenal resi
- ✅ Gunakan manual input untuk testing flow

### Untuk Production:
- ✅ Gunakan Biteship create shipment untuk dapat resi real
- ✅ Resi real akan auto-update statusnya
- ✅ Customer bisa lihat tracking real-time
- ✅ Admin tidak perlu action manual

---

## 📚 Commands Reference

```bash
# Manual update semua order
php artisan tracking:update

# Update order tertentu
php artisan tracking:update --order_id=123

# Test scheduler (run once)
php artisan schedule:run

# Test scheduler (continuous, for development)
php artisan schedule:work

# List all scheduled tasks
php artisan schedule:list

# Clear cache
php artisan config:clear && php artisan cache:clear
```

---

## 📞 Next Steps

1. ✅ Setup cron job di production server
2. ✅ Test dengan order real (gunakan Biteship create shipment)
3. ✅ Monitor log file setelah 2 jam
4. ✅ Verify status update di database
5. ✅ (Optional) Setup email notification saat delivered

---

**Status pengiriman sekarang OTOMATIS update! 🎉**
