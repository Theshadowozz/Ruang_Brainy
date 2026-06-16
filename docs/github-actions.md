# GitHub Actions Documentation

Dokumen ini disiapkan untuk tahap final proyek. Isinya akan menjelaskan workflow GitHub Actions yang digunakan untuk membantu pengecekan otomatis repository.

## 1. Tujuan

GitHub Actions digunakan untuk menjalankan proses otomatis seperti install dependency, test, build asset frontend, dan pengecekan format kode saat ada perubahan pada repository.

## 2. Status Saat Ini

| Item | Keterangan |
| --- | --- |
| Status dokumen | Template final |
| Waktu pengisian | Saat final |
| Workflow aktif | Belum ada |
| Folder workflow | `.github/workflows/` |
| Status badge | Belum tersedia |
| Screenshot workflow | Belum tersedia |

## 3. Rencana Workflow

Workflow yang direkomendasikan untuk proyek Laravel Brainy:

| Workflow | Tujuan | Trigger |
| --- | --- | --- |
| Laravel Test | Install Composer dependency dan menjalankan test Laravel | Pull request dan push |
| Frontend Build | Install npm dependency dan menjalankan `npm run build` | Pull request dan push |
| Code Style | Menjalankan Laravel Pint | Pull request |

## 4. Contoh Struktur Workflow

File workflow nantinya dapat ditempatkan di:

```text
.github/workflows/laravel.yml
```

Contoh tahapan umum:

```yaml
name: Laravel CI

on:
  push:
    branches: [main, tiara]
  pull_request:
    branches: [main, tiara]

jobs:
  test:
    runs-on: ubuntu-latest

    steps:
      - name: Checkout repository
        uses: actions/checkout@v4

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'

      - name: Install Composer dependencies
        run: composer install --no-interaction --prefer-dist --optimize-autoloader

      - name: Copy environment file
        run: cp .env.example .env

      - name: Generate application key
        run: php artisan key:generate

      - name: Run tests
        run: php artisan test

      - name: Setup Node.js
        uses: actions/setup-node@v4
        with:
          node-version: '20'

      - name: Install npm dependencies
        run: npm install

      - name: Build frontend assets
        run: npm run build
```

Catatan: contoh di atas belum dibuat sebagai workflow aktif. Workflow final perlu disesuaikan dengan branch utama, kebutuhan database testing, dan standar tim.

## 5. Hasil Workflow

Karena workflow belum dibuat, belum ada hasil run GitHub Actions yang dapat dilampirkan. Saat final, bagian ini perlu diisi dengan:

- Screenshot status workflow dari tab Actions GitHub.
- Status badge pada README jika workflow sudah stabil.
- Catatan run terakhir, misalnya success atau failed.
- Ringkasan error jika workflow gagal.

Contoh badge yang dapat ditambahkan setelah workflow aktif:

```markdown
![Laravel CI](https://github.com/Theshadowozz/Ruang_Brainy/actions/workflows/laravel.yml/badge.svg)
```

## 6. Checklist Final

- Folder `.github/workflows/` tersedia.
- Workflow berjalan pada branch yang benar.
- Composer dependency berhasil diinstall.
- npm dependency berhasil diinstall.
- Test Laravel berhasil dijalankan.
- Build frontend berhasil dijalankan.
- Jika memakai database testing, konfigurasi environment CI sudah sesuai.
- Badge status workflow dapat ditambahkan ke README jika workflow sudah aktif.
