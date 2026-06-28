# Feature Documentation Ruang Brainy

Dokumen ini menjelaskan seluruh fitur utama yang tersedia pada aplikasi Ruang Brainy berdasarkan route, controller, model, dan halaman view yang ada pada proyek. Bagian screenshot sengaja disediakan sebagai placeholder agar dapat dilengkapi setelah tampilan akhir aplikasi siap.

Format setiap fitur:

- **Tujuan**
- **Aktor**
- **Alur fitur**
- **Route / Controller terkait**
- **Output**
- **Screenshot**

---

## 1. Landing Page dan Informasi Publik

| Field | Detail |
|---|---|
| **Tujuan** | Menampilkan halaman awal aplikasi sebagai pengenalan layanan Ruang Brainy kepada pengunjung sebelum login. |
| **Aktor** | Pengunjung, Calon Siswa |
| **Alur fitur** | Pengunjung membuka website -> sistem menampilkan halaman landing -> pengunjung melihat informasi umum layanan -> pengunjung dapat menuju halaman login atau registrasi. |
| **Route terkait** | `GET /` |
| **Controller terkait** | Route closure pada `routes/web.php` |
| **Output** | Pengunjung mendapatkan gambaran awal tentang aplikasi Ruang Brainy. |

**Screenshot:**  
_(Tambahkan screenshot landing page di sini.)_

---

## 2. Registrasi Akun Siswa

| Field | Detail |
|---|---|
| **Tujuan** | Memungkinkan pengguna baru membuat akun siswa pada sistem Ruang Brainy. |
| **Aktor** | Calon Siswa |
| **Alur fitur** | Pengguna membuka halaman register -> mengisi nama, email, password, dan konfirmasi password -> sistem memvalidasi input -> sistem membuat akun dengan role siswa -> pengguna otomatis login dan diarahkan ke dashboard. |
| **Route terkait** | `GET /register`, `POST /register` |
| **Controller terkait** | `AuthController@showRegister`, `AuthController@register` |
| **Output** | Akun siswa berhasil dibuat dan pengguna masuk ke sistem. |

**Screenshot:**  
_(Tambahkan screenshot halaman register di sini.)_

---

## 3. Login dan Logout

| Field | Detail |
|---|---|
| **Tujuan** | Mengamankan akses aplikasi dengan proses autentikasi email dan password serta menyediakan proses keluar dari sistem. |
| **Aktor** | Admin, Tutor, Siswa |
| **Alur fitur** | Pengguna membuka halaman login -> mengisi email dan password -> sistem memvalidasi kredensial -> session dibuat -> pengguna dapat logout saat selesai menggunakan aplikasi. |
| **Route terkait** | `GET /login`, `POST /login`, `GET|POST /logout` |
| **Controller terkait** | `AuthController@showLogin`, `AuthController@login`, `AuthController@logout` |
| **Output** | Pengguna berhasil masuk atau keluar dari aplikasi dengan aman. |

**Screenshot:**  
_(Tambahkan screenshot halaman login dan logout di sini.)_

---

## 4. Redirect Dashboard Berdasarkan Role

| Field | Detail |
|---|---|
| **Tujuan** | Mengarahkan pengguna ke dashboard yang sesuai dengan role masing-masing setelah login. |
| **Aktor** | Admin, Tutor, Siswa |
| **Alur fitur** | Pengguna berhasil login -> sistem membaca role user -> admin diarahkan ke dashboard admin, tutor ke dashboard tutor, dan siswa ke dashboard siswa. |
| **Route terkait** | `GET /dashboard`, `GET /admin/dashboard`, `GET /tutor/dashboard`, `GET /siswa/dashboard` |
| **Controller terkait** | `AuthController@dashboard`, `SiswaDashboardController@index` |
| **Output** | Setiap role mendapatkan halaman dashboard dan menu yang sesuai. |

**Screenshot:**  
_(Tambahkan screenshot redirect/dashboard sesuai role di sini.)_

---

## 5. Dashboard Admin dan Ringkasan Operasional

| Field | Detail |
|---|---|
| **Tujuan** | Menampilkan ringkasan operasional admin seperti pendaftaran, aktivitas terbaru, pembayaran pending, waiting list, dan akses cepat ke fitur manajemen. |
| **Aktor** | Admin |
| **Alur fitur** | Admin login -> membuka dashboard admin -> sistem menampilkan ringkasan data -> admin dapat memilih quick action untuk membuka menu manajemen tertentu. |
| **Route terkait** | `GET /admin/dashboard`, `GET /admin` |
| **Controller terkait** | Route closure pada `routes/web.php` |
| **Output** | Admin dapat memantau kondisi operasional aplikasi dari satu halaman utama. |

**Screenshot:**  
_(Tambahkan screenshot dashboard admin di sini.)_

---

## 6. Manajemen Kursus Admin

| Field | Detail |
|---|---|
| **Tujuan** | Memungkinkan admin mengelola data kursus, termasuk menambah, mengubah, menghapus, dan memfilter kursus berdasarkan level. |
| **Aktor** | Admin |
| **Alur fitur** | Admin membuka menu kelola kursus -> sistem menampilkan daftar kursus -> admin memfilter level kursus -> admin menambah atau mengedit data melalui modal -> data ditampilkan pada daftar kursus. |
| **Route terkait** | `GET /admin/courses`, `GET /admin/kursus` |
| **Controller terkait** | Route closure pada `routes/web.php`, view `admin/courses.blade.php` |
| **Output** | Data kursus dapat dikelola oleh admin melalui halaman kursus. |

**Screenshot:**  
_(Tambahkan screenshot manajemen kursus di sini.)_

---

## 7. Manajemen Tutor Admin

| Field | Detail |
|---|---|
| **Tujuan** | Memungkinkan admin mengelola data tutor dan melihat jadwal mengajar tutor. |
| **Aktor** | Admin |
| **Alur fitur** | Admin membuka menu tutor -> sistem menampilkan daftar tutor -> admin memfilter tutor berdasarkan bahasa -> admin menambah, mengedit, menghapus, atau membuka jadwal tutor. |
| **Route terkait** | `GET /admin/tutors`, `GET /admin/tutor` |
| **Controller terkait** | Route closure pada `routes/web.php`, view `admin/tutors.blade.php` |
| **Output** | Data tutor dan jadwal mengajar dapat dipantau serta dikelola admin. |

**Screenshot:**  
_(Tambahkan screenshot manajemen tutor di sini.)_

---

## 8. Manajemen Data Siswa Admin

| Field | Detail |
|---|---|
| **Tujuan** | Memungkinkan admin mengelola data siswa, memfilter berdasarkan bahasa/status, melihat detail profil, dan mengubah status siswa. |
| **Aktor** | Admin |
| **Alur fitur** | Admin membuka menu siswa -> sistem menampilkan daftar siswa -> admin memfilter data -> admin menambah atau membuka detail siswa -> admin dapat mengubah status menjadi Active, Inactive, atau Suspended. |
| **Route terkait** | `GET /admin/students`, `GET /admin/siswa` |
| **Controller terkait** | Route closure pada `routes/web.php`, view `admin/students.blade.php` |
| **Output** | Admin dapat memantau dan memperbarui status data siswa. |

**Screenshot:**  
_(Tambahkan screenshot manajemen data siswa di sini.)_

---

## 9. Manajemen Pembayaran Admin

| Field | Detail |
|---|---|
| **Tujuan** | Membantu admin memantau daftar pembayaran dan melakukan konfirmasi atau penolakan pembayaran. |
| **Aktor** | Admin |
| **Alur fitur** | Admin membuka menu pembayaran -> sistem menampilkan daftar pembayaran -> admin memfilter status pembayaran -> admin mengonfirmasi atau menolak pembayaran. |
| **Route terkait** | `GET /admin/payments`, `GET /admin/pembayaran` |
| **Controller terkait** | Route closure pada `routes/web.php`, view `admin/payments.blade.php` |
| **Output** | Status pembayaran dapat dipantau dan diperbarui oleh admin. |

**Screenshot:**  
_(Tambahkan screenshot manajemen pembayaran di sini.)_

---

## 10. Manajemen Jadwal Kelas Admin

| Field | Detail |
|---|---|
| **Tujuan** | Memungkinkan admin mengatur jadwal kelas berdasarkan hari, kursus, tutor, waktu, ruangan, dan kuota. |
| **Aktor** | Admin |
| **Alur fitur** | Admin membuka menu jadwal -> sistem menampilkan jadwal mingguan -> admin memilih kelas atau membuka modal jadwal -> admin menambah atau mengubah jadwal kelas. |
| **Route terkait** | `GET /admin/schedules`, `GET /admin/jadwal` |
| **Controller terkait** | Route closure pada `routes/web.php`, view `admin/schedules.blade.php` |
| **Output** | Jadwal kelas dapat diatur dan ditampilkan dalam tampilan mingguan. |

**Screenshot:**  
_(Tambahkan screenshot manajemen jadwal kelas di sini.)_

---

## 11. Manajemen Waiting List Admin

| Field | Detail |
|---|---|
| **Tujuan** | Memudahkan admin memantau calon siswa yang masuk daftar tunggu dan memproses statusnya. |
| **Aktor** | Admin |
| **Alur fitur** | Admin membuka waiting list -> sistem menampilkan daftar calon siswa -> admin memfilter berdasarkan bahasa -> admin menerima atau menolak data waiting list. |
| **Route terkait** | `GET /admin/waitinglist`, `GET /admin/waitlist` |
| **Controller terkait** | Route closure pada `routes/web.php`, view `admin/waitinglist.blade.php` |
| **Output** | Data waiting list dapat dipantau dan diproses oleh admin. |

**Screenshot:**  
_(Tambahkan screenshot waiting list di sini.)_

---

## 12. Manajemen Quiz Admin

| Field | Detail |
|---|---|
| **Tujuan** | Memungkinkan admin mengunggah quiz mingguan berbasis gambar, menghapus quiz, dan melihat jawaban siswa. |
| **Aktor** | Admin |
| **Alur fitur** | Admin membuka halaman quiz -> admin mengisi judul, minggu, deskripsi, bahasa, level, dan gambar quiz -> sistem menyimpan quiz -> admin dapat melihat quiz terupload dan jawaban siswa. |
| **Route terkait** | `GET /admin/quiz`, `POST /admin/quiz`, `DELETE /admin/quiz/{quiz}` |
| **Controller terkait** | `AdminQuizController@index`, `AdminQuizController@store`, `AdminQuizController@destroy` |
| **Output** | Quiz tersedia untuk siswa dan jawaban siswa dapat dipantau admin. |

**Screenshot:**  
_(Tambahkan screenshot manajemen quiz admin di sini.)_

---

## 13. Dashboard Siswa

| Field | Detail |
|---|---|
| **Tujuan** | Menyediakan halaman utama siswa yang berisi sambutan, ringkasan kelas aktif, akses cepat fitur belajar, dan jadwal terdekat. |
| **Aktor** | Siswa |
| **Alur fitur** | Siswa login -> sistem membuka dashboard siswa -> siswa melihat kelas aktif dan jadwal -> siswa memilih fitur seperti kelas kursus, audio, quiz, diskusi, translate, atau jadwal. |
| **Route terkait** | `GET /siswa/dashboard` |
| **Controller terkait** | `SiswaDashboardController@index` |
| **Output** | Siswa mendapatkan pusat navigasi belajar setelah login. |

**Screenshot:**  
_(Tambahkan screenshot dashboard siswa di sini.)_

---

## 14. Katalog Kelas Kursus Siswa

| Field | Detail |
|---|---|
| **Tujuan** | Menampilkan daftar kelas kursus bahasa yang dapat dilihat dan difilter oleh siswa. |
| **Aktor** | Siswa |
| **Alur fitur** | Siswa membuka menu kelas kursus -> sistem menampilkan daftar kelas -> siswa memfilter berdasarkan bahasa atau level -> daftar kelas diperbarui sesuai filter. |
| **Route terkait** | `GET /siswa/kelas-kursus` |
| **Controller terkait** | `SiswaCourseController@index` |
| **Output** | Siswa dapat melihat pilihan kelas bahasa Inggris, Jepang, dan Korea berdasarkan level. |

**Screenshot:**  
_(Tambahkan screenshot katalog kelas kursus di sini.)_

---

## 15. Detail Kelas dan Pendaftaran Online

| Field | Detail |
|---|---|
| **Tujuan** | Menampilkan detail kelas yang dipilih, termasuk jadwal, tutor, materi pembelajaran, kapasitas, durasi, harga, dan tombol pendaftaran online. |
| **Aktor** | Siswa |
| **Alur fitur** | Siswa memilih kelas dari katalog -> sistem membuka detail kelas -> siswa membaca informasi kursus -> siswa dapat menekan tombol daftar kelas. |
| **Route terkait** | `GET /siswa/kelas-kursus/{slug}` |
| **Controller terkait** | `SiswaCourseController@show` |
| **Output** | Informasi detail kelas tampil sebelum siswa melakukan pendaftaran. |

**Screenshot:**  
_(Tambahkan screenshot detail kelas dan pendaftaran online di sini.)_

---

## 16. Audio Listening

| Field | Detail |
|---|---|
| **Tujuan** | Menyediakan materi audio untuk latihan listening siswa berdasarkan bahasa pembelajaran. |
| **Aktor** | Siswa |
| **Alur fitur** | Siswa membuka menu audio -> sistem menampilkan daftar audio -> siswa memfilter bahasa -> siswa mendengarkan audio, mengunduh file, membuka transkrip, dan sistem menandai audio yang sudah didengarkan. |
| **Route terkait** | `GET /siswa/audio`, `GET /siswa/audio/{id}/download`, `POST /siswa/audio/{id}/listen` |
| **Controller terkait** | `SiswaAudioController@index`, `SiswaAudioController@download`, `SiswaAudioController@markListened` |
| **Output** | Siswa dapat mengakses audio listening dan riwayat audio yang sudah didengar tersimpan. |

**Screenshot:**  
_(Tambahkan screenshot audio listening di sini.)_

---

## 17. Quiz Mingguan Siswa

| Field | Detail |
|---|---|
| **Tujuan** | Menyediakan halaman pengerjaan quiz mingguan bagi siswa dan menyimpan jawaban yang dikirim. |
| **Aktor** | Siswa |
| **Alur fitur** | Siswa membuka menu quiz -> sistem menampilkan quiz yang tersedia -> siswa melihat gambar quiz -> siswa menulis jawaban -> sistem menyimpan jawaban siswa. |
| **Route terkait** | `GET /siswa/quiz`, `POST /siswa/quiz/{quiz}/answer` |
| **Controller terkait** | `SiswaQuizController@index`, `SiswaQuizController@answer` |
| **Output** | Jawaban siswa tersimpan dan dapat dilihat oleh admin. |

**Screenshot:**  
_(Tambahkan screenshot quiz siswa di sini.)_

---

## 18. Translate Bahasa

| Field | Detail |
|---|---|
| **Tujuan** | Membantu siswa menerjemahkan teks antara Bahasa Indonesia dan bahasa pembelajaran seperti English, Korean, atau Japanese. |
| **Aktor** | Siswa |
| **Alur fitur** | Siswa membuka menu translate -> memilih bahasa sumber dan target -> memasukkan teks -> sistem memvalidasi pasangan bahasa -> sistem mengirim request translate -> hasil dan riwayat terjemahan ditampilkan. |
| **Route terkait** | `GET /siswa/translate`, `POST /siswa/translate` |
| **Controller terkait** | `SiswaTranslateController@index`, `SiswaTranslateController@translate` |
| **Output** | Hasil terjemahan tampil dan riwayat terjemahan terakhir tersimpan di session. |

**Screenshot:**  
_(Tambahkan screenshot fitur translate di sini.)_

---

## 19. Kontrol Translate Interaktif

| Field | Detail |
|---|---|
| **Tujuan** | Melengkapi fitur translate dengan interaksi tambahan seperti tukar bahasa, hapus input, input suara, dengarkan teks, salin hasil, dan riwayat copy. |
| **Aktor** | Siswa |
| **Alur fitur** | Siswa menggunakan tombol interaktif pada halaman translate -> sistem menjalankan fungsi sesuai tombol -> tampilan input, output, atau riwayat diperbarui. |
| **Route terkait** | `GET /siswa/translate`, `POST /siswa/translate` |
| **Controller terkait** | `SiswaTranslateController`, script pada view `siswa/translate.blade.php` |
| **Output** | Penggunaan translate menjadi lebih praktis dan interaktif. |

**Screenshot:**  
_(Tambahkan screenshot kontrol translate interaktif di sini.)_

---

## 20. Jadwal dan Progress Belajar Siswa

| Field | Detail |
|---|---|
| **Tujuan** | Menampilkan kelas aktif, kelas selesai, jadwal mingguan, progress belajar, kehadiran, nilai rata-rata, tugas, dan materi tersedia. |
| **Aktor** | Siswa |
| **Alur fitur** | Siswa membuka menu jadwal -> memilih tab aktif, selesai, atau jadwal -> sistem menampilkan informasi sesuai tab -> siswa dapat membuka materi, audio, atau forum diskusi. |
| **Route terkait** | `GET /siswa/jadwal` |
| **Controller terkait** | `SiswaScheduleController@index` |
| **Output** | Siswa dapat memantau perkembangan belajar dan jadwal kelas. |

**Screenshot:**  
_(Tambahkan screenshot jadwal dan progress belajar siswa di sini.)_

---

## 21. Forum Diskusi Multi-Role

| Field | Detail |
|---|---|
| **Tujuan** | Menyediakan ruang diskusi untuk admin, tutor, dan siswa berdasarkan kategori topik. |
| **Aktor** | Admin, Tutor, Siswa |
| **Alur fitur** | Pengguna membuka forum diskusi -> memilih kategori -> sistem menampilkan topik -> pengguna membuat topik atau membalas pesan -> sistem menyimpan diskusi. |
| **Route terkait** | `GET /siswa/diskusi`, `GET /admin/diskusi`, `GET /tutor/diskusi`, `POST /{role}/diskusi`, `POST /{role}/diskusi/{topic}/messages` |
| **Controller terkait** | `DiscussionController@index`, `DiscussionController@storeTopic`, `DiscussionController@storeMessage` |
| **Output** | Topik dan pesan diskusi tersimpan serta dapat dibaca oleh pengguna sesuai role. |

**Screenshot:**  
_(Tambahkan screenshot forum diskusi di sini.)_

---

## 22. Live Update Forum Diskusi

| Field | Detail |
|---|---|
| **Tujuan** | Memperbarui daftar topik diskusi secara dinamis tanpa harus memuat ulang seluruh halaman. |
| **Aktor** | Admin, Tutor, Siswa |
| **Alur fitur** | Pengguna membuka forum -> sistem memanggil endpoint live berdasarkan kategori -> server mengembalikan HTML topik terbaru dan waktu update -> tampilan diskusi diperbarui. |
| **Route terkait** | `GET /siswa/diskusi/live`, `GET /admin/diskusi/live`, `GET /tutor/diskusi/live` |
| **Controller terkait** | `DiscussionController@live` |
| **Output** | Daftar diskusi dapat diperbarui secara lebih cepat dan interaktif. |

**Screenshot:**  
_(Tambahkan screenshot live update forum diskusi di sini.)_

---

## 23. Dashboard Tutor

| Field | Detail |
|---|---|
| **Tujuan** | Menyediakan halaman awal untuk tutor setelah login dan akses cepat ke forum diskusi. |
| **Aktor** | Tutor |
| **Alur fitur** | Tutor login -> sistem mengarahkan ke dashboard tutor -> tutor melihat halaman sambutan -> tutor dapat membuka forum diskusi. |
| **Route terkait** | `GET /tutor/dashboard`, `GET /tutor/diskusi` |
| **Controller terkait** | Route closure pada `routes/web.php`, `DiscussionController@index` |
| **Output** | Tutor mendapatkan halaman kerja sederhana dan akses ke diskusi. |

**Screenshot:**  
_(Tambahkan screenshot dashboard tutor di sini.)_

---

## 24. Middleware dan Hak Akses Role

| Field | Detail |
|---|---|
| **Tujuan** | Membatasi akses halaman berdasarkan role agar admin, tutor, dan siswa hanya dapat membuka fitur yang sesuai. |
| **Aktor** | Sistem, Admin, Tutor, Siswa |
| **Alur fitur** | Pengguna mengakses route tertentu -> middleware atau pengecekan role memvalidasi hak akses -> jika sesuai halaman ditampilkan -> jika tidak sesuai sistem menolak akses. |
| **Route terkait** | Route dengan middleware `auth`, `role:1`, `role:2`, `role:3` |
| **Controller terkait** | `AuthController`, `User` model helper role, middleware role |
| **Output** | Akses aplikasi lebih aman dan terpisah berdasarkan jenis pengguna. |

**Screenshot:**  
_(Tambahkan screenshot contoh akses role atau halaman forbidden bila diperlukan.)_

---

## Ringkasan Fitur

| No | Fitur | Aktor Utama | Status |
|---:|---|---|---|
| 1 | Landing Page dan Informasi Publik | Pengunjung | Tersedia |
| 2 | Registrasi Akun Siswa | Calon Siswa | Tersedia |
| 3 | Login dan Logout | Admin, Tutor, Siswa | Tersedia |
| 4 | Redirect Dashboard Berdasarkan Role | Admin, Tutor, Siswa | Tersedia |
| 5 | Dashboard Admin dan Ringkasan Operasional | Admin | Tersedia |
| 6 | Manajemen Kursus Admin | Admin | Tersedia |
| 7 | Manajemen Tutor Admin | Admin | Tersedia |
| 8 | Manajemen Data Siswa Admin | Admin | Tersedia |
| 9 | Manajemen Pembayaran Admin | Admin | Tersedia |
| 10 | Manajemen Jadwal Kelas Admin | Admin | Tersedia |
| 11 | Manajemen Waiting List Admin | Admin | Tersedia |
| 12 | Manajemen Quiz Admin | Admin | Tersedia |
| 13 | Dashboard Siswa | Siswa | Tersedia |
| 14 | Katalog Kelas Kursus Siswa | Siswa | Tersedia |
| 15 | Detail Kelas dan Pendaftaran Online | Siswa | Tersedia |
| 16 | Audio Listening | Siswa | Tersedia |
| 17 | Quiz Mingguan Siswa | Siswa | Tersedia |
| 18 | Translate Bahasa | Siswa | Tersedia |
| 19 | Kontrol Translate Interaktif | Siswa | Tersedia |
| 20 | Jadwal dan Progress Belajar Siswa | Siswa | Tersedia |
| 21 | Forum Diskusi Multi-Role | Admin, Tutor, Siswa | Tersedia |
| 22 | Live Update Forum Diskusi | Admin, Tutor, Siswa | Tersedia |
| 23 | Dashboard Tutor | Tutor | Tersedia |
| 24 | Middleware dan Hak Akses Role | Sistem | Tersedia |
