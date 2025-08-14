# Email Configuration Guide - SiDesa

## ⚠️ PENTING: Konfigurasi Email untuk Production

Sistem kontak sudah berfungsi dengan baik, namun perlu konfigurasi email SMTP untuk mengirim email sungguhan ke kepala desa.

### 1. Konfigurasi Gmail SMTP (Recommended)

#### A. Siapkan Gmail Account:
1. Login ke Gmail account yang akan digunakan
2. Aktifkan 2-Factor Authentication
3. Generate App Password:
   - Go to: https://myaccount.google.com/security
   - Klik "2-Step Verification" 
   - Scroll down, klik "App passwords"
   - Generate password untuk "Mail"

#### B. Update .env File:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-actual-email@gmail.com
MAIL_PASSWORD=your-16-digit-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@bumdes.local"
MAIL_FROM_NAME="Website Desa"
```

### 2. Alternative SMTP Providers:

#### A. Yahoo Mail:
```env
MAIL_HOST=smtp.mail.yahoo.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
```

#### B. Outlook/Hotmail:
```env
MAIL_HOST=smtp-mail.outlook.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
```

#### C. Local SMTP Server:
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-server.com
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
```

### 3. Testing Email Configuration:

#### A. Test dengan Command:
```bash
php artisan test:email
```

#### B. Test via Website:
1. Login ke Super Admin
2. Set email kepala desa di menu "Pengaturan Desa"
3. Buka: http://localhost:8000/contact
4. Kirim test message
5. Check inbox email kepala desa

### 4. Troubleshooting:

#### A. Common Issues:
- **"Connection could not be established"**: Check SMTP host & port
- **"Authentication failed"**: Check username/password
- **"Must issue a STARTTLS command first"**: Change encryption to 'tls'

#### B. Debug Mode:
Untuk melihat error detail, set di .env:
```env
APP_DEBUG=true
MAIL_MAILER=log  # Temporary for testing
```

### 5. Production Checklist:

- [ ] SMTP credentials configured
- [ ] Test email sending works
- [ ] Email kepala desa set di admin panel
- [ ] APP_DEBUG=false untuk production
- [ ] SSL certificate untuk domain (jika hosting)

### 6. Current Status:

✅ **SUDAH SIAP:**
- Contact form UI
- Email template (professional HTML)
- Settings system untuk email kepala desa
- Error handling & validation
- Super admin configuration panel

⚠️ **PERLU KONFIGURASI:**
- SMTP credentials di .env file
- Test dengan email sungguhan

### 7. Cara Penggunaan:

1. **Super Admin** login dan set email kepala desa
2. **User** kirim pesan via contact form
3. **Email otomatis** terkirim ke kepala desa
4. **Kepala desa** bisa reply langsung ke email pengirim

Sistem sudah LENGKAP, tinggal konfigurasi SMTP saja! 🚀