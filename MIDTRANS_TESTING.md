# Panduan Testing Midtrans Payment Gateway

Dokumen ini berisi panduan lengkap untuk melakukan testing integrasi pembayaran Midtrans di aplikasi SiDesa.

## Daftar Isi
1. [Konfigurasi Midtrans](#konfigurasi-midtrans)
2. [Menggunakan Test Command](#menggunakan-test-command)
3. [Testing Manual melalui Browser](#testing-manual-melalui-browser)
4. [Testing Webhook](#testing-webhook)
5. [Troubleshooting](#troubleshooting)

---

## Konfigurasi Midtrans

### 1. Setup Environment Variables

Pastikan file `.env` sudah memiliki konfigurasi Midtrans:

```env
# Midtrans Payment Gateway
MIDTRANS_MERCHANT_ID=your_merchant_id
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

**Catatan:**
- Untuk testing, gunakan `MIDTRANS_IS_PRODUCTION=false` (Sandbox mode)
- Dapatkan credentials dari [Midtrans Dashboard](https://dashboard.midtrans.com/)
- Sandbox credentials: Settings > Access Keys > Sandbox

### 2. Verifikasi Konfigurasi

Jalankan command berikut untuk memverifikasi konfigurasi:

```bash
php artisan midtrans:test info
```

Output yang diharapkan:
```
✓ Midtrans is configured properly
```

---

## Menggunakan Test Command

Aplikasi dilengkapi dengan command khusus untuk testing Midtrans: `php artisan midtrans:test`

### Available Actions

#### 1. Show Configuration & Info
```bash
php artisan midtrans:test info
```
Menampilkan:
- Konfigurasi Midtrans (environment, keys, dll)
- Available routes
- Recent orders yang bisa digunakan untuk testing

#### 2. Create Payment Token
```bash
# Menggunakan Order ID
php artisan midtrans:test create-token --order=4

# Menggunakan Order Number
php artisan midtrans:test create-token --order=ORD202511040392BF
```

Output yang diharapkan:
- Order details
- Snap token yang berhasil dibuat
- Payment URL
- Test card numbers untuk sandbox testing

**Test Card Numbers (Sandbox):**
| Card Number | CVV | Exp | Type | Result |
|-------------|-----|-----|------|--------|
| 4811 1111 1111 1114 | 123 | 12/26 | Visa | Success |
| 5211 1111 1111 1117 | 123 | 12/26 | Mastercard | Success |
| 4911 1111 1111 1113 | 123 | 12/26 | Visa | Challenge by FDS |
| 4411 1111 1111 1118 | 123 | 12/26 | Visa | Denied by Bank |

#### 3. Check Payment Status
```bash
php artisan midtrans:test check-status --order=4
```

Menampilkan:
- Transaction status dari Midtrans API
- Current order status dalam database
- Payment details

**Catatan:** Command ini akan error jika transaksi belum pernah dibayar (normal behavior).

#### 4. Webhook Testing Guide
```bash
php artisan midtrans:test webhook-test
```

Menampilkan panduan dan contoh curl command untuk testing webhook.

---

## Testing Manual melalui Browser

### Langkah-langkah Testing

1. **Login sebagai User**
   ```
   http://localhost/login
   ```

2. **Buat Order Baru**
   - Tambahkan produk ke cart
   - Pilih alamat pengiriman
   - Pilih metode pengiriman (kurir)
   - Checkout

3. **Halaman Pembayaran**
   - Setelah checkout, akan redirect ke halaman pembayaran
   - URL: `http://localhost/payment/{order_id}`

4. **Klik "Bayar Sekarang"**
   - Popup Midtrans Snap akan muncul
   - Pilih metode pembayaran (Credit Card, Virtual Account, E-Wallet, dll)

5. **Test dengan Credit Card**
   - Pilih "Credit Card"
   - Masukkan test card number: `4811 1111 1111 1114`
   - CVV: `123`
   - Exp Date: `12/26` (atau tanggal valid lainnya)
   - Klik "Pay"

6. **Verifikasi Hasil**
   - Success: redirect ke order detail dengan status "paid"
   - Pending: redirect ke order detail dengan status "pending"
   - Failed: popup error dan bisa retry

### Flow Diagram

```
User → Add to Cart → Checkout → Payment Page → Midtrans Snap Popup
                                                      ↓
                                              Choose Payment Method
                                                      ↓
                                              Complete Payment
                                                      ↓
                                          ┌───────────┴──────────┐
                                          ↓                      ↓
                                      Success                Pending/Failed
                                          ↓                      ↓
                                  Order Status: Paid      Retry Payment
```

---

## Testing Webhook

Webhook adalah notifikasi otomatis dari Midtrans ke aplikasi kita ketika status pembayaran berubah.

### Setup Webhook untuk Local Development

#### Menggunakan ngrok

1. **Install ngrok**
   ```bash
   # Download dari https://ngrok.com/download
   # Atau install via chocolatey (Windows)
   choco install ngrok
   ```

2. **Jalankan ngrok**
   ```bash
   ngrok http 8000
   ```

3. **Copy Forwarding URL**
   ```
   Forwarding: https://abc123.ngrok.io -> http://localhost:8000
   ```

4. **Configure di Midtrans Dashboard**
   - Login ke [Midtrans Dashboard](https://dashboard.midtrans.com/)
   - Settings > Configuration
   - Payment Notification URL: `https://abc123.ngrok.io/payment/notification`
   - Click "Update"

5. **Test Pembayaran**
   - Lakukan pembayaran test
   - Midtrans akan mengirim notification ke webhook URL
   - Check logs atau database untuk melihat perubahan status

### Manual Webhook Testing dengan CURL

```bash
curl -X POST http://localhost/payment/notification \
  -H 'Content-Type: application/json' \
  -d '{
    "transaction_time": "2025-11-04T03:50:41+00:00",
    "transaction_status": "settlement",
    "transaction_id": "test-123456",
    "status_message": "Success",
    "status_code": "200",
    "signature_key": "dummy_signature",
    "payment_type": "credit_card",
    "order_id": "ORD202511040392BF",
    "merchant_id": "G542973406",
    "gross_amount": "194500.00",
    "fraud_status": "accept",
    "currency": "IDR"
  }'
```

**Catatan:** Signature key di atas adalah dummy. Untuk testing real, gunakan pembayaran sesungguhnya atau Midtrans simulator.

### Verifikasi Webhook

Setelah webhook dipanggil, verifikasi di database:

```sql
SELECT
    order_number,
    payment_status,
    midtrans_transaction_id,
    midtrans_transaction_status,
    paid_at
FROM orders
WHERE order_number = 'ORD202511040392BF';
```

Expected result setelah payment success:
- `payment_status`: 'paid'
- `midtrans_transaction_id`: filled with transaction ID
- `midtrans_transaction_status`: 'settlement' or 'capture'
- `paid_at`: current timestamp

---

## Troubleshooting

### 1. "Midtrans configuration incomplete"

**Problem:** Environment variables belum di-set

**Solution:**
```bash
# Check .env file
cat .env | grep MIDTRANS

# Pastikan semua variable terisi
MIDTRANS_MERCHANT_ID=xxx
MIDTRANS_CLIENT_KEY=xxx
MIDTRANS_SERVER_KEY=xxx
```

### 2. "Transaction doesn't exist" saat check status

**Problem:** Order belum pernah dibayar di Midtrans

**Solution:**
- Ini normal jika order belum dibayar
- Lakukan pembayaran test dulu
- Baru check status lagi

### 3. Snap popup tidak muncul

**Problem:** JavaScript error atau Client Key salah

**Solution:**
1. Check browser console untuk error
2. Verifikasi Client Key di `.env`
3. Pastikan Snap JS sudah loaded:
   ```html
   <script src="https://app.sandbox.midtrans.com/snap/snap.js"></script>
   ```

### 4. Webhook tidak dipanggil

**Problem:** Midtrans tidak bisa reach webhook URL

**Solution:**
- Untuk local development, gunakan ngrok
- Pastikan webhook URL di Midtrans Dashboard benar
- Check apakah URL accessible dari internet
- Verifikasi route tidak memerlukan authentication:
  ```php
  // routes/web.php
  Route::post('/payment/notification', [PaymentController::class, 'notification'])
      ->name('user.payment.notification');
  ```

### 5. Payment status tidak update setelah bayar

**Problem:** Webhook callback gagal atau belum di-configure

**Possible Causes:**
1. Webhook URL belum di-set di Midtrans Dashboard
2. Application error saat handle notification
3. Signature validation failed

**Solution:**
1. Check application logs: `storage/logs/laravel.log`
2. Test webhook manually dengan curl
3. Verifikasi MidtransService::handleNotification() berjalan dengan baik

### 6. Error "CSRF token mismatch" pada webhook

**Problem:** Laravel CSRF protection blocking webhook

**Solution:**
Webhook route sudah exclude dari CSRF di `VerifyCsrfToken.php`:
```php
protected $except = [
    '/payment/notification',
];
```

Pastikan path sesuai dengan route.

---

## Payment Status Flow

```
Order Created (unpaid)
    ↓
User Click "Bayar Sekarang"
    ↓
Midtrans Snap Token Created
    ↓
User Complete Payment
    ↓
┌───────────────────────┐
│  Midtrans Processes   │
└───────────┬───────────┘
            ↓
    ┌───────┴────────┐
    ↓                ↓
Success          Pending/Failed
    ↓                ↓
status: paid    status: pending/failed
    ↓
Order Status: completed
```

---

## Testing Checklist

### Pre-Testing
- [ ] Environment variables configured
- [ ] Database migrated
- [ ] Test order created
- [ ] Midtrans credentials valid (sandbox)

### Payment Flow Testing
- [ ] Payment page loads correctly
- [ ] Snap popup appears on button click
- [ ] Can select payment method
- [ ] Credit Card payment works (test card)
- [ ] Virtual Account payment works
- [ ] E-Wallet payment works (GoPay, ShopeePay)
- [ ] QRIS payment works

### Success Scenarios
- [ ] Payment success redirects to order detail
- [ ] Order status updates to "paid"
- [ ] Payment timestamp recorded
- [ ] Transaction ID saved

### Failure Scenarios
- [ ] Payment failed shows error message
- [ ] Can retry payment
- [ ] Order status remains "unpaid"
- [ ] User can go back to order detail

### Webhook Testing
- [ ] Webhook URL configured in Midtrans
- [ ] Notification received on payment
- [ ] Order status updates automatically
- [ ] Database records updated correctly

---

## Useful Links

- [Midtrans Dashboard](https://dashboard.midtrans.com/)
- [Midtrans Documentation](https://docs.midtrans.com/)
- [Snap Payment](https://docs.midtrans.com/en/snap/overview)
- [Testing Payment](https://docs.midtrans.com/en/technical-reference/sandbox-test)
- [Webhook/Notification](https://docs.midtrans.com/en/after-payment/http-notification)

---

## Contact & Support

Jika mengalami masalah:
1. Check application logs: `storage/logs/laravel.log`
2. Check Midtrans transaction logs di Dashboard
3. Konsultasi Midtrans documentation
4. Contact Midtrans support: support@midtrans.com

---

**Last Updated:** 2025-11-04
**Version:** 1.0
