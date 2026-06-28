# Feature Documentation Ruang Brainy

Dokumen ini menjelaskan fitur utama pada aplikasi Ruang Brainy. Format setiap fitur mengikuti struktur dokumentasi proyek: nama fitur, tujuan, aktor, alur kerja, route/controller terkait, dan output yang dihasilkan.

---

## 1. Autentikasi Multi-Role

| Field | Detail |
|---|---|
| **Nama fitur** | Autentikasi Multi-Role |
| **Tujuan** | Mengelola proses registrasi, login, logout, dan pengalihan dashboard berdasarkan role pengguna. |
| **Aktor** | Admin, Tutor, Siswa |
| **Alur fitur** | Pengguna membuka halaman login/register -> sistem memvalidasi input -> sistem membuat session login -> pengguna diarahkan ke dashboard sesuai role. |
| **Route terkait** | `GET /login`, `POST /login`, `GET /register`, `POST /register`, `GET /dashboard`, `GET|POST /logout` |
| **Controller terkait** | `AuthController` |
| **Output** | Pengguna berhasil masuk ke dashboard Admin, Tutor, atau Siswa sesuai hak aksesnya. |

**Bukti tampilan:**

<img width="192" height="210" alt="Halaman login Ruang Brainy" src="https://github.com/user-attachments/assets/df785062-2e50-44ab-8b41-1fe0a7422ae0" />
<img width="190" height="166" alt="Halaman register Ruang Brainy" src="https://github.com/user-attachments/assets/e9ada6e1-5a98-4535-bbba-3afa7d3d91f0" />

---

## 2. Dashboard Berdasarkan Role

| Field | Detail |
|---|---|
| **Nama fitur** | Dashboard Berdasarkan Role |
| **Tujuan** | Menyediakan halaman awal yang berbeda untuk Admin, Tutor, dan Siswa setelah login. |
| **Aktor** | Admin, Tutor, Siswa |
| **Alur fitur** | Pengguna login -> sistem membaca nilai role user -> sistem mengarahkan user ke dashboard sesuai role -> user mengakses menu yang tersedia untuk rolenya. |
| **Route terkait** | `GET /admin/dashboard`, `GET /tutor/dashboard`, `GET /siswa/dashboard` |
| **Controller terkait** | `AuthController`, `SiswaDashboardController` |
| **Output** | Setiap pengguna hanya melihat dashboard dan menu yang sesuai dengan hak aksesnya. |

**Bukti tampilan:**

<img width="355" height="211" alt="Dashboard admin Ruang Brainy" src="https://github.com/user-attachments/assets/4d28ba8f-9bcd-4171-8398-dcebec0847e1" />

---

## 3. Katalog dan Detail Kelas Kursus

| Field | Detail |
|---|---|
| **Nama fitur** | Katalog dan Detail Kelas Kursus |
| **Tujuan** | Menampilkan daftar kelas bahasa yang tersedia dan menyediakan detail kelas, tutor, jadwal, kapasitas, durasi, serta harga. |
| **Aktor** | Siswa |
| **Alur fitur** | Siswa membuka menu kelas kursus -> sistem menampilkan daftar kelas -> siswa dapat memfilter berdasarkan bahasa dan level -> siswa membuka detail kelas yang dipilih. |
| **Route terkait** | `GET /siswa/kelas-kursus`, `GET /siswa/kelas-kursus/{slug}` |
| **Controller terkait** | `SiswaCourseController` |
| **Output** | Siswa mendapatkan informasi lengkap tentang kelas yang tersedia sebelum memilih kelas. |

**Bukti tampilan:**

<img width="352" height="210" alt="Katalog kelas kursus Ruang Brainy" src="https://github.com/user-attachments/assets/2c7aeb2b-236b-4d70-99a5-8b9e4001ce91" />

---

## 4. Manajemen Kelas, Jadwal, Tutor, Siswa, dan Waiting List Admin

| Field | Detail |
|---|---|
| **Nama fitur** | Manajemen Data Admin |
| **Tujuan** | Membantu admin memantau dan mengelola data operasional seperti kelas kursus, tutor, siswa, pembayaran, jadwal, dan waiting list. |
| **Aktor** | Admin |
| **Alur fitur** | Admin login -> admin membuka dashboard -> admin memilih menu data yang ingin dikelola -> sistem menampilkan halaman manajemen data sesuai menu. |
| **Route terkait** | `GET /admin/courses`, `GET /admin/tutors`, `GET /admin/students`, `GET /admin/payments`, `GET /admin/schedules`, `GET /admin/waitinglist` |
| **Controller terkait** | Route closure pada `routes/web.php` dan view admin terkait |
| **Output** | Admin dapat melihat halaman pengelolaan data utama untuk mendukung operasional Ruang Brainy. |

**Bukti tampilan:**

<img width="355" height="212" alt="Halaman laporan atau transaksi admin" src="https://github.com/user-attachments/assets/944894de-574e-4ef2-84e2-df416eec8db8" />

---

## 5. Pembelajaran Audio Listening

| Field | Detail |
|---|---|
| **Nama fitur** | Pembelajaran Audio Listening |
| **Tujuan** | Menyediakan materi audio untuk latihan listening siswa berdasarkan bahasa yang tersedia. |
| **Aktor** | Siswa |
| **Alur fitur** | Siswa membuka menu audio -> sistem menampilkan daftar audio -> siswa memfilter berdasarkan bahasa -> siswa mendengarkan atau mengunduh audio -> sistem dapat menandai audio sebagai sudah didengar. |
| **Route terkait** | `GET /siswa/audio`, `GET /siswa/audio/{id}/download`, `POST /siswa/audio/{id}/listen` |
| **Controller terkait** | `SiswaAudioController` |
| **Output** | Siswa dapat mengakses materi listening dan sistem menyimpan status audio yang sudah didengarkan. |

**Bukti tampilan:**

<img width="351" height="211" alt="Halaman audio listening Ruang Brainy" src="https://github.com/user-attachments/assets/5a14c070-c923-48eb-8edc-5bb269ac52c6" />

---

## 6. Quiz dan Assessment

| Field | Detail |
|---|---|
| **Nama fitur** | Quiz dan Assessment |
| **Tujuan** | Menyediakan media evaluasi pembelajaran siswa melalui quiz berbasis gambar dan jawaban teks. |
| **Aktor** | Admin, Siswa |
| **Alur fitur** | Admin mengunggah quiz -> sistem menyimpan data quiz -> siswa membuka halaman quiz -> siswa mengirim jawaban -> sistem menyimpan hasil jawaban siswa. |
| **Route terkait** | `GET /admin/quiz`, `POST /admin/quiz`, `DELETE /admin/quiz/{quiz}`, `GET /siswa/quiz`, `POST /siswa/quiz/{quiz}/answer` |
| **Controller terkait** | `AdminQuizController`, `SiswaQuizController` |
| **Output** | Quiz tampil pada halaman siswa dan jawaban siswa tersimpan untuk dilihat admin. |

**Bukti tampilan:**

<img width="355" height="212" alt="Halaman quiz Ruang Brainy" src="https://github.com/user-attachments/assets/dc221d16-564b-4ce6-83c3-1004b0bd8d2f" />

---

## 7. Jadwal dan Progress Belajar Siswa

| Field | Detail |
|---|---|
| **Nama fitur** | Jadwal dan Progress Belajar Siswa |
| **Tujuan** | Menampilkan kelas aktif, kelas selesai, jadwal mingguan, progress belajar, kehadiran, nilai, dan materi pendukung siswa. |
| **Aktor** | Siswa |
| **Alur fitur** | Siswa membuka menu jadwal -> siswa memilih tab kelas aktif, kelas selesai, atau jadwal -> sistem menampilkan data belajar sesuai tab yang dipilih. |
| **Route terkait** | `GET /siswa/jadwal` |
| **Controller terkait** | `SiswaScheduleController` |
| **Output** | Siswa dapat memantau perkembangan belajar dan jadwal kelas yang sedang berjalan. |

---

## 8. Translate Bahasa

| Field | Detail |
|---|---|
| **Nama fitur** | Translate Bahasa |
| **Tujuan** | Membantu siswa menerjemahkan teks antara Bahasa Indonesia dan bahasa pembelajaran seperti English, Korean, atau Japanese. |
| **Aktor** | Siswa |
| **Alur fitur** | Siswa membuka menu translate -> siswa memilih bahasa sumber dan target -> siswa memasukkan teks -> sistem memvalidasi pasangan bahasa -> sistem mengirim request ke layanan translate -> hasil terjemahan dan riwayat ditampilkan. |
| **Route terkait** | `GET /siswa/translate`, `POST /siswa/translate` |
| **Controller terkait** | `SiswaTranslateController` |
| **Output** | Siswa menerima hasil terjemahan dan dapat melihat riwayat terjemahan terakhir. |

---

## 9. Forum Diskusi Multi-Role

| Field | Detail |
|---|---|
| **Nama fitur** | Forum Diskusi Multi-Role |
| **Tujuan** | Menyediakan ruang diskusi antara siswa, tutor, dan admin berdasarkan kategori topik. |
| **Aktor** | Admin, Tutor, Siswa |
| **Alur fitur** | Pengguna membuka halaman diskusi -> sistem menampilkan topik berdasarkan kategori -> pengguna membuat topik baru atau membalas pesan -> sistem memperbarui daftar diskusi. |
| **Route terkait** | `GET /siswa/diskusi`, `GET /admin/diskusi`, `GET /tutor/diskusi`, `GET /{role}/diskusi/live`, `POST /{role}/diskusi`, `POST /{role}/diskusi/{topic}/messages` |
| **Controller terkait** | `DiscussionController` |
| **Output** | Diskusi tersimpan dan dapat diakses oleh pengguna sesuai role serta kategori yang dipilih. |

---

## 10. Halaman Landing dan Informasi Publik

| Field | Detail |
|---|---|
| **Nama fitur** | Halaman Landing dan Informasi Publik |
| **Tujuan** | Menyediakan halaman awal aplikasi yang memperkenalkan Ruang Brainy kepada pengunjung sebelum login. |
| **Aktor** | Pengunjung, Siswa |
| **Alur fitur** | Pengunjung membuka website -> sistem menampilkan halaman landing -> pengunjung melihat informasi umum layanan -> pengunjung dapat menuju halaman login atau register. |
| **Route terkait** | `GET /` |
| **Controller terkait** | Route closure pada `routes/web.php` |
| **Output** | Pengunjung mendapatkan gambaran awal tentang aplikasi Ruang Brainy dan dapat mulai masuk atau mendaftar. |

---

## Ringkasan Fitur

| No | Fitur | Aktor Utama | Status |
|---:|---|---|---|
| 1 | Autentikasi Multi-Role | Admin, Tutor, Siswa | Tersedia |
| 2 | Dashboard Berdasarkan Role | Admin, Tutor, Siswa | Tersedia |
| 3 | Katalog dan Detail Kelas Kursus | Siswa | Tersedia |
| 4 | Manajemen Data Admin | Admin | Tersedia |
| 5 | Pembelajaran Audio Listening | Siswa | Tersedia |
| 6 | Quiz dan Assessment | Admin, Siswa | Tersedia |
| 7 | Jadwal dan Progress Belajar Siswa | Siswa | Tersedia |
| 8 | Translate Bahasa | Siswa | Tersedia |
| 9 | Forum Diskusi Multi-Role | Admin, Tutor, Siswa | Tersedia |
| 10 | Halaman Landing dan Informasi Publik | Pengunjung, Siswa | Tersedia |
