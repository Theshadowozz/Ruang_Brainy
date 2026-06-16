
# 🧠 Ruang Brainy
### Sistem Informasi Manajemen Pembelajaran Terintegrasi — Brainy Course Padang

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![GitHub Actions](https://img.shields.io/badge/GitHub_Actions-2088FF?style=for-the-badge&logo=github-actions&logoColor=white)


Brainy adalah platform kursus bahasa asing berbasis web yang dikembangkan untuk kebutuhan Project Based Learning (PBL). Sistem ini dirancang untuk membantu proses pendaftaran kelas, pengelolaan jadwal, waiting list, pembayaran, dan aktivitas belajar bahasa asing secara terpusat.


**Ruang Brainy** adalah platform web terintegrasi yang dikembangkan untuk mendukung digitalisasi operasional **Brainy Course**, sebuah lembaga kursus bahasa (Inggris, Jepang, dan Korea) yang berlokasi di Jl. Alai Parak Kopi, Padang.

### Masalah yang Diselesaikan
Saat ini operasional Brainy Course masih bersifat konvensional (manual). Proses pendaftaran, pengecekan jadwal, dan pembayaran dilakukan secara manual, sehingga lambat dan rentan terhadap kesalahan. Komunikasi dengan calon siswa pun masih bergantung pada aplikasi pihak ketiga yang terpisah-pisah.

### Tujuan Aplikasi
- Mengotomasi proses pendaftaran kursus dan pengelolaan waiting list
- Menyediakan sistem pembayaran online yang terverifikasi langsung di dalam platform
- Menyediakan fitur pembelajaran interaktif (audio listening & kuis)
- Menyatukan komunikasi admin dan customer dalam satu platform terpadu

### Target Pengguna
| Peran | Deskripsi |
|-------|-----------|
| 👨‍💼 Admin | Staf Brainy Course yang mengelola kelas, data siswa, dan transaksi |
| 👩‍🏫 Tutor | Pengajar yang mengelola jadwal dan materi pembelajaran |
| 🎓 Siswa | Calon dan siswa aktif Brainy Course dari semua jenjang usia |

### Relevansi SDGs
- 🎓 **SDG 4** — Quality Education: Mempermudah akses materi bahasa bagi semua kalangan melalui teknologi digital
- 💼 **SDG 8** — Decent Work & Economic Growth: Mendukung pertumbuhan lembaga pendidikan lokal
- 🏗️ **SDG 9** — Industry, Innovation & Infrastructure: Digitalisasi lembaga konvensional menuju sistem berbasis cloud

---
>>>>>>> 7c6cc12e0f9a61c3121e884ec81cc2bec0d228b4

Brainy membantu mengurangi pencatatan manual pada proses kursus bahasa, terutama untuk data kelas, jadwal, kapasitas kelas, pendaftaran peserta, antrean waiting list, dan status pembayaran.


### 🖥️ Fitur Base Web
- **Dashboard Admin** — Kelola kelas, data customer, dan monitoring transaksi secara real-time
- **Pendaftaran Online & Katalog Kelas** — Cek ketersediaan dan daftar kelas online/offline
- **Waiting List Otomatis** — Antrian otomatis jika kuota kelas sudah penuh
- **Integrasi Pembayaran** — Pembayaran digital langsung di dalam web via Payment Gateway
- **Direct Chat** — Komunikasi langsung antara admin dan customer tanpa aplikasi pihak ketiga
- **Profil Tutor** — Informasi detail kualifikasi dan jadwal pengajar
- **Info Level Kelas** — Detail kurikulum dan tingkatan kelas yang tersedia
- **Jadwal Kelas Fleksibel** — Sinkronisasi ketersediaan waktu tutor dan siswa
- **Kelas Trial** — Informasi dan pendaftaran kelas percobaan
- **Lokasi & Maps** — Integrasi Google Maps untuk petunjuk arah ke lembaga
- **Galeri Prestasi & Testimoni** — Menampilkan pencapaian dan ulasan siswa

### 📚 Fitur Pembelajaran
- **Audio Listening** — Materi pembelajaran berbasis audio yang interaktif
- **Kuis Interaktif** — Kuis dengan pertanyaan acak (randomized) per sesi
- **Forum Diskusi** — Ruang tanya jawab antara siswa dan tutor
- **Fitur Translate** — Terjemahan teks materi berbasis NLP (Google Cloud / OpenAI API)

### ⚙️ Fitur Sistem
- **Multi-Level Authentication** — Hak akses terpisah untuk Admin, Tutor, dan Siswa
- **CMS (Content Management System)** — Admin dapat melakukan CRUD konten secara mandiri
- **Responsive Design** — Tampilan optimal di desktop maupun mobile

---

## 🛠️ Tech Stack

| Kategori | Teknologi |
|----------|-----------|
| **Backend Framework** | Laravel (PHP) |
| **Database** | MySQL |
| **Frontend** | Bootstrap, Blade Template |
| **AI / NLP** | OpenAI API / Google Cloud Translation |
| **Payment** | Payment Gateway (Midtrans/Xendit) |
| **Maps** | Google Maps API |
| **Version Control** | Git & GitHub |
| **Project Management** | Trello / Notion |
| **Collaboration** | Google Workspace, WhatsApp Group |
| **Deployment** | Cloud Hosting + Domain |

---

## ⚙️ Instalasi

### Prasyarat
- PHP >= 8.1
- Composer
- MySQL
- Node.js & NPM

### Langkah Instalasi

```bash
# 1. Clone repositori
git clone https://github.com/username/ruang-brainy.git
cd ruang-brainy

# 2. Install dependensi PHP
composer install

# 3. Install dependensi Node
npm install && npm run build

# 4. Salin file environment
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Konfigurasi database di file .env
# DB_DATABASE=ruang_brainy
# DB_USERNAME=root
# DB_PASSWORD=

# 7. Jalankan migrasi & seeder
php artisan migrate --seed

# 8. Jalankan server lokal
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

---

## 📸 Screenshot

![Login](https://github.com/user-attachments/assets/80263c8c-78f9-48cf-9294-e698b85376da)
![Dashboard](https://github.com/user-attachments/assets/426aa75f-3688-4bc6-9ccf-f0fa0a3492ae)
![Daftar Kelas Online](https://github.com/user-attachments/assets/8289e99f-1590-4dec-83f5-a8d33565a0ef)

---

## 👥 Tim Pengembang — Kelompok 5 (TRPL2B)

| Peran | Nama | NIM |
|-------|------|-----|
| 🧑‍💼 Project Manager | Rifqi Reswarra Putra Nugraha | 2411081021 |
| 🔍 System Analyst | Khalisa Mutiara Adrila | 2411081013 |
| 💻 Lead Programmer | Ravi Andito | 2411082019 |
| 🤖 AI Specialist | Nabila Rahmadhani | 2411082017 |
| ✅ Quality Assurance | Iqbal Putra Ananda | 2411081011 |

---

## 🏫 Dosen Pengampu

| Mata Kuliah | Dosen |
|-------------|-------|
| Manajemen Proyek PL | Fazrol Rozi, M.Sc & Indri Rahmayuni, S.T., M.T |
| Analisis & Perancangan | Dr. Yulherniwati, S.Kom., M.T & Rita Afyenni, S.Kom., M.Kom |
| Pemrograman Web | Deni Satria & Yori Adi Atma, S.Pd., M.Kom |
| Kecerdasan Buatan | Ainil Mardiah, M.Cs. & Nurraudya Tuz Zahra, S.Si., M.C.S.(AI) |
| QA & Pengujian | Yulia Jihan Sy, S.Kom., M.Kom & Rozi Meri, S.Kom., M.Kom |
| Konstruksi & Evolusi | Defni, S.Si., M.Kom & Mutia Rahmi Dewi, S.Kom., M.Kom |
| Komunikasi Bisnis | Rayendra, S.T, M.Kom. & Eko Purnomo, S.Ds, M.Sn |

---

## 📄 Lisensi

Proyek ini dikembangkan untuk keperluan akademik dalam rangka mata kuliah Project-Based Learning (PBL) Semester Genap 2024/2025.

---

<p align="center">
  Dikembangkan dengan ❤️ oleh <strong>Kelompok 5 TRPL2B</strong> untuk <strong>Brainy Course Padang</strong>
</p>
>>>>>>> 7c6cc12e0f9a61c3121e884ec81cc2bec0d228b4
