# Refactoring Documentation Ruang Brainy

Dokumentasi ini dibuat sesuai ketentuan modul Praktikum Konstruksi dan Evolusi Perangkat Lunak. Bagian refactoring menjelaskan perubahan struktur kode yang dilakukan untuk membuat proyek Laravel Ruang Brainy lebih mudah dipelihara, lebih konsisten, dan lebih siap dikembangkan oleh tim.

Format yang digunakan untuk setiap refactoring:

- **Sebelum**
- **Masalah**
- **Perubahan**
- **Alasan**
- **Dampak**

---

## 1. Standarisasi Role User

**File terkait:**

- `app/Models/User.php`
- `app/Http/Middleware/CheckRole.php`
- `app/Http/Controllers/AuthController.php`
- `database/migrations/2026_06_09_000000_change_users_role_to_numeric_code.php`

### Sebelum

Role pengguna masih berpotensi ditangani menggunakan nilai teks seperti `admin`, `siswa`, dan `tutor` di beberapa bagian sistem.

### Masalah

Penggunaan role berbasis teks membuat validasi akses rawan tidak konsisten. Jika ada perbedaan penulisan, perubahan nama role, atau pengecekan role yang tersebar di banyak file, sistem autentikasi dan otorisasi menjadi lebih sulit dipelihara.

### Perubahan

Role pengguna distandarkan menjadi kode numerik:

| Role | Kode |
|---|---:|
| Admin | 1 |
| Siswa | 2 |
| Tutor | 3 |

Model `User` menambahkan konstanta:

- `ROLE_ADMIN`
- `ROLE_SISWA`
- `ROLE_TUTOR`

Model juga menyediakan helper:

- `isAdmin()`
- `isSiswa()`
- `isTutor()`

Middleware `CheckRole` melakukan validasi role dengan membandingkan nilai role user terhadap daftar role yang diperbolehkan.

### Alasan

Standarisasi role memudahkan pengelolaan hak akses dan mengurangi duplikasi pengecekan role di controller atau route.

### Dampak

- Akses halaman admin, tutor, dan siswa lebih terkontrol.
- Redirect dashboard berdasarkan role menjadi lebih jelas.
- Perubahan aturan role di masa depan cukup mengikuti konstanta dan middleware yang sudah tersedia.

---

## 2. Pemisahan Layout Blade Berdasarkan Role

**File terkait:**

- `resources/views/layouts/admin.blade.php`
- `resources/views/layouts/siswa.blade.php`
- `resources/views/layouts/tutor.blade.php`
- `resources/views/admin/dashboard.blade.php`
- `resources/views/siswa/dashboard.blade.php`
- `resources/views/tutor/dashboard.blade.php`

### Sebelum

Struktur tampilan berpotensi ditulis berulang pada setiap halaman, seperti header, sidebar, navigasi, footer, script global, dan style dasar.

### Masalah

Duplikasi struktur tampilan membuat perubahan UI menjadi tidak efisien. Contohnya, jika menu admin atau script global berubah, developer harus mengubah banyak file halaman satu per satu.

### Perubahan

Layout dipisahkan berdasarkan role:

- `layouts.admin` untuk halaman admin.
- `layouts.siswa` untuk halaman siswa.
- `layouts.tutor` untuk halaman tutor.

Halaman seperti `admin/dashboard.blade.php` cukup menggunakan:

```blade
@extends('layouts.admin')
@section('content')
```

Konten halaman diletakkan pada section, sedangkan struktur umum tetap berada di file layout.

### Alasan

Pemisahan layout membuat kode Blade lebih rapi dan mengurangi pengulangan komponen UI yang sama.

### Dampak

- Halaman admin, siswa, dan tutor memiliki struktur yang konsisten.
- Perubahan menu, header, dan footer lebih mudah dilakukan.
- File halaman menjadi lebih fokus pada isi fitur masing-masing.

---

## 3. Pemisahan Controller Fitur Siswa

**File terkait:**

- `app/Http/Controllers/Siswa/SiswaDashboardController.php`
- `app/Http/Controllers/Siswa/SiswaAudioController.php`
- `app/Http/Controllers/Siswa/SiswaCourseController.php`
- `app/Http/Controllers/Siswa/SiswaQuizController.php`
- `app/Http/Controllers/Siswa/SiswaScheduleController.php`
- `app/Http/Controllers/Siswa/SiswaTranslateController.php`
- `routes/web.php`

### Sebelum

Fitur siswa dapat menumpuk di satu controller besar atau langsung ditangani di route, misalnya dashboard, audio, jadwal, kuis, kelas kursus, dan translate.

### Masalah

Controller yang terlalu besar sulit dibaca, sulit diuji, dan sulit dikembangkan. Ketika semua logic berada di satu tempat, perubahan satu fitur dapat mengganggu fitur lain.

### Perubahan

Fitur siswa dipisahkan ke controller berdasarkan tanggung jawab:

| Controller | Tanggung jawab |
|---|---|
| `SiswaDashboardController` | Menampilkan ringkasan dashboard siswa |
| `SiswaAudioController` | Menampilkan audio, download audio, dan menandai audio sudah didengar |
| `SiswaCourseController` | Menampilkan daftar dan detail kelas kursus |
| `SiswaQuizController` | Menampilkan kuis dan menyimpan jawaban siswa |
| `SiswaScheduleController` | Menampilkan jadwal siswa |
| `SiswaTranslateController` | Menangani fitur translate |

### Alasan

Pemisahan controller mengikuti prinsip single responsibility, yaitu satu class memiliki satu fokus tanggung jawab.

### Dampak

- Struktur controller lebih mudah dipahami.
- Pengembangan fitur siswa dapat dilakukan tanpa mengganggu fitur lain.
- Route menjadi lebih jelas karena mengarah ke controller yang spesifik.

---

## 4. Pemakaian Partial Blade untuk Tombol Kembali

**File terkait:**

- `resources/views/siswa/partials/back-button.blade.php`
- Beberapa halaman pada folder `resources/views/siswa/`

### Sebelum

Tombol kembali pada halaman siswa berpotensi dibuat berulang langsung di setiap file Blade.

### Masalah

Duplikasi markup tombol membuat tampilan rawan tidak konsisten. Jika desain tombol berubah, setiap halaman harus diperbarui satu per satu.

### Perubahan

Tombol kembali dipindahkan ke partial:

```blade
resources/views/siswa/partials/back-button.blade.php
```

Partial tersebut menerima fallback route dan dapat digunakan ulang pada halaman siswa.

### Alasan

Komponen yang sering dipakai sebaiknya dipisahkan agar mudah digunakan kembali.

### Dampak

- Tampilan tombol kembali lebih konsisten.
- Perubahan desain tombol cukup dilakukan di satu file partial.
- File halaman siswa menjadi lebih ringkas.

---

## 5. Refactoring Forum Diskusi untuk Multi-Role

**File terkait:**

- `app/Http/Controllers/DiscussionController.php`
- `resources/views/discussions/index.blade.php`
- `resources/views/discussions/partials/topics.blade.php`
- `routes/web.php`

### Sebelum

Forum diskusi berpotensi dibuat terpisah untuk setiap role, misalnya halaman diskusi admin, siswa, dan tutor dengan logic yang sama.

### Masalah

Jika logic forum dibuat terpisah per role, akan terjadi duplikasi query, validasi kategori, penyimpanan topik, dan penyimpanan pesan.

### Perubahan

Logic forum dipusatkan pada `DiscussionController`. Controller menentukan layout dan prefix route berdasarkan role user melalui helper internal:

- `layoutFor()`
- `rolePrefix()`
- `validCategory()`

View daftar topik dipisahkan ke partial `discussions.partials.topics` agar dapat digunakan untuk render halaman normal maupun response live berupa JSON.

### Alasan

Forum diskusi digunakan oleh admin, tutor, dan siswa, sehingga logic yang sama lebih baik dikelola pada satu controller.

### Dampak

- Logic forum lebih reusable.
- Tampilan forum dapat menyesuaikan layout role user.
- Update topik diskusi dapat dilakukan melalui partial yang sama.

---

## 6. Perapian Route dan Proteksi Akses

**File terkait:**

- `routes/web.php`
- `app/Http/Middleware/CheckRole.php`
- `app/Http/Controllers/AuthController.php`

### Sebelum

Route aplikasi berpotensi bercampur antara halaman publik, halaman guest, halaman auth, dan halaman berbasis role.

### Masalah

Route yang tidak dikelompokkan dengan jelas membuat alur akses sulit dibaca. Risiko lainnya adalah halaman khusus role dapat terbuka oleh user yang tidak sesuai.

### Perubahan

Route dikelompokkan berdasarkan kebutuhan akses:

- `guest` untuk login dan register.
- `auth` untuk halaman yang membutuhkan login.
- `role:1` untuk fitur admin.
- `role:2` untuk fitur siswa.
- `role:3` untuk fitur tutor.

Beberapa route kompatibilitas juga disediakan untuk redirect nama URL lama ke route baru, seperti:

- `/admin/waitlist` ke `/admin/waitinglist`
- `/admin/tutor` ke `/admin/tutors`
- `/admin/siswa` ke `/admin/students`

### Alasan

Pengelompokan route membantu developer memahami batas akses setiap fitur dan menjaga keamanan navigasi aplikasi.

### Dampak

- Struktur route lebih mudah dibaca.
- Proteksi akses role lebih jelas.
- URL lama tetap dapat diarahkan ke halaman yang benar.

---

## 7. Pemisahan Dokumentasi Proyek ke Folder Docs

**File terkait:**

- `README.md`
- `changelog.md`
- `docs/installation.md`
- `docs/features.md`
- `docs/dependency.md`
- `docs/refactoring.md`
- `docs/github-actions.md`

### Sebelum

Informasi teknis proyek berpotensi hanya berada di README atau tersebar tanpa struktur dokumentasi yang jelas.

### Masalah

README yang terlalu panjang akan sulit dibaca. Dokumentasi instalasi, fitur, dependency, CI, dan refactoring memiliki tujuan yang berbeda sehingga sebaiknya dipisahkan.

### Perubahan

Dokumentasi proyek dipisahkan ke folder `docs/` sesuai ketentuan modul:

- `installation.md` untuk panduan instalasi.
- `features.md` untuk dokumentasi fitur.
- `dependency.md` untuk daftar dependency.
- `refactoring.md` untuk dokumentasi refactoring.
- `github-actions.md` untuk dokumentasi workflow CI.

### Alasan

Struktur dokumentasi yang terpisah membuat repository lebih profesional dan mudah dinavigasi.

### Dampak

- Developer baru lebih mudah memahami proyek.
- Dokumentasi memenuhi ketentuan tugas PBL.
- Setiap dokumen memiliki fokus pembahasan yang jelas.

---

## Ringkasan Dampak Refactoring

Refactoring yang dilakukan pada proyek Ruang Brainy memberikan beberapa dampak utama:

- Struktur kode lebih modular.
- Hak akses user lebih konsisten.
- Tampilan Blade lebih mudah dirawat.
- Controller lebih fokus pada fitur masing-masing.
- Route lebih mudah dibaca dan diamankan.
- Dokumentasi proyek lebih sesuai standar repository GitHub.

## Catatan Lanjutan

Beberapa peningkatan refactoring yang masih dapat dilakukan pada pengembangan berikutnya:

- Memindahkan inline model pada `SiswaDashboardController` menjadi model Eloquent terpisah di folder `app/Models`.
- Merapikan duplikasi route admin pada `routes/web.php`.
- Memindahkan data dummy `localStorage` pada layout admin ke file JavaScript atau service tersendiri.
- Menambahkan test untuk middleware role, login redirect, dan fitur utama siswa.
