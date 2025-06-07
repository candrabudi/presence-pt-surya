# Aplikasi Absensi PT Surya

Aplikasi sederhana untuk mengelola absensi pegawai menggunakan **Laravel 12** dan **PHP 8.3**.

## Persyaratan Sistem

- PHP ^8.3
- Composer
- Database (MySQL)
- Laravel ^12.0

## Langkah Instalasi dan Konfigurasi

### 1. Clone Repository
```bash
git clone https://github.com/candrabudi/presence-pt-surya
cd presence-pt-surya
```

### 2. Install Dependensi
Install paket PHP yang diperlukan menggunakan Composer:
```bash
composer install
```

### 3. Buat File Environment
Salin file `.env.example` untuk membuat file `.env`:
```bash
cp .env.example .env
```

### 4. Konfigurasi Database
Edit file `.env` untuk menyesuaikan koneksi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi_pt_surya
DB_USERNAME=root
DB_PASSWORD=
```

Pastikan database sudah dibuat di server database Anda. Contoh perintah SQL:
```sql
CREATE DATABASE absensi_pt_surya;
```

### 5. Generate Application Key
Jalankan perintah berikut untuk membuat kunci aplikasi:
```bash
php artisan key:generate
```

### 6. Jalankan Migration
Buat tabel-tabel yang diperlukan di database:
```bash
php artisan migrate
```

### 7. Jalankan Server Pengembangan
Jalankan server lokal Laravel:
```bash
php artisan serve
```

Akses aplikasi melalui browser di:
```
http://127.0.0.1:8000
```

## Catatan Penting
- **Database**: Dikelola melalui file migration di folder `database/migrations`.
- **Controller**: Berada di folder `app/Http/Controllers`.
- **View**: Template Blade tersimpan di folder `resources/views`.
- **Konfigurasi Database**: Diatur melalui file `.env`.
- **Kompatibilitas**: Pastikan menggunakan PHP 8.3 dan Laravel 12.x untuk mendukung fitur terbaru.