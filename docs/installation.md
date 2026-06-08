# Installation Documentation

Dokumen ini menjelaskan langkah instalasi lokal aplikasi Brainy. Dokumentasi ini disiapkan untuk target dokumentasi awal sebelum implementasi fitur selesai.

## 1. Prasyarat Sistem

Pastikan perangkat sudah memiliki:

| Kebutuhan | Versi/Rekomendasi |
| --- | --- |
| PHP | 8.2 atau lebih baru |
| Composer | Versi terbaru yang kompatibel dengan PHP |
| Node.js | Versi LTS |
| npm | Mengikuti instalasi Node.js |
| Database | MySQL atau MariaDB |
| Git | Versi terbaru |

## 2. Clone Repository

```bash
git clone https://github.com/Theshadowozz/Ruang_Brainy.git
cd Ruang_Brainy
```

Jika repository sudah ada di lokal, pastikan branch yang digunakan sesuai dengan branch kerja tim.

```bash
git status
git branch
```

## 3. Install Dependency Backend

```bash
composer install
```

Perintah ini akan membaca `composer.json` dan mengunduh package PHP yang dibutuhkan Laravel.

## 4. Install Dependency Frontend

```bash
npm install
```

Perintah ini akan membaca `package.json` dan mengunduh dependency frontend seperti Vite dan Tailwind CSS.

## 5. Konfigurasi Environment

Salin file environment contoh:

```bash
cp .env.example .env
```

Pada Windows PowerShell, gunakan:

```powershell
Copy-Item .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

## 6. Konfigurasi Database

Buat database baru di MySQL atau MariaDB.

```sql
CREATE DATABASE ruang_brainy;
```

Sesuaikan konfigurasi berikut di file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ruang_brainy
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan `DB_USERNAME` dan `DB_PASSWORD` dengan konfigurasi lokal masing-masing anggota tim.

## 7. Jalankan Migrasi Database

```bash
php artisan migrate
```

Jika proyek sudah menyediakan seeder, jalankan:

```bash
php artisan db:seed
```

Catatan: seeder belum wajib dijalankan jika data awal belum tersedia.

## 8. Jalankan Aplikasi

Jalankan server Laravel:

```bash
php artisan serve
```

Aplikasi dapat dibuka melalui:

```text
http://127.0.0.1:8000
```

Untuk menjalankan asset frontend saat development:

```bash
npm run dev
```

Untuk build asset production:

```bash
npm run build
```

## 9. Perintah Tambahan

Membersihkan cache Laravel:

```bash
php artisan optimize:clear
```

Menjalankan test:

```bash
php artisan test
```

Menjalankan format kode Laravel Pint:

```bash
./vendor/bin/pint
```

Pada Windows PowerShell:

```powershell
vendor\bin\pint.bat
```

## 10. Troubleshooting

### File `.env` Belum Ada

Pastikan `.env.example` sudah disalin menjadi `.env`.

```bash
cp .env.example .env
php artisan key:generate
```

### Database Tidak Terkoneksi

Periksa kembali:

- Service MySQL/MariaDB sudah berjalan.
- Nama database sudah dibuat.
- Username dan password pada `.env` benar.
- Port database sesuai, biasanya `3306`.

### Tabel Belum Ada

Jalankan migrasi:

```bash
php artisan migrate
```

### Asset Frontend Tidak Muncul

Jalankan:

```bash
npm install
npm run dev
```

### Cache Menyebabkan Konfigurasi Lama Terbaca

Jalankan:

```bash
php artisan optimize:clear
```

## 11. Checklist Instalasi

- Repository berhasil di-clone.
- Dependency Composer berhasil diinstall.
- Dependency npm berhasil diinstall.
- File `.env` tersedia.
- `APP_KEY` berhasil dibuat.
- Database berhasil dibuat.
- Migrasi berhasil dijalankan.
- Aplikasi dapat dibuka di browser lokal.
