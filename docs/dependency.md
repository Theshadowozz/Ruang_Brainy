
# Identifikasi Dependency/Package Laravel untuk Proyek PBL Brainy

## Deskripsi Proyek

Brainy adalah platform kursus bahasa asing berbasis web dengan fitur:

- Autentikasi multi-role (admin, tutor, siswa)
- Pendaftaran kelas online
- Jadwal kelas fleksibel
- Waiting list
- Pembayaran
- Audio listening
- Quiz singkat
- Translate
- Profile tutor
- Dashboard admin

---

## 1. Laravel Breeze

**Referensi:** https://laravel.com/docs/starter-kits#laravel-breeze

| Field   | Detail |
|---------|--------|
| **What** | Laravel Breeze |
| **Why** | Digunakan untuk menyediakan sistem autentikasi dasar seperti login, register, logout, reset password, dan manajemen session. |
| **Who** | Admin, Tutor, Siswa, Developer |
| **When** | Digunakan saat user melakukan login atau register. |
| **Where** | Modul autentikasi, Halaman login, Halaman register |
| **How** | Diinstall menggunakan Composer dan digunakan untuk membuat sistem autentikasi bawaan Laravel. |

**Command:**

```bash
composer require laravel/breeze --dev
php artisan breeze:install
npm install
npm run build
```

---

## 2. Spatie Laravel Permission

**Referensi:** https://spatie.be/docs/laravel-permission

| Field   | Detail |
|---------|--------|
| **What** | Spatie Laravel Permission |
| **Why** | Digunakan untuk mengatur hak akses berdasarkan role seperti admin, tutor, dan siswa. |
| **Who** | Admin, Tutor, Siswa, Developer |
| **When** | Digunakan setelah user login untuk menentukan dashboard dan fitur yang dapat diakses. |
| **Where** | Middleware, Dashboard admin, Dashboard tutor, Dashboard siswa |
| **How** | Package diinstall menggunakan Composer lalu role diberikan pada user melalui model User. |

**Command:**

```bash
composer require spatie/laravel-permission
```

---

## 3. Laravel DomPDF

**Referensi:** https://github.com/barryvdh/laravel-dompdf

| Field   | Detail |
|---------|--------|
| **What** | Laravel DomPDF |
| **Why** | Digunakan untuk generate invoice pembayaran atau laporan transaksi dalam format PDF. |
| **Who** | Admin, Siswa |
| **When** | Saat siswa ingin melihat invoice pembayaran atau admin ingin mencetak laporan. |
| **Where** | Modul pembayaran, Dashboard admin |
| **How** | Diintegrasikan ke controller payment untuk membuat file PDF. |

**Command:**

```bash
composer require barryvdh/laravel-dompdf
```

---

## 4. Laravel Filesystem Storage

**Referensi:** https://laravel.com/docs/filesystem

| Field   | Detail |
|---------|--------|
| **What** | Laravel Filesystem Storage |
| **Why** | Digunakan untuk menyimpan file upload seperti foto tutor, audio listening, dan bukti pembayaran. |
| **Who** | Admin, Tutor, Siswa |
| **When** | Saat user upload file ke sistem. |
| **Where** | Profile tutor, Payment, Learning center |
| **How** | Menggunakan storage bawaan Laravel untuk menyimpan file ke folder public storage. |

> Built-in Laravel — tidak memerlukan instalasi tambahan.

---

## 5. Laravel HTTP Client

**Referensi:** https://laravel.com/docs/http-client

| Field   | Detail |
|---------|--------|
| **What** | Laravel HTTP Client |
| **Why** | Digunakan untuk menghubungkan Laravel dengan API pihak ketiga seperti translate API atau payment gateway. |
| **Who** | Developer, User aplikasi |
| **When** | Saat sistem perlu request data dari layanan eksternal. |
| **Where** | Modul translate, Modul payment |
| **How** | Menggunakan Http facade bawaan Laravel. |

**Contoh penggunaan:**

```php
Http::get('https://api.example.com/endpoint');
```

> Built-in Laravel — tidak memerlukan instalasi tambahan.

---

## 6. Google Translate API

**Referensi:** https://cloud.google.com/translate

| Field   | Detail |
|---------|--------|
| **What** | Google Translate API |
| **Why** | Digunakan untuk fitur translate kata atau kalimat dalam sistem. |
| **Who** | Siswa, Tutor |
| **When** | Saat user menggunakan fitur translate. |
| **Where** | Dashboard siswa, Learning center |
| **How** | Laravel mengirim request ke Google Translate API lalu menampilkan hasil terjemahan. |

---

## 7. Midtrans Payment Gateway

**Referensi:** https://docs.midtrans.com/

| Field   | Detail |
|---------|--------|
| **What** | Midtrans Payment Gateway |
| **Why** | Digunakan untuk memproses pembayaran kursus secara online. |
| **Who** | Siswa, Admin |
| **When** | Saat siswa melakukan pembayaran kelas. |
| **Where** | Modul pembayaran |
| **How** | Diintegrasikan ke Laravel menggunakan API Midtrans untuk memproses transaksi pembayaran. |
>>>>>>> 7c6cc12e0f9a61c3121e884ec81cc2bec0d228b4
