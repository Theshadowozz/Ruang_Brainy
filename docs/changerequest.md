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

Platform Brainy merupakan aplikasi kursus bahasa berbasis web yang menyediakan layanan pembelajaran bagi siswa. Perubahan ini dilakukan untuk menyediakan forum diskusi yang dapat dipakai bersama oleh tiga role pengguna, yaitu admin, siswa, dan tutor.

Forum diskusi dibuat agar pengguna dapat:

- Membahas informasi seputar Brainy.
- Menyampaikan keluhan.
- Berdiskusi mengenai pembelajaran.
- Membuat topik diskusi dan mengirim balasan yang tampil di dashboard admin, dashboard siswa, dan dashboard tutor.

---

## Deskripsi Change Request

| Komponen | Sebelum | Sesudah |
| --- | --- | --- |
| Dashboard siswa | Masih berupa halaman sederhana | Diganti menjadi dashboard lengkap pada `resources/views/siswa/dashboard.blade.php` |
| Dashboard admin | Masih berupa halaman sederhana | Diganti menjadi dashboard lengkap pada `resources/views/admin/dashboard.blade.php` |
| Dashboard tutor | Belum memiliki forum diskusi bersama | Ditambahkan include `components.forum-discussion` pada `resources/views/tutor/dashboard.blade.php` |
| Forum Diskusi | Belum tersimpan sebagai data forum bersama | Menggunakan tabel `forum_topics` dan `forum_replies` |
| Kategori Forum | Belum ada kategori terstruktur | Kategori disimpan pada kolom `category` di tabel `forum_topics` |

### Tujuan

Meningkatkan komunikasi antara admin, siswa, dan tutor melalui satu forum diskusi yang terhubung di tiga dashboard.

---

## Detail Kategori Forum

Kategori forum didefinisikan pada model `App\Models\ForumTopic` melalui method `categories()`.

| Value Program | Label Tampilan | Deskripsi |
| --- | --- | --- |
| `brainy` | Seputar Brainy | Diskusi mengenai informasi dan layanan Brainy |
| `keluhan` | Keluhan | Penyampaian keluhan dari pengguna |
| `pembelajaran` | Pembelajaran | Diskusi materi dan aktivitas pembelajaran |

---

## Impact Analysis

| Komponen | Dampak | Keterangan |
| --- | --- | --- |
| Database | Ya | Penambahan tabel `forum_topics` dan `forum_replies` |
| Migration | Ya | Penambahan migration `2026_06_15_000000_create_forum_topics_table.php` dan `2026_06_15_000001_create_forum_replies_table.php` |
| Model | Ya | Penambahan model `ForumTopic` dan `ForumReply` |
| Controller | Ya | Penambahan controller `ForumController` dengan method `storeTopic()` dan `storeReply()` |
| View / Frontend | Ya | Penambahan komponen `resources/views/components/forum-discussion.blade.php` |
| Route | Ya | Penambahan route `forum.topics.store` dan `forum.replies.store` |
| Middleware | Tidak | Tidak ada middleware baru; route forum berada di dalam group `auth` |
| Dashboard | Ya | Forum ditampilkan di dashboard admin, siswa, dan tutor |

---

## Struktur Database

### Tabel `forum_topics`

Tabel ini dibuat oleh migration `2026_06_15_000000_create_forum_topics_table.php`.

| Kolom | Tipe / Keterangan |
| --- | --- |
| `id` | Primary key |
| `user_id` | Foreign key ke tabel `users`, menggunakan `cascadeOnDelete()` |
| `category` | String maksimal 40 karakter, default `pembelajaran` |
| `title` | String maksimal 120 karakter |
| `body` | Text |
| `created_at` | Timestamp |
| `updated_at` | Timestamp |

### Tabel `forum_replies`

Tabel ini dibuat oleh migration `2026_06_15_000001_create_forum_replies_table.php`.

| Kolom | Tipe / Keterangan |
| --- | --- |
| `id` | Primary key |
| `forum_topic_id` | Foreign key ke tabel `forum_topics`, menggunakan `cascadeOnDelete()` |
| `user_id` | Foreign key ke tabel `users`, menggunakan `cascadeOnDelete()` |
| `body` | Text |
| `created_at` | Timestamp |
| `updated_at` | Timestamp |

---

## Struktur Model

### `App\Models\ForumTopic`

Model `ForumTopic` memakai konstanta kategori:

- `CATEGORY_BRAINY = 'brainy'`
- `CATEGORY_KELUHAN = 'keluhan'`
- `CATEGORY_PEMBELAJARAN = 'pembelajaran'`

Relasi yang digunakan:

- `user()` menggunakan `belongsTo(User::class)`
- `replies()` menggunakan `hasMany(ForumReply::class)->latest()`

Field yang dapat diisi:

- `user_id`
- `category`
- `title`
- `body`

### `App\Models\ForumReply`

Relasi yang digunakan:

- `topic()` menggunakan `belongsTo(ForumTopic::class, 'forum_topic_id')`
- `user()` menggunakan `belongsTo(User::class)`

Field yang dapat diisi:

- `forum_topic_id`
- `user_id`
- `body`

---

## Struktur Controller

Controller yang ditambahkan adalah `App\Http\Controllers\ForumController`.

| Method | Fungsi |
| --- | --- |
| `storeTopic(Request $request)` | Memvalidasi input kategori, judul, dan isi topik, lalu menyimpan data ke tabel `forum_topics` |
| `storeReply(Request $request, ForumTopic $forumTopic)` | Memvalidasi isi balasan, lalu menyimpan data ke tabel `forum_replies` |

Validasi pada `storeTopic()`:

- `category`: wajib dan harus termasuk daftar kategori dari `ForumTopic::categories()`
- `title`: wajib, string, maksimal 120 karakter
- `body`: wajib, string, maksimal 2000 karakter

Validasi pada `storeReply()`:

- `body`: wajib, string, maksimal 1500 karakter

---

## Struktur Route

Route forum didefinisikan pada `routes/web.php` di dalam group middleware `auth`.

| Method HTTP | URL | Name | Controller |
| --- | --- | --- | --- |
| `POST` | `/forum/topics` | `forum.topics.store` | `ForumController@storeTopic` |
| `POST` | `/forum/topics/{forumTopic}/replies` | `forum.replies.store` | `ForumController@storeReply` |

Route dashboard yang menampilkan forum:

| Method HTTP | URL | Name | View |
| --- | --- | --- | --- |
| `GET` | `/admin/dashboard` | `admin.dashboard` | `admin.dashboard` |
| `GET` | `/siswa/dashboard` | `siswa.dashboard` | `siswa.dashboard` |
| `GET` | `/tutor/dashboard` | `tutor.dashboard` | `tutor.dashboard` |

---

## Struktur View / Frontend

Komponen forum dibuat pada:

- `resources/views/components/forum-discussion.blade.php`

Komponen tersebut dipanggil pada:

- `resources/views/admin/dashboard.blade.php`
- `resources/views/siswa/dashboard.blade.php`
- `resources/views/tutor/dashboard.blade.php`

Komponen ikon dashboard dibuat pada:

- `resources/views/components/dashboard-icon.blade.php`

Fungsi utama pada tampilan forum:

- Menampilkan daftar data dari variabel `$forumTopics`.
- Menampilkan kategori dari variabel `$forumCategories`.
- Menampilkan form pembuatan topik baru.
- Menampilkan form balasan pada setiap topik.
- Mengirim topik ke route `forum.topics.store`.
- Mengirim balasan ke route `forum.replies.store`.

---

## Alur Data Forum

1. Pengguna login sebagai admin, siswa, atau tutor.
2. Pengguna membuka salah satu dashboard sesuai role.
3. Route dashboard mengambil data `ForumTopic` beserta relasi `user` dan `replies.user`.
4. Data forum dikirim ke view melalui variabel `$forumTopics` dan `$forumCategories`.
5. Komponen `components.forum-discussion` menampilkan topik dan balasan.
6. Saat pengguna membuat topik baru, form dikirim ke route `forum.topics.store`.
7. Method `storeTopic()` menyimpan data ke tabel `forum_topics`.
8. Saat pengguna membalas topik, form dikirim ke route `forum.replies.store`.
9. Method `storeReply()` menyimpan data ke tabel `forum_replies`.
10. Data yang tersimpan dapat tampil kembali di dashboard admin, siswa, dan tutor.

---

## Risiko dan Mitigasi

| Risiko | Tingkat | Mitigasi |
| --- | --- | --- |
| Tabel `forum_topics` atau `forum_replies` belum dibuat | Sedang | Menjalankan `php artisan migrate` sebelum fitur digunakan |
| Pengguna memilih kategori yang kurang tepat | Rendah | Label kategori ditampilkan jelas di form forum |
| Input terlalu panjang | Rendah | Validasi `max:120`, `max:2000`, dan `max:1500` pada `ForumController` |
| Dashboard error saat migration belum dijalankan | Sedang | Route dashboard mengecek `Schema::hasTable('forum_topics')` dan `Schema::hasTable('forum_replies')` |

---

## Hasil Implementasi

### Database

- Menambahkan tabel `forum_topics`.
- Menambahkan tabel `forum_replies`.
- Kategori forum disimpan langsung pada kolom `category` di tabel `forum_topics`.

### Model

- Menambahkan model `App\Models\ForumTopic`.
- Menambahkan model `App\Models\ForumReply`.

### Controller

- Menambahkan controller `App\Http\Controllers\ForumController`.
- Menambahkan method `storeTopic()`.
- Menambahkan method `storeReply()`.

### Frontend

- Menambahkan dashboard siswa pada `resources/views/siswa/dashboard.blade.php`.
- Menambahkan dashboard admin pada `resources/views/admin/dashboard.blade.php`.
- Menambahkan forum ke dashboard tutor pada `resources/views/tutor/dashboard.blade.php`.
- Menambahkan komponen forum pada `resources/views/components/forum-discussion.blade.php`.
- Menambahkan komponen ikon pada `resources/views/components/dashboard-icon.blade.php`.

### Route

- Menambahkan route `forum.topics.store`.
- Menambahkan route `forum.replies.store`.

---

## Status Implementasi

| Fitur | Nama Program | Status |
| --- | --- | --- |
| Tabel topik forum | `forum_topics` | Selesai |
| Tabel balasan forum | `forum_replies` | Selesai |
| Model topik forum | `ForumTopic` | Selesai |
| Model balasan forum | `ForumReply` | Selesai |
| Controller forum | `ForumController` | Selesai |
| Form topik baru | `forum.topics.store` | Selesai |
| Form balasan | `forum.replies.store` | Selesai |
| Dashboard admin | `resources/views/admin/dashboard.blade.php` | Selesai |
| Dashboard siswa | `resources/views/siswa/dashboard.blade.php` | Selesai |
| Dashboard tutor | `resources/views/tutor/dashboard.blade.php` | Selesai |
| Komponen forum | `components.forum-discussion` | Selesai |

---

## CHANGELOG

```md
## Released - Version 1.1.0

### Added

- Menambahkan forum diskusi bersama untuk dashboard admin, siswa, dan tutor.
- Menambahkan kategori forum:
  - `brainy` dengan label "Seputar Brainy"
  - `keluhan` dengan label "Keluhan"
  - `pembelajaran` dengan label "Pembelajaran"
- Menambahkan tabel `forum_topics`.
- Menambahkan tabel `forum_replies`.
- Menambahkan model `ForumTopic`.
- Menambahkan model `ForumReply`.
- Menambahkan controller `ForumController`.
- Menambahkan route `forum.topics.store`.
- Menambahkan route `forum.replies.store`.
- Menambahkan komponen Blade `components.forum-discussion`.
- Menambahkan komponen Blade `components.dashboard-icon`.

### Impacted Modules

- `routes/web.php`
- `app/Http/Controllers/ForumController.php`
- `app/Models/ForumTopic.php`
- `app/Models/ForumReply.php`
- `resources/views/admin/dashboard.blade.php`
- `resources/views/siswa/dashboard.blade.php`
- `resources/views/tutor/dashboard.blade.php`
- `resources/views/components/forum-discussion.blade.php`
- `resources/views/components/dashboard-icon.blade.php`
- `database/migrations/2026_06_15_000000_create_forum_topics_table.php`
- `database/migrations/2026_06_15_000001_create_forum_replies_table.php`
```

---

## Pembelajaran yang Diperoleh

- Change Impact Analysis membantu mengidentifikasi komponen program yang terdampak.
- Penamaan dokumentasi harus mengikuti nama aktual di kode agar tidak membingungkan saat implementasi dan pengujian.
- Penggunaan komponen Blade `components.forum-discussion` membuat tampilan forum dapat digunakan ulang pada dashboard admin, siswa, dan tutor.

---

## Kesimpulan

Change Request penambahan fitur Forum Diskusi 3 Kategori berhasil diimplementasikan pada Platform Brainy.

Perubahan mencakup penambahan tabel `forum_topics` dan `forum_replies`, model `ForumTopic` dan `ForumReply`, controller `ForumController`, route `forum.topics.store` dan `forum.replies.store`, serta komponen Blade `components.forum-discussion`.

Forum diskusi kini dapat digunakan oleh admin, siswa, dan tutor melalui dashboard masing-masing. Topik dan balasan yang dibuat pengguna disimpan di database dan ditampilkan kembali pada ketiga dashboard tersebut.
