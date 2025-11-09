# 🚀 Deployment Checklist - Biteship Integration

Checklist untuk memastikan Biteship berfungsi dengan baik di server deployment.

---

## ❌ Error yang Anda Alami:

```
401 Unauthorized
"Authorization failed"
```

**Penyebab:** API key Biteship tidak terkonfigurasi atau salah di server deployment.

---

## ✅ Solusi Step-by-Step:

### 1. **Update .env di Server Deployment**

Login ke server deployment dan edit file `.env`:

```bash
# Di server deployment
nano .env
# atau
vim .env
```

Pastikan ada baris ini dengan **API key yang sama persis** seperti di local:

```env
BITESHIP_API_KEY=biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoic2lkZXNhIiwidXNlcklkIjoiNjkwZjhmNTg0MzcyNDI4M2Y0MGY5NmI5IiwiaWF0IjoxNzYyNjI3NzI3fQ.Fqx6vBVgV2S3xjC0q9CbFO6YOLNkoXK0apmhLC1uwTc
BITESHIP_BASE_URL=https://api.biteship.com/v1
BITESHIP_ENVIRONMENT=development
```

**⚠️ PENTING:**
- Jangan ada spasi sebelum/sesudah `=`
- Jangan ada tanda kutip di sekitar value
- API key harus lengkap (sangat panjang)

### 2. **Clear Config Cache di Server**

Setelah update `.env`, jalankan command ini di server:

```bash
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

### 3. **Restart Services (Jika Ada)**

Jika menggunakan:
- **Queue Worker:** `php artisan queue:restart`
- **PHP-FPM:** `sudo service php8.1-fpm restart` (sesuaikan versi PHP)
- **Nginx:** `sudo service nginx reload`
- **Apache:** `sudo service apache2 restart`

### 4. **Verify Configuration**

Test apakah config sudah benar dengan command artisan:

```bash
php artisan tinker
```

Lalu jalankan:
```php
config('biteship.api_key');
// Harus return: biteship_test.eyJhbG...
```

Atau buat route test sementara di `routes/web.php`:

```php
Route::get('/test-biteship-config', function() {
    return [
        'api_key' => config('biteship.api_key'),
        'base_url' => config('biteship.base_url'),
        'environment' => config('biteship.environment'),
        'api_key_length' => strlen(config('biteship.api_key')),
        'is_configured' => !empty(config('biteship.api_key')),
    ];
});
```

Akses: `https://your-domain.com/test-biteship-config`

Expected output:
```json
{
  "api_key": "biteship_test.eyJhbGc...",
  "base_url": "https://api.biteship.com/v1",
  "environment": "development",
  "api_key_length": 187,
  "is_configured": true
}
```

**🗑️ HAPUS route test setelah selesai!**

---

## 🔐 Security Note

**JANGAN** commit file `.env` ke git!

Untuk deployment, ada beberapa cara aman:

### Opsi 1: Manual Copy
- Keep `.env` only on server
- Copy dari `.env.example`
- Set variables manually

### Opsi 2: Environment Variables (Recommended)
Jika menggunakan hosting seperti Heroku, Vercel, Railway:
- Set env variables di dashboard hosting
- Tidak perlu `.env` file

### Opsi 3: Laravel Forge / Envoyer
- Use deployment tool yang support env management

---

## 🧪 Testing di Deployment

Setelah fix configuration:

### Test 1: Config Check
```bash
php artisan tinker
>>> config('biteship.api_key')
```
Should return API key (panjang ~187 karakter)

### Test 2: Service Test
Buat route test:
```php
Route::get('/test-biteship-service', function() {
    $service = new \App\Services\BiteshipService();
    $couriers = $service->getSupportedCouriers();

    return [
        'service_initialized' => true,
        'couriers_count' => count($couriers),
        'sample_couriers' => array_slice($couriers, 0, 3),
    ];
});
```

### Test 3: API Call Test
```php
Route::get('/test-biteship-api', function() {
    $service = new \App\Services\BiteshipService();

    // Test dengan koordinat Jakarta
    $result = $service->getShippingRates([
        'origin_latitude' => -6.175110,
        'origin_longitude' => 106.865036,
        'destination_latitude' => -6.200000,
        'destination_longitude' => 106.816666,
        'couriers' => 'jne',
        'items' => [
            [
                'name' => 'Test Product',
                'value' => 100000,
                'weight' => 1000,
                'quantity' => 1,
            ]
        ],
    ]);

    return $result;
});
```

Expected: `{"success": true, "data": [...]}`

**🗑️ HAPUS semua test routes setelah verifikasi!**

---

## 📋 Deployment Environment Checklist

- [ ] `.env` file exists on server
- [ ] `BITESHIP_API_KEY` set correctly (187 characters)
- [ ] `BITESHIP_BASE_URL` = `https://api.biteship.com/v1`
- [ ] `BITESHIP_ENVIRONMENT` = `development` (for testing)
- [ ] Run `php artisan config:clear`
- [ ] Run `php artisan cache:clear`
- [ ] Run `php artisan config:cache`
- [ ] Restart services (PHP-FPM, Nginx/Apache)
- [ ] Test config dengan `php artisan tinker`
- [ ] Test checkout flow

---

## 🐛 Troubleshooting

### Issue: "Authorization failed" (401)
**Cause:** API key salah atau tidak ada

**Fix:**
1. Check `.env` file ada `BITESHIP_API_KEY`
2. Verify API key sama dengan local (copy-paste dari local)
3. Clear config: `php artisan config:clear && php artisan config:cache`

### Issue: "Route not found" (404)
**Cause:** Base URL salah atau path endpoint salah

**Fix:**
1. Check `BITESHIP_BASE_URL` = `https://api.biteship.com/v1` (ada `/v1`)
2. Verify BiteshipService constructor menggunakan trailing slash
3. Verify endpoint path tanpa leading slash (contoh: `rates/couriers`)

### Issue: Config tidak update setelah edit .env
**Cause:** Config di-cache oleh Laravel

**Fix:**
```bash
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

### Issue: API key hilang setelah deploy
**Cause:** `.env` tidak ter-copy atau di-overwrite

**Fix:**
1. Jangan include `.env` di git
2. Keep backup `.env` di server
3. Use deployment script yang preserve `.env`

---

## 🎯 Quick Fix Command

Jalankan ini di server deployment:

```bash
# 1. Edit .env
nano .env

# 2. Tambahkan/update:
# BITESHIP_API_KEY=biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoic2lkZXNhIiwidXNlcklkIjoiNjkwZjhmNTg0MzcyNDI4M2Y0MGY5NmI5IiwiaWF0IjoxNzYyNjI3NzI3fQ.Fqx6vBVgV2S3xjC0q9CbFO6YOLNkoXK0apmhLC1uwTc

# 3. Save & exit (Ctrl+X, Y, Enter)

# 4. Clear cache
php artisan config:clear && php artisan cache:clear && php artisan config:cache

# 5. Test
php artisan tinker
>>> config('biteship.api_key')
>>> exit

# 6. Restart services (jika perlu)
sudo service php8.1-fpm restart  # Sesuaikan PHP version
sudo service nginx reload
```

---

## ✅ Success Verification

Setelah semua langkah di atas, coba lagi checkout:

1. Add produk ke cart
2. Checkout
3. Pilih lokasi pengiriman
4. **Expected:** Muncul pilihan kurir (JNE, J&T, dll)
5. Check browser console - should see:
   ```
   Biteship Response: {success: true, data: [...]}
   Total rates collected: 3 (atau lebih)
   ```

---

## 📞 Need Help?

Jika masih error:
1. Screenshot error message di console
2. Check Laravel log: `storage/logs/laravel.log`
3. Cek apakah Biteship API key masih valid (login ke dashboard Biteship)

---

**Mode Testing:** Ya, bisa pakai mode testing di deployment!
- Gunakan `BITESHIP_ENVIRONMENT=development`
- API key yang sama bisa dipakai di local & deployment
- Testing mode tidak berbeda antara local dan deployment
