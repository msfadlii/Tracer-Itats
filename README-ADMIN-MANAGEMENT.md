# 🔐 Panduan Admin Management - ITATS Tracer Study

## 📋 Daftar Isi

1. [Setup Admin Awal](#setup-admin-awal)
2. [Mengganti Email Admin](#mengganti-email-admin)
3. [Mengganti Password Admin](#mengganti-password-admin)
4. [Troubleshooting](#troubleshooting)
5. [Security Best Practices](#security-best-practices)

---

## 📚 Setup Admin Awal

### Default Admin Credentials

```
Email: admin@itats.ac.id
Password: admin
Name: Admin_ITATS
```

⚠️ **PENTING**: Ganti password default sebelum production!

---

## 📧 Mengganti Email Admin

### Skenario: Ganti dari `admin@itats.ac.id` ke email asli seperti `nama.admin@itats.ac.id`

### **Method 1: Via Environment + Command (Recommended)**

#### Step 1: Edit `.env` di Server Production

```bash
# SSH ke server
ssh username@server-ip

# Masuk ke folder aplikasi
cd /var/www/tracer-app

# Edit .env
nano .env
```

#### Step 2: Update Environment Variables

```env
# Ganti email admin ke yang asli
ADMIN_NAME="Nama Admin Asli"
ADMIN_EMAIL="nama.admin@itats.ac.id"
ADMIN_PASSWORD="PasswordBaru123!"
```

#### Step 3: Update Admin via Command

```bash
# Method A: Update existing admin (email lama tetap ada)
php artisan admin:setup --force

# Method B: Hapus admin lama, buat admin baru
php artisan tinker
>>> $oldAdmin = App\Models\User::where('email', 'admin@itats.ac.id')->first();
>>> $oldAdmin->delete();
>>> exit

php artisan admin:setup
```

### **Method 2: Via Command Manual**

#### Step 1: Login ke Server

```bash
ssh username@server-ip
cd /var/www/tracer-app
```

#### Step 2: Buat Admin Baru via Tinker

```bash
php artisan tinker
```

```php
// Buat admin baru
App\Models\User::create([
    'name' => 'Nama Admin Asli',
    'email' => 'nama.admin@itats.ac.id',
    'password' => Hash::make('PasswordBaru123!')
]);

// Hapus admin lama (opsional)
App\Models\User::where('email', 'admin@itats.ac.id')->delete();

// Verifikasi
App\Models\User::all()->pluck('email', 'name');
exit
```

### **Method 3: Via Database Direct (Emergency)**

#### Step 1: Backup Database

```bash
mysqldump -u username -p database_name > backup_$(date +%Y%m%d).sql
```

#### Step 2: Update via SQL

```sql
-- Connect ke database
mysql -u username -p database_name

-- Update email admin existing
UPDATE users
SET email = 'nama.admin@itats.ac.id',
    name = 'Nama Admin Asli'
WHERE email = 'admin@itats.ac.id';

-- Atau insert admin baru
INSERT INTO users (name, email, password, created_at, updated_at)
VALUES (
    'Nama Admin Asli',
    'nama.admin@itats.ac.id',
    '$2y$12$hashPasswordDisini',
    NOW(),
    NOW()
);

-- Verifikasi
SELECT id, name, email FROM users;
```

---

## 🔑 Mengganti Password Admin

### **Method 1: Via Environment + Command**

```bash
# Edit .env
ADMIN_PASSWORD="PasswordBaruYangAman123!"

# Update admin
php artisan admin:setup --force
```

### **Method 2: Via Tinker**

```bash
php artisan tinker
```

```php
$admin = App\Models\User::where('email', 'nama.admin@itats.ac.id')->first();
$admin->update(['password' => Hash::make('PasswordBaruYangAman123!')]);
echo "Password berhasil diupdate!";
exit
```

### **Method 3: Via Command Custom**

```bash
# Gunakan command yang sudah dibuat
php artisan admin:setup --force
```

---

## 🔧 Troubleshooting

### Problem 1: Tidak Bisa Login Setelah Ganti Email

**Symptom**: Login gagal dengan email baru

**Solution**:

```bash
# Cek apakah admin baru sudah terbuat
php artisan tinker
>>> App\Models\User::all()->pluck('email', 'name');

# Jika belum ada, buat manual
>>> App\Models\User::create([
    'name' => 'Nama Admin',
    'email' => 'nama.admin@itats.ac.id',
    'password' => Hash::make('password123')
]);
```

### Problem 2: Lupa Password Baru

**Solution**:

```bash
# Reset via command
php artisan tinker
>>> $admin = App\Models\User::where('email', 'nama.admin@itats.ac.id')->first();
>>> $admin->update(['password' => Hash::make('passwordbaru123')]);
>>> echo "Password direset ke: passwordbaru123";
```

### Problem 3: Multiple Admin Tidak Sengaja

**Solution**:

```bash
# Lihat semua admin
php artisan tinker
>>> App\Models\User::all();

# Hapus admin yang tidak perlu
>>> App\Models\User::where('email', 'admin@itats.ac.id')->delete();
```

### Problem 4: Forgot Password Tidak Bekerja

**Check**:

1. Email setting di `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@gmail.com
MAIL_PASSWORD=app_specific_password
MAIL_FROM_ADDRESS=noreply@itats.ac.id
```

2. Test email:

```bash
php artisan tinker
>>> Mail::raw('Test email', function($msg) {
    $msg->to('nama.admin@itats.ac.id')->subject('Test');
});
```

---

## 🛡️ Security Best Practices

### 1. Password Policy

```
✅ Minimal 12 karakter
✅ Kombinasi huruf besar, kecil, angka, simbol
✅ Tidak menggunakan kata umum
✅ Ganti berkala (3-6 bulan)

❌ Jangan: admin, password, 123456
✅ Contoh: ITATSAdmin2024!@#
```

### 2. Email Policy

```
✅ Gunakan email resmi: nama@itats.ac.id
✅ Email yang masih aktif dan terpantau
✅ Backup admin email (jika diperlukan)

❌ Jangan: email pribadi, email tidak aktif
```

### 3. Environment Configuration

```env
# Production .env
APP_ENV=production
APP_DEBUG=false

# Admin settings
ADMIN_NAME="Admin ITATS Production"
ADMIN_EMAIL="admin.tracer@itats.ac.id"
ADMIN_PASSWORD="VerySecurePassword2024!@#"

# Email settings (WAJIB untuk forgot password)
MAIL_MAILER=smtp
MAIL_HOST=smtp.itats.ac.id
MAIL_PORT=587
MAIL_USERNAME=noreply@itats.ac.id
MAIL_PASSWORD=secure_email_password
MAIL_FROM_ADDRESS=noreply@itats.ac.id
MAIL_FROM_NAME="ITATS Tracer Study"
```

### 4. Backup Strategy

```bash
# Backup database sebelum perubahan admin
mysqldump -u username -p tracer_db > admin_backup_$(date +%Y%m%d_%H%M).sql

# Backup .env
cp .env .env.backup.$(date +%Y%m%d_%H%M)
```

---

## 📞 Emergency Contacts

### Jika Ada Masalah:

1. **Developer**: Contact development team
2. **Server Admin**: Contact hosting provider
3. **Database**: Check database backup & recovery

### Emergency Reset (Last Resort):

```bash
# Reset total admin ke default
php artisan migrate:fresh --seed --force
# ⚠️ WARNING: Ini akan menghapus SEMUA data!
```

---

## 📝 Change Log Template

```markdown
## Admin Changes Log

### [2024-11-01] - Initial Production Setup

-   ✅ Created default admin: admin@itats.ac.id
-   ✅ Configured email settings
-   ✅ Deployed to production

### [2024-11-XX] - Email Update

-   ✅ Changed admin email from admin@itats.ac.id to nama.admin@itats.ac.id
-   ✅ Updated password to secure password
-   ✅ Tested login & forgot password functionality
-   ✅ Verified email sending

### [2024-XX-XX] - Password Rotation

-   ✅ Updated admin password
-   ✅ Notified admin team
```

---

## 🚀 Quick Commands Reference

```bash
# Lihat admin saat ini
php artisan tinker --execute="App\Models\User::all()->pluck('email', 'name')"

# Update admin dari .env
php artisan admin:setup --force

# Buat admin baru manual
php artisan tinker
>>> App\Models\User::create(['name'=>'Name','email'=>'email@itats.ac.id','password'=>Hash::make('pass')]);

# Reset password
php artisan tinker
>>> App\Models\User::where('email','admin@itats.ac.id')->first()->update(['password'=>Hash::make('newpass')]);

# Test email
php artisan tinker
>>> Mail::raw('Test', function($m){ $m->to('admin@itats.ac.id')->subject('Test'); });
```

---

**📧 Support**: Jika mengalami kesulitan, hubungi tim development dengan menyertakan:

1. Screenshot error (jika ada)
2. Log file (`storage/logs/laravel.log`)
3. Environment yang digunakan (local/staging/production)
4. Step yang sudah dicoba

**🔒 Remember**: Selalu backup database sebelum melakukan perubahan admin!
