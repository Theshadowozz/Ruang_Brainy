# Dokumentasi Fitur Ruang Brainy

Sesuai dengan ketentuan dokumentasi proyek, berikut adalah rincian fitur yang tersedia pada aplikasi Ruang Brainy:

---

## 1. Autentikasi Multi-Level (Registrasi & Login)
**Tujuan fitur:**
Menyediakan sistem autentikasi multi-level (Admin, Tutor, dan Siswa) dengan hak akses yang berbeda untuk mengamankan sistem. Fitur ini memvalidasi username/email dan password pengguna. **Aktor:**
Siswa/Customer , Admin , Tutor **Alur fitur:**
User input data registrasi atau email & password login → sistem validasi kredensial → masuk ke dashboard sesuai hak akses (Siswa/Admin/Tutor) **Route / Controller terkait:**
`POST /login`
`POST /register`
(AuthController)

<img width="192" height="210" alt="image" src="https://github.com/user-attachments/assets/df785062-2e50-44ab-8b41-1fe0a7422ae0" />
<img width="190" height="166" alt="image" src="https://github.com/user-attachments/assets/e9ada6e1-5a98-4535-bbba-3afa7d3d91f0" />

---

## 2. Katalog dan Pencarian Kelas
**Tujuan fitur:**
Menampilkan katalog lengkap kursus bahasa (Inggris, Jepang, Korea) untuk semua jenjang usia dan menyediakan fitur filter kategori kursus berdasarkan bahasa dan metode belajar. **Aktor:**
Siswa/Customer **Alur fitur:**
Siswa buka website → lihat katalog kursus → melakukan pencarian dan memfilter kelas berdasarkan bahasa/metode → mengecek ketersediaan kelas **Route / Controller terkait:**
`GET /courses`
`GET /courses/search`
(CourseController)

<img width="352" height="210" alt="image" src="https://github.com/user-attachments/assets/2c7aeb2b-236b-4d70-99a5-8b9e4001ce91" />

---

## 3. Pendaftaran Kelas & Waiting List Otomatis
**Tujuan fitur:**
Memfasilitasi pendaftaran kursus online secara langsung di dalam platform dan menyediakan sistem *waiting list* otomatis apabila kuota kelas penuh. **Aktor:**
Siswa/Customer , Sistem Web Ruang Brainy **Alur fitur:**
Siswa mendaftar online mengisi formulir → sistem cek ketersediaan kuota kelas → jika kuota tersedia sistem menyimpan data pendaftaran dan mengirimkan notifikasi → jika kuota penuh, siswa dimasukkan ke *waiting list* **Route / Controller terkait:**
`POST /courses/{id}/enroll`
(EnrollmentController)

<img width="153" height="191" alt="image" src="https://github.com/user-attachments/assets/eebd78d6-399f-4aa9-9539-d51b1619e479" />


---

## 4. Pembayaran Online Terintegrasi
**Tujuan fitur:**
Menyediakan sistem pembayaran kursus digital yang terintegrasi dengan *payment gateway* (Midtrans/Xendit atau sejenisnya) di dalam platform untuk transaksi yang aman. **Aktor:**
Siswa/Customer , Sistem Web Ruang Brainy , Sistem Pembayaran **Alur fitur:**
Siswa terima invoice atau tagihan → pilih metode pembayaran → melakukan pembayaran dan diproses oleh sistem pembayaran → jika berhasil, sistem mengirimkan status pembayaran ke sistem web → sistem update status siswa aktif dan kirim notifikasi pembayaran berhasil **Route / Controller terkait:**
`POST /payment/checkout`
`POST /payment/callback`
(PaymentController)

*(Tambahkan screenshot halaman pembayaran / invoice di sini)*

---

## 5. Dashboard Admin (CMS & Monitoring)
**Tujuan fitur:**
Memungkinkan admin mengelola operasional dengan melakukan CRUD (Create, Read, Update, Delete) pada program kursus, data customer, jadwal, data tutor, testimoni, dan prestasi lembaga serta memonitor sistem melalui dashboard monitoring. **Aktor:**
Admin **Alur fitur:**
Admin login CMS → masuk ke *dashboard* monitoring → melakukan manajemen data (tambah/ubah/hapus kursus, customer, tutor, atau jadwal) → data langsung tampil di halaman publik **Route / Controller terkait:**
`Resource /admin/courses`
`Resource /admin/customers`
(AdminController / CourseController / CustomerController)

<img width="355" height="211" alt="image" src="https://github.com/user-attachments/assets/4d28ba8f-9bcd-4171-8398-dcebec0847e1" />

---

## 6. Laporan Keuangan & Riwayat Transaksi
**Tujuan fitur:**
Mengotomasi proses rekapitulasi data pembayaran dalam periode tertentu dan membuat Laporan Pembayaran/Keuangan untuk bahan evaluasi pemasukan , serta mengelola riwayat transaksi (tambah, lihat, hapus, rekap). **Aktor:**
Admin , Sistem Web **Alur fitur:**
Sistem mencatat transaksi masuk → rekap pembayaran → sistem membuat laporan pembayaran otomatis → Admin melihat riwayat transaksi dan memverifikasi laporan → Admin mengekspor Laporan Keuangan **Route / Controller terkait:**
`GET /admin/transactions`
`GET /admin/reports/export`
(TransactionController / ReportController)

<img width="355" height="212" alt="image" src="https://github.com/user-attachments/assets/944894de-574e-4ef2-84e2-df416eec8db8" />


---

## 7. Forum Diskusi Interaktif

**Tujuan fitur:** Menyediakan forum diskusi sebagai media komunikasi antara **admin, tutor, dan siswa/customer** untuk berdiskusi, bertanya, berbagi informasi, serta membahas materi pembelajaran maupun hal yang berkaitan dengan platform Brainy.

**Aktor:** Siswa/Customer, Tutor, Admin

**Alur fitur:** Buka menu **Forum Diskusi** di dashboard → pilih kategori forum (**Keluhan**, **Seputar Brainy**, atau **Pembelajaran**) → melihat atau membuat topik diskusi → pengguna lain memberikan balasan atau komentar → sistem menampilkan seluruh riwayat diskusi sesuai kategori.

**Fitur utama:**
- Membuat topik diskusi baru
- Membalas komentar pada topik diskusi
- Menampilkan seluruh diskusi berdasarkan kategori
- Menghapus topik atau komentar (Admin)
- Menampilkan riwayat diskusi

<img width="355" height="212" alt="image" src="https://github.com/user-attachments/assets/fb86dad1-6c15-4e3c-aa8e-852aae90f5ca" />


---

## 8. Audio Listening Interaktif
**Tujuan fitur:**
Mendukung pembelajaran bahasa dengan fitur pemutar audio *listening* interaktif yang dilengkapi tombol *play, pause, volume*, dan *repeat*. **Aktor:**
Siswa/Customer **Alur fitur:**
Siswa membuka halaman pembelajaran siswa → mengakses player audio listening → menggunakan tombol kontrol audio (play, pause, volume, repeat) **Route / Controller terkait:**
`GET /learning/materi/{id}`
(LearningController)

<img width="351" height="211" alt="image" src="https://github.com/user-attachments/assets/5a14c070-c923-48eb-8edc-5bb269ac52c6" />


---

## 9. Kuis Interaktif
**Tujuan fitur:**
Menyediakan sarana evaluasi siswa melalui kuis interaktif dengan sistem pengacakan (*random*) soal per sesi pengerjaan siswa. **Aktor:**
Siswa/Customer **Alur fitur:**
Siswa mengakses halaman pembelajaran → memulai sesi kuis dengan soal random → menjawab soal kuis → melihat hasil atau evaluasi kuis **Route / Controller terkait:**
`GET /quiz/{id}`
`POST /quiz/{id}/submit`
(QuizController)

<img width="355" height="212" alt="image" src="https://github.com/user-attachments/assets/dc221d16-564b-4ce6-83c3-1004b0bd8d2f" />

---

## 10. Integrasi Lokasi & Kontak (Hubungi Kami)
**Tujuan fitur:**
Menyajikan halaman Hubungi Kami yang berisi nomor kontak, alamat (Jl. Alai Parak Kopi), jam operasional, dan media sosial dengan *embed* Google Maps yang interaktif untuk menunjukkan lokasi fisik Brainy Course. **Aktor:**
Publik, Siswa/Customer **Alur fitur:**
User membuka navbar atau halaman Hubungi Kami → melihat informasi kontak, alamat, jam operasional → berinteraksi dengan widget Google Maps interaktif **Route / Controller terkait:**
`GET /contact`
(ContactController)

<img width="355" height="212" alt="image" src="https://github.com/user-attachments/assets/e2e2f1d1-2033-43c0-a262-3c01e501c20c" />

