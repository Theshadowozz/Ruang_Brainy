# Brainy - Foreign Language Learning Platform

Brainy adalah platform kursus bahasa asing berbasis web yang dikembangkan untuk kebutuhan Project Based Learning (PBL). Sistem ini dirancang untuk membantu proses pendaftaran kelas, pengelolaan jadwal, waiting list, pembayaran, dan aktivitas belajar bahasa asing secara terpusat.

## Ringkasan Proyek

| Item | Keterangan |
| --- | --- |
| Nama aplikasi | Brainy |
| Jenis aplikasi | Platform kursus bahasa asing berbasis web |
| Framework | Laravel 12 |
| Bahasa backend | PHP 8.2+ |
| Frontend build tool | Vite |
| Database | MySQL/MariaDB |
| Repository | https://github.com/Theshadowozz/Ruang_Brainy |
| Status | Dalam pengembangan |

## Tujuan

Tujuan utama Brainy adalah menyediakan sistem digital yang memudahkan pengelolaan kursus bahasa asing, mulai dari pengguna memilih kelas sampai admin memantau data kelas, jadwal, pendaftaran, waiting list, dan pembayaran.

## Masalah yang Diselesaikan

Brainy membantu mengurangi pencatatan manual pada proses kursus bahasa, terutama untuk data kelas, jadwal, kapasitas kelas, pendaftaran peserta, antrean waiting list, dan status pembayaran.

## Target Pengguna

- Student yang ingin mendaftar dan mengikuti kursus bahasa.
- Tutor yang mengajar kelas bahasa.
- Admin yang mengelola operasional kursus.

## Cakupan Awal

Dokumentasi ini mengikuti kebutuhan dokumentasi proyek PBL:

- README sebagai dokumentasi utama proyek.
- Installation Documentation untuk panduan instalasi lokal.
- Dependency Documentation untuk mencatat dependency yang digunakan dan direncanakan.
- CHANGELOG untuk mencatat perkembangan implementasi secara berkala.
- Refactoring Documentation sebagai catatan final perbaikan kode.
- GitHub Actions Documentation sebagai catatan final CI/CD.

Feature Documentation tidak diperbarui pada tahap ini karena analisis kebutuhan ditargetkan selesai pada minggu ke-14.

## Fitur Utama

Fitur berikut merupakan rancangan utama aplikasi berdasarkan kebutuhan awal dan struktur database yang sudah tersedia:

- Multi-role authentication untuk admin, tutor, dan student.
- Manajemen tutor.
- Manajemen kelas bahasa.
- Manajemen jadwal kelas.
- Pendaftaran kelas online.
- Waiting list ketika kapasitas kelas penuh.
- Manajemen pembayaran.
- Monitoring status pendaftaran dan pembayaran.

## Bahasa yang Didukung

Berdasarkan rancangan database saat ini, kelas dapat dibuat untuk:

- Inggris
- Jepang
- Korea

## Role Pengguna

### Student

Student adalah pengguna yang mendaftar kelas, memilih jadwal, melakukan pembayaran, dan mengakses materi pembelajaran ketika modul pembelajaran sudah tersedia.

### Tutor

Tutor adalah pengajar yang memiliki data profil, keahlian bahasa, dan relasi dengan kelas yang diajar.

### Admin

Admin bertanggung jawab mengelola data tutor, kelas, jadwal, registrasi, waiting list, pembayaran, serta monitoring aktivitas sistem.

## Modul Data Saat Ini

Struktur database awal sudah mencakup:

- `users`: data akun pengguna.
- `tutors`: data tutor dan keahlian.
- `classes`: data kelas, bahasa, level, tutor, harga, dan deskripsi.
- `schedules`: jadwal kelas, ruangan, dan kapasitas.
- `registrations`: data pendaftaran kelas.
- `waiting_lists`: data antrean ketika kelas penuh.
- `payments`: data pembayaran dan status transaksi.

## Tech Stack

- Laravel 12
- PHP 8.2+
- Composer
- MySQL atau MariaDB
- Blade
- Vite
- Tailwind CSS
- Node.js dan npm
- Git dan GitHub

## Instalasi Cepat

Dokumentasi instalasi lengkap tersedia di [docs/installation.md](docs/installation.md).

```bash
git clone https://github.com/Theshadowozz/Ruang_Brainy.git
cd Ruang_Brainy
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Untuk menjalankan frontend development server:

```bash
npm run dev
```

Untuk build asset production:

```bash
npm run build
```

## Struktur Dokumentasi

| Dokumen | Lokasi | Status |
| --- | --- | --- |
| README | `README.md` | Disiapkan untuk target minggu depan |
| Installation Documentation | `docs/installation.md` | Disiapkan untuk target minggu depan |
| Feature Documentation | `docs/features.md` | Belum diisi, menunggu analisis kebutuhan minggu ke-14 |
| Changelog | `CHANGELOG.md` | Berjalan dan diupdate berkala |
| Dependency Documentation | `docs/dependency.md` | Dirapikan untuk tugas dokumentasi |
| Refactoring Documentation | `docs/refactoring.md` | Template final |
| GitHub Actions Documentation | `docs/github-actions.md` | Template final |

## Status Implementasi

Saat dokumentasi ini diperbarui, proyek masih berada pada tahap setup Laravel, struktur database awal, dan penyusunan dokumentasi proyek. Route utama masih menggunakan halaman default Laravel.

## Screenshot Proyek

Screenshot belum tersedia karena implementasi halaman login, dashboard, dan fitur utama belum selesai. Screenshot perlu ditambahkan setelah halaman berikut tersedia:

- Halaman login.
- Dashboard admin/student/tutor.
- Halaman pendaftaran kelas atau fitur utama lain.

Format penyimpanan yang disarankan:

```text
docs/screenshots/login.png
docs/screenshots/dashboard.png
docs/screenshots/main-feature.png
```

## Tim Pengembang

Isi bagian ini dengan nama anggota kelompok:

| Nama | Peran |
| --- | --- |
| Nama anggota 1 | Developer |
| Nama anggota 2 | Developer |
| Nama anggota 3 | Developer |

## Kontribusi Tim

Setiap perubahan fitur, dependency, refactoring, dan workflow GitHub Actions perlu dicatat pada dokumen terkait agar progres proyek mudah diperiksa setiap minggu.
