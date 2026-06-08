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

**Screenshot fitur:**
*(Tambahkan screenshot halaman login/register di sini)*

---

## 2. Katalog dan Pencarian Kelas
**Tujuan fitur:**
Menampilkan katalog lengkap kursus bahasa (Inggris, Jepang, Korea) untuk semua jenjang usia dan menyediakan fitur filter kategori kursus berdasarkan bahasa dan metode belajar. **Aktor:**
Siswa/Customer **Alur fitur:**
Siswa buka website → lihat katalog kursus → melakukan pencarian dan memfilter kelas berdasarkan bahasa/metode → mengecek ketersediaan kelas **Route / Controller terkait:**
`GET /courses`
`GET /courses/search`
(CourseController)

**Screenshot fitur:**
*(Tambahkan screenshot halaman katalog kursus di sini)*

---

## 3. Pendaftaran Kelas & Waiting List Otomatis
**Tujuan fitur:**
Memfasilitasi pendaftaran kursus online secara langsung di dalam platform dan menyediakan sistem *waiting list* otomatis apabila kuota kelas penuh. **Aktor:**
Siswa/Customer , Sistem Web Ruang Brainy **Alur fitur:**
Siswa mendaftar online mengisi formulir → sistem cek ketersediaan kuota kelas → jika kuota tersedia sistem menyimpan data pendaftaran dan mengirimkan notifikasi → jika kuota penuh, siswa dimasukkan ke *waiting list* **Route / Controller terkait:**
`POST /courses/{id}/enroll`
(EnrollmentController)

**Screenshot fitur:**
*(Tambahkan screenshot formulir pendaftaran di sini)*

---

## 4. Pembayaran Online Terintegrasi
**Tujuan fitur:**
Menyediakan sistem pembayaran kursus digital yang terintegrasi dengan *payment gateway* (Midtrans/Xendit atau sejenisnya) di dalam platform untuk transaksi yang aman. **Aktor:**
Siswa/Customer , Sistem Web Ruang Brainy , Sistem Pembayaran **Alur fitur:**
Siswa terima invoice atau tagihan → pilih metode pembayaran → melakukan pembayaran dan diproses oleh sistem pembayaran → jika berhasil, sistem mengirimkan status pembayaran ke sistem web → sistem update status siswa aktif dan kirim notifikasi pembayaran berhasil **Route / Controller terkait:**
`POST /payment/checkout`
`POST /payment/callback`
(PaymentController)

**Screenshot fitur:**
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

**Screenshot fitur:**
*(Tambahkan screenshot halaman dashboard admin di sini)*

---

## 6. Laporan Keuangan & Riwayat Transaksi
**Tujuan fitur:**
Mengotomasi proses rekapitulasi data pembayaran dalam periode tertentu dan membuat Laporan Pembayaran/Keuangan untuk bahan evaluasi pemasukan , serta mengelola riwayat transaksi (tambah, lihat, hapus, rekap). **Aktor:**
Admin , Sistem Web **Alur fitur:**
Sistem mencatat transaksi masuk → rekap pembayaran → sistem membuat laporan pembayaran otomatis → Admin melihat riwayat transaksi dan memverifikasi laporan → Admin mengekspor Laporan Keuangan **Route / Controller terkait:**
`GET /admin/transactions`
`GET /admin/reports/export`
(TransactionController / ReportController)

**Screenshot fitur:**
*(Tambahkan screenshot tabel riwayat transaksi / laporan admin di sini)*

---

## 7. Direct Chat Interaktif
**Tujuan fitur:**
Menyediakan fitur pesan langsung (Direct Chat) antara admin dan *customer* di dalam platform tanpa harus menggunakan aplikasi pihak ketiga. **Aktor:**
Siswa/Customer , Admin **Alur fitur:**
Buka *widget* chat di *dashboard* → kirim pesan ke admin → sistem menampilkan riwayat chat → opsional menghapus chat **Route / Controller terkait:**
`POST /chat/send`
`GET /chat/history`
`DELETE /chat/{id}`
(ChatController)

**Screenshot fitur:**
*(Tambahkan screenshot tampilan antarmuka chat di sini)*

---

## 8. Penjadwalan Kelas Fleksibel
**Tujuan fitur:**
Menyediakan fitur jadwal kelas yang fleksibel dengan menyinkronkan ketersediaan tutor dengan preferensi waktu siswa. **Aktor:**
Siswa/Customer , Tutor , Sistem Web **Alur fitur:**
Siswa memilih slot waktu atau preferensi waktu → sistem mengecek ketersediaan jadwal tutor → konfirmasi jadwal kelas → notifikasi dikirim ke siswa dan tutor **Route / Controller terkait:**
`GET /schedules/available`
`POST /schedules/book`
(ScheduleController)

**Screenshot fitur:**
*(Tambahkan screenshot tampilan pemilihan jadwal kelas di sini)*

---

## 9. Audio Listening Interaktif
**Tujuan fitur:**
Mendukung pembelajaran bahasa dengan fitur pemutar audio *listening* interaktif yang dilengkapi tombol *play, pause, volume*, dan *repeat*. **Aktor:**
Siswa/Customer **Alur fitur:**
Siswa membuka halaman pembelajaran siswa → mengakses player audio listening → menggunakan tombol kontrol audio (play, pause, volume, repeat) **Route / Controller terkait:**
`GET /learning/materi/{id}`
(LearningController)

**Screenshot fitur:**
*(Tambahkan screenshot tampilan player audio di halaman materi di sini)*

---

## 10. Kuis Interaktif
**Tujuan fitur:**
Menyediakan sarana evaluasi siswa melalui kuis interaktif dengan sistem pengacakan (*random*) soal per sesi pengerjaan siswa. **Aktor:**
Siswa/Customer **Alur fitur:**
Siswa mengakses halaman pembelajaran → memulai sesi kuis dengan soal random → menjawab soal kuis → melihat hasil atau evaluasi kuis **Route / Controller terkait:**
`GET /quiz/{id}`
`POST /quiz/{id}/submit`
(QuizController)

**Screenshot fitur:**
*(Tambahkan screenshot tampilan antarmuka kuis interaktif di sini)*

---

## 11. Translate Teks Materi Secara Real-time
**Tujuan fitur:**
Membantu proses belajar siswa dengan menyediakan fitur penerjemah (*translate*) teks materi (Inggris, Jepang, Korea) secara langsung dan *real-time*. **Aktor:**
Siswa/Customer **Alur fitur:**
Siswa mengakses materi pada halaman pembelajaran → menggunakan fitur translate teks materi → sistem menampilkan hasil terjemahan secara real-time **Route / Controller terkait:**
`POST /learning/translate`
(LearningController)

**Screenshot fitur:**
*(Tambahkan screenshot penggunaan fitur translate di materi di sini)*

---

## 12. Forum Diskusi Kelas
**Tujuan fitur:**
Menyediakan ruang interaksi melalui forum diskusi antara sesama siswa dan tutor untuk membahas materi pada setiap kelas. **Aktor:**
Siswa/Customer , Tutor **Alur fitur:**
Siswa atau Tutor membuka akses forum diskusi per kelas → membuat postingan atau berdiskusi mengenai materi kelas **Route / Controller terkait:**
`GET /courses/{id}/forum`
`POST /courses/{id}/forum/reply`
(ForumController)

**Screenshot fitur:**
*(Tambahkan screenshot tampilan forum diskusi di sini)*

---

## 13. Integrasi Lokasi & Kontak (Hubungi Kami)
**Tujuan fitur:**
Menyajikan halaman Hubungi Kami yang berisi nomor kontak, alamat (Jl. Alai Parak Kopi), jam operasional, dan media sosial dengan *embed* Google Maps yang interaktif untuk menunjukkan lokasi fisik Brainy Course. **Aktor:**
Publik, Siswa/Customer **Alur fitur:**
User membuka navbar atau halaman Hubungi Kami → melihat informasi kontak, alamat, jam operasional → berinteraksi dengan widget Google Maps interaktif **Route / Controller terkait:**
`GET /contact`
(ContactController)

**Screenshot fitur:**
*(Tambahkan screenshot halaman Hubungi Kami beserta Google Maps di sini)*
