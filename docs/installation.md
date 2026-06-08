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

Bagian ini berisi masalah yang sering muncul setelah file `.env` tersedia dan database sudah terkoneksi.

### Composer Install Gagal

Jika `composer install` gagal, periksa versi PHP dan ekstensi yang dibutuhkan Laravel.

```bash
php -v
composer install
```

Jika masih gagal, bersihkan cache Composer lalu ulangi instalasi.

```bash
composer clear-cache
composer install
```

### NPM Install Gagal

Jika `npm install` gagal, pastikan Node.js dan npm sudah terpasang.

```bash
node -v
npm -v
npm install
```

Jika dependency frontend bermasalah, hapus folder `node_modules` secara manual lalu jalankan ulang `npm install`.

### Migration Gagal atau Tabel Belum Terbuat

Jika tabel database belum muncul, jalankan migrasi.

```bash
php artisan migrate
```

Jika ingin mengulang migrasi dari awal pada database lokal, gunakan:

```bash
php artisan migrate:fresh
```

Catatan: `migrate:fresh` akan menghapus tabel yang sudah ada, jadi gunakan hanya untuk database development.

### Asset Frontend Tidak Terbaca

Jika tampilan tidak memuat CSS atau JavaScript, jalankan Vite development server.

```bash
npm run dev
```

Untuk build asset production, jalankan:

```bash
npm run build
```

### Port Laravel Sudah Digunakan

Jika `php artisan serve` gagal karena port `8000` sudah digunakan, jalankan server pada port lain.

```bash
php artisan serve --port=8001
```

### Konfigurasi Lama Masih Terbaca

Jika perubahan `.env`, route, atau konfigurasi belum terbaca, bersihkan cache Laravel.

```bash
php artisan optimize:clear
```

### Permission Storage Bermasalah

Jika upload file, cache, atau log tidak bisa ditulis, pastikan folder `storage` dan `bootstrap/cache` dapat diakses aplikasi.

Pada Linux/macOS:

```bash
chmod -R 775 storage bootstrap/cache
```

Pada Windows, pastikan folder proyek tidak berada di lokasi yang dibatasi permission dan jalankan terminal dengan akses yang cukup.

## 11. Checklist Instalasi

- Repository berhasil di-clone.
- Dependency Composer berhasil diinstall.
- Dependency npm berhasil diinstall.
- File `.env` tersedia.
- `APP_KEY` berhasil dibuat.
- Database berhasil dibuat.
- Migrasi berhasil dijalankan.
- Aplikasi dapat dibuka di browser lokal.
