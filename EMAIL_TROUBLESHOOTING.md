# 🔧 Email Troubleshooting Guide

## Error: "SMTP Authentication gagal"

### 🚫 Penyebab Umum:
1. **App Password Gmail belum dibuat**
2. **2-Factor Authentication belum aktif**
3. **Menggunakan password biasa** (bukan App Password)
4. **Email salah** atau typo

### ✅ Solusi:

#### 1. Pastikan 2FA Aktif:
- Buka: **https://myaccount.google.com/security**
- Cari "2-Step Verification" → **Turn ON**

#### 2. Generate App Password:
- Di halaman yang sama, scroll ke "App passwords"
- Atau langsung: **https://myaccount.google.com/apppasswords**
- Generate password untuk **"Mail"**
- Copy **16-digit password** (format: xxxx-xxxx-xxxx-xxxx)

#### 3. Update Dashboard Admin:
- Email Username: `your-email@gmail.com`
- Password: **App Password 16-digit** (bukan password Gmail biasa!)
- Host: `smtp.gmail.com`
- Port: `587`
- Encryption: `TLS`

#### 4. Test Email:
- Klik "Simpan Pengaturan"
- Klik "Test Email"

---

## Error: "Test email gagal"

### 🔍 Debug Steps:

#### 1. Cek Network/Firewall:
- Pastikan port 587 tidak diblokir
- Test dari komputer/network lain

#### 2. Alternative SMTP:
Jika Gmail bermasalah, coba provider lain:

**Yahoo Mail:**
- Host: `smtp.mail.yahoo.com`
- Port: `587`
- Encryption: `TLS`

**Outlook/Hotmail:**
- Host: `smtp-mail.outlook.com`  
- Port: `587`
- Encryption: `TLS`

#### 3. Fallback ke Log Driver:
- Klik "Reset SMTP" di dashboard
- Klik "Simpan Pengaturan"
- Email akan disimpan di log file
- Test dengan "Test Email"

---

## Sistem Log Driver

### 📝 Cara Kerja:
- Email **TIDAK** dikirim sungguhan
- Email disimpan di file: `storage/logs/laravel.log`
- Berguna untuk testing tanpa SMTP

### 📧 Cara Lihat Email:
1. Buka file: `storage/logs/laravel.log`
2. Cari bagian terbaru dengan kata "local.INFO"
3. Email dalam format HTML tersimpan di sana

---

## FAQ

### Q: Kenapa perlu App Password?
**A:** Gmail memblokir aplikasi yang menggunakan password biasa untuk security. App Password adalah password khusus untuk aplikasi.

### Q: Bisa pakai email provider lain?
**A:** Ya! Yahoo, Outlook, atau SMTP hosting lainnya bisa digunakan.

### Q: Email ke kepala desa tidak masuk?
**A:** Periksa folder Spam/Junk. Gmail kadang menganggap email otomatis sebagai spam.

### Q: Cara test tanpa SMTP sungguhan?
**A:** Gunakan Log Driver (kosongkan field SMTP). Email akan tersimpan di log file.

---

## 💡 Tips:

1. **Selalu test** setelah save settings
2. **Gunakan log driver** untuk development
3. **Setup SMTP** untuk production
4. **Backup App Password** di tempat aman
5. **Ganti provider** jika satu tidak working

---

## ✅ Status Check:

### SMTP Working:
- ✅ Test Email berhasil
- ✅ Email masuk ke inbox kepala desa
- ✅ No error message

### Log Driver Working:
- ⚠️ Test Email berhasil (log)
- ⚠️ Email tersimpan di laravel.log
- ⚠️ Tidak ada email sungguhan terkirim

### Error:
- ❌ Authentication failed
- ❌ Connection timeout
- ❌ Network error

Jika masih bermasalah, gunakan Log Driver dulu sambil debugging SMTP! 🚀