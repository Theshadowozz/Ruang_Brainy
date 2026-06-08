# Dependency Documentation

Dokumen ini mencatat dependency yang digunakan dan dependency yang direncanakan untuk proyek Brainy. Tujuannya agar tim dapat memahami fungsi setiap package, alasan penggunaan, dan status integrasinya.

## 1. Ringkasan Dependency Aktual

Format tabel mengikuti modul dokumentasi: package, fungsi, alasan, versi, dan risiko.

| Package | Fungsi | Alasan | Versi | Risiko |
| --- | --- | --- | --- | --- |
| PHP | Runtime backend | Menjalankan Laravel 12 | `^8.2` | Perbedaan versi PHP lokal dapat menyebabkan error compatibility |
| Laravel Framework | Framework utama | Menyediakan routing, migration, ORM, validation, dan struktur MVC | `^12.0` | Upgrade major version dapat mengubah API/framework behavior |
| Laravel Tinker | Console interaktif Laravel | Membantu inspeksi model/data saat development | `^2.10.1` | Risiko rendah, hanya development/helper |
| Faker | Data dummy | Membantu factory, seeder, dan testing | `^1.23` | Data dummy tidak boleh dipakai sebagai data production |
| Laravel Boost | Tool bantuan development Laravel | Membantu produktivitas development | `2.0` | Perlu mengikuti kompatibilitas Laravel |
| Laravel Pail | Monitoring log | Membantu membaca log secara real-time | `^1.2.2` | Risiko rendah, development only |
| Laravel Pint | Code formatter | Menjaga format kode konsisten | `^1.24` | Perubahan format dapat membuat diff besar |
| Laravel Sail | Docker development environment | Alternatif setup lokal berbasis container | `^1.41` | Butuh Docker dan konfigurasi tambahan |
| Mockery | Mocking untuk test | Membantu unit/integration test | `^1.6` | Test bisa sulit dibaca jika mock berlebihan |
| Collision | Tampilan error CLI | Membantu debugging saat test/command gagal | `^8.6` | Risiko rendah, development only |
| Pest | Framework testing | Menjalankan test PHP dengan sintaks ringkas | `^3.8` | Tim perlu menyepakati gaya penulisan test |
| Pest Laravel Plugin | Integrasi Pest dan Laravel | Memudahkan testing fitur Laravel | `^3.2` | Mengikuti kompatibilitas Pest dan Laravel |
| Vite | Build tool frontend | Menjalankan dev server dan build asset | `^7.0.7` | Perlu Node.js yang kompatibel |
| Laravel Vite Plugin | Integrasi Laravel dan Vite | Menghubungkan asset Vite ke Blade/Laravel | `^2.0.0` | Konfigurasi salah dapat membuat asset tidak tampil |
| Tailwind CSS | Styling utility | Mempercepat pembuatan UI konsisten | `^4.0.0` | Perubahan versi major dapat memengaruhi class/config |
| Tailwind Vite Plugin | Integrasi Tailwind dengan Vite | Memproses Tailwind melalui Vite | `^4.0.0` | Perlu konfigurasi Vite yang sesuai |
| Axios | HTTP client frontend | Memudahkan request API dari frontend | `^1.11.0` | Perlu handling error dan CSRF dengan benar |
| Concurrently | Menjalankan command paralel | Mendukung script development multi-process | `^9.0.1` | Log development bisa lebih ramai |

## 2. Cara Install Dependency Aktual

Backend:

```bash
composer install
```

Frontend:

```bash
npm install
```

Jika dependency baru ditambahkan, gunakan command sesuai jenis package:

```bash
composer require nama/package
npm install nama-package
```

## 3. Dependency Backend Aktual

Dependency berikut tercatat pada `composer.json`.

### PHP

| Field | Detail |
| --- | --- |
| What | Runtime backend untuk menjalankan Laravel |
| Why | Laravel 12 membutuhkan PHP modern |
| Version | `^8.2` |
| Where | Seluruh aplikasi backend |

### Laravel Framework

| Field | Detail |
| --- | --- |
| What | Framework utama aplikasi |
| Why | Menyediakan routing, MVC, migration, ORM, validation, queue, storage, dan fitur web app lain |
| Version | `^12.0` |
| Where | Backend aplikasi Brainy |

### Laravel Tinker

| Field | Detail |
| --- | --- |
| What | REPL/console interaktif Laravel |
| Why | Membantu developer melakukan inspeksi model, query, dan data selama development |
| Version | `^2.10.1` |
| Where | Development backend |

## 4. Dependency Backend Development

| Dependency | Fungsi | Status |
| --- | --- | --- |
| `fakerphp/faker` | Membuat data dummy untuk factory/seeder/testing | Digunakan |
| `laravel/boost` | Tool bantuan development Laravel | Digunakan |
| `laravel/pail` | Melihat log Laravel secara interaktif | Digunakan |
| `laravel/pint` | Format kode PHP sesuai standar Laravel | Digunakan |
| `laravel/sail` | Environment development berbasis Docker | Opsional |
| `mockery/mockery` | Mocking object untuk test | Digunakan |
| `nunomaduro/collision` | Tampilan error CLI yang lebih jelas | Digunakan |
| `pestphp/pest` | Framework testing PHP | Digunakan |
| `pestphp/pest-plugin-laravel` | Integrasi Pest dengan Laravel | Digunakan |

## 5. Dependency Frontend Aktual

Dependency berikut tercatat pada `package.json`.

| Dependency | Fungsi | Status |
| --- | --- | --- |
| `vite` | Build tool dan development server frontend | Digunakan |
| `laravel-vite-plugin` | Integrasi Vite dengan Laravel Blade | Digunakan |
| `tailwindcss` | Utility-first CSS framework | Digunakan |
| `@tailwindcss/vite` | Integrasi Tailwind CSS dengan Vite | Digunakan |
| `axios` | HTTP client untuk request dari frontend | Digunakan |
| `concurrently` | Menjalankan beberapa command development bersamaan | Digunakan |

## 6. Dependency Rencana/Opsional

Dependency berikut belum tercatat pada `composer.json` atau `package.json` saat dokumen ini dibuat. Package hanya perlu diinstall jika fitur terkait sudah masuk tahap implementasi.

| Package | Fungsi | Alasan | Versi | Risiko |
| --- | --- | --- | --- | --- |
| Laravel Breeze | Auth scaffolding | Mempercepat login/register/reset password | Sesuai kompatibilitas Laravel 12 | Perlu penyesuaian UI dan role |
| Spatie Laravel Permission | Role dan permission | Mengatur akses admin, tutor, dan student | Versi stabil terbaru | Konfigurasi role salah dapat membuka akses tidak sesuai |
| Laravel DomPDF | Generate PDF | Invoice pembayaran/laporan transaksi | Versi stabil terbaru | Rendering PDF bisa berbeda dari HTML biasa |
| Midtrans | Payment gateway | Memproses pembayaran online | Sesuai SDK/API yang dipilih | Perlu keamanan transaksi dan konfigurasi sandbox/production |
| Translate API | Layanan translate | Mendukung fitur terjemahan | Sesuai provider | Biaya API, limit request, dan dependency eksternal |

### Laravel Breeze

| Field | Detail |
| --- | --- |
| What | Starter kit autentikasi Laravel |
| Why | Mempercepat pembuatan login, register, reset password, dan session |
| Who | Student, tutor, admin, developer |
| When | Saat modul autentikasi mulai diimplementasikan |
| Where | Auth pages, middleware, dashboard role |
| How | `composer require laravel/breeze --dev` lalu `php artisan breeze:install` |

### Spatie Laravel Permission

| Field | Detail |
| --- | --- |
| What | Package role dan permission |
| Why | Mengatur akses admin, tutor, dan student |
| Who | Semua role pengguna |
| When | Setelah autentikasi dasar tersedia |
| Where | Middleware, policy, dashboard, menu role |
| How | `composer require spatie/laravel-permission` |

### Laravel DomPDF

| Field | Detail |
| --- | --- |
| What | Generator PDF untuk Laravel |
| Why | Membuat invoice pembayaran atau laporan transaksi |
| Who | Admin dan student |
| When | Saat fitur invoice/laporan pembayaran dibuat |
| Where | Modul payment dan laporan admin |
| How | `composer require barryvdh/laravel-dompdf` |

### Midtrans Payment Gateway

| Field | Detail |
| --- | --- |
| What | Payment gateway untuk transaksi online |
| Why | Memproses pembayaran kelas secara digital |
| Who | Student dan admin |
| When | Saat fitur pembayaran online diimplementasikan |
| Where | Modul payment |
| How | Integrasi API Midtrans atau package resmi/komunitas sesuai keputusan tim |

### Translate API

| Field | Detail |
| --- | --- |
| What | Layanan penerjemahan pihak ketiga |
| Why | Mendukung fitur translate pada aplikasi pembelajaran |
| Who | Student dan tutor |
| When | Saat fitur translate masuk implementasi |
| Where | Modul learning tools |
| How | Laravel HTTP Client mengirim request ke API translate yang dipilih |

## 7. Dampak pada Proyek

- Dependency backend menambah kemampuan Laravel untuk routing, database, testing, dan development.
- Dependency frontend mendukung build asset, styling, dan komunikasi HTTP.
- Dependency development membantu kualitas kode, tetapi tidak boleh membuat setup lokal menjadi tidak jelas.
- Dependency rencana dapat menambah fitur, tetapi juga menambah ukuran dependency, konfigurasi, dan risiko update versi.
- Integrasi payment dan translate membutuhkan pengelolaan credential yang aman melalui `.env`.

## 8. Aturan Pengelolaan Dependency

- Dependency baru harus dicatat di dokumen ini.
- Dependency hanya ditambahkan jika benar-benar digunakan oleh fitur.
- Setelah menambahkan Composer dependency, jalankan `composer install` atau `composer update` sesuai kebutuhan tim.
- Setelah menambahkan npm dependency, jalankan `npm install`.
- Perubahan pada `composer.lock`, `package-lock.json`, atau lockfile lain harus ikut dicommit jika berubah.
- Dependency rencana tidak dianggap terpasang sampai tercatat di file konfigurasi package.

## 9. Checklist Review Dependency

- Dependency aktual sesuai dengan `composer.json`.
- Dependency frontend sesuai dengan `package.json`.
- Dependency rencana diberi status rencana/opsional.
- Alasan penggunaan setiap package jelas.
- Tidak ada package yang dicatat sebagai digunakan padahal belum terinstall.
