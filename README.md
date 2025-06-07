# Absensi PT Surya

Aplikasi sederhana untuk absensi pegawai menggunakan Laravel 12 dan PHP 8.3.

---

## Persyaratan Sistem

- PHP 8.3  
- Composer  
- Database (MySQL)  
- Laravel 12.x  

---

## Langkah Instalasi & Setup

### 1. Clone Repository

``
git clone <https://github.com/candrabudi/presence-pt-surya>
cd presence-pt-surya

2. Install Dependencies
Install package PHP yang diperlukan dengan Composer:


composer install
3. Buat File Environment
cp .env.example .env

4. Konfigurasi Database
Edit file .env sesuaikan koneksi database Anda:

.env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi_pt_surya
DB_USERNAME=root
DB_PASSWORD=
Pastikan database sudah dibuat di server database Anda, misal:

sql

CREATE DATABASE absensi_pt_surya;

5. Generate App Key
php artisan key:generate

6. Jalankan Migration
Untuk membuat tabel-tabel database yang dibutuhkan:
php artisan migrate

7. Jalankan Server Development
php artisan serve
Akses aplikasi melalui browser:
http://127.0.0.1:8000

Catatan:
1. Database dikelola lewat folder database/migrations untuk membuat atau mengubah tabel.
2. Controller aplikasi berada di folder app/Http/Controllers.
3. View blade untuk tampilan ada di folder resources/views.
4. Konfigurasi koneksi database diatur di file .env.
5. Pastikan menggunakan PHP versi 8.3 dan Laravel versi 12.x agar kompatibel dengan fitur terbaru.
