# Change Request: Forum Diskusi 3 Kategori

## Informasi Umum

| Item | Keterangan |
| --- | --- |
| Sistem | Platform Brainy - Kursus Bahasa |
| Change Request ID | CR #1 |
| Judul | Penambahan Fitur Forum Diskusi 3 Kategori |
| Tanggal | 15 Juni 2026 |
| Kelompok | Kelompok 5 |

---

## Latar Belakang

Platform Brainy merupakan aplikasi kursus bahasa berbasis web yang menyediakan layanan pembelajaran bagi siswa. Sebelumnya, forum diskusi hanya digunakan untuk pembelajaran umum sehingga belum tersedia media yang terstruktur untuk membahas informasi layanan, menyampaikan keluhan, maupun memberikan masukan terhadap platform.

Untuk meningkatkan kualitas komunikasi antara admin, siswa, dan tutor, dilakukan pengembangan fitur forum diskusi menjadi tiga kategori, yaitu **Seputar Brainy**, **Pembelajaran**, dan **Kritik & Saran**.

### Detail Kategori Forum

| Kategori | Deskripsi | Terhubung Ke |
| --- | --- | --- |
| Seputar Brainy | Pertanyaan mengenai pendaftaran, pembayaran, akun, dan layanan Brainy | Admin |
| Pembelajaran | Diskusi materi dan aktivitas pembelajaran | Tutor |
| Kritik & Saran | Penyampaian kritik, masukan, dan saran terhadap platform | Admin |

---

## Komponen yang Berdampak

| Komponen | Dampak | Keterangan |
| --- | --- | --- |
| Database | Ya | Penambahan tabel `forum_topics` dan `forum_replies`. |
| Migration | Ya | Penambahan migration untuk pembuatan tabel forum. |
| Model | Ya | Penambahan model `ForumTopic` dan `ForumReply`. |
| Controller | Ya | Penambahan `ForumController` untuk mengelola topik dan balasan forum. |
| View / Frontend | Ya | Penambahan komponen forum diskusi dan integrasi ke dashboard. |
| Route | Ya | Penambahan route penyimpanan topik dan balasan forum. |
| Middleware | Tidak | Tidak ada perubahan middleware. |
| Dashboard | Ya | Forum ditampilkan pada dashboard admin, siswa, dan tutor. |

---

## Risiko

| Risiko | Tingkat | Mitigasi |
| --- | --- | --- |
| Tabel forum belum dibuat | Sedang | Menjalankan migration sebelum fitur digunakan. |
| Pengguna memilih kategori yang tidak sesuai | Rendah | Menampilkan deskripsi kategori secara jelas. |
| Input terlalu panjang | Rendah | Validasi panjang karakter pada controller. |
| Dashboard error karena tabel belum tersedia | Sedang | Pengecekan tabel menggunakan `Schema::hasTable()`. |

---

## Hasil Implementasi

### Database

- Menambahkan tabel `forum_topics`.
- Menambahkan tabel `forum_replies`.

### Model

- Menambahkan model `ForumTopic`.
- Menambahkan model `ForumReply`.

### Controller

- Menambahkan `ForumController`.
- Menambahkan method `storeTopic()`.
- Menambahkan method `storeReply()`.

### Frontend

- Menambahkan dashboard admin, siswa, dan tutor yang terintegrasi dengan forum.
- Menambahkan komponen `forum-discussion`.
- Menambahkan komponen `dashboard-icon`.

### Route

- Menambahkan route `forum.topics.store`.
- Menambahkan route `forum.replies.store`.

---

## Refleksi

### Hal yang Berjalan Baik

- Implementasi forum berhasil terintegrasi pada dashboard admin, siswa, dan tutor.
- Penggunaan komponen Blade mempermudah penggunaan ulang tampilan forum.
- Struktur model dan controller membuat pengelolaan data lebih terorganisir.

### Tantangan

- Menyesuaikan tampilan forum agar tetap responsif pada berbagai dashboard.
- Memastikan relasi topik dan balasan berjalan dengan baik.
- Menjaga konsistensi data yang ditampilkan kepada seluruh pengguna.

### Pembelajaran

- Change Impact Analysis membantu mengidentifikasi komponen yang terdampak sebelum implementasi.
- Dokumentasi yang sesuai dengan kode aktual mempermudah proses pengembangan dan pengujian.
- Penggunaan komponen Blade yang reusable dapat mengurangi duplikasi kode dan mempercepat pengembangan fitur.

---

## Kesimpulan

Change Request penambahan fitur **Forum Diskusi 3 Kategori** berhasil diimplementasikan pada Platform Brainy. Perubahan mencakup penambahan struktur database, model, controller, route, serta komponen frontend yang terintegrasi pada dashboard admin, siswa, dan tutor.

Fitur ini memungkinkan pengguna membuat topik dan balasan diskusi berdasarkan kategori yang tersedia sehingga komunikasi dalam platform menjadi lebih terstruktur dan mudah dikelola.
