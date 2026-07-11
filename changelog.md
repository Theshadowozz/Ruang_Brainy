# Changelog

Semua perubahan penting pada proyek Brainy dicatat di dokumen ini. Format changelog mengikuti pola sederhana: `Added`, `Changed`, `Fixed`, `Removed`, dan `Documentation`.

## [Unreleased]

### Added
- Menambahkan pendaftaran trial berisi nama, email, password, dan nomor telepon yang tersimpan ke database serta tampil pada dashboard admin.
- Menambahkan pengelolaan profil tutor beserta akun login individual yang dibuat oleh admin.
- Menambahkan dashboard admin berbasis database untuk siswa aktif, pendaftar trial, pembayaran, tutor, kelas, dan waiting list.
- Menambahkan pengujian alur pendaftaran trial dan pembuatan akun tutor.

### Changed
- Menghubungkan katalog kelas pendaftaran, jadwal, pendaftaran siswa, pembayaran, dashboard siswa, dashboard admin, dan dashboard tutor ke data database.
- Memisahkan informasi promosi kelas dan tutor pada landing page dari database; landing page menampilkan tiga program bahasa umum dan profil tim pengajar tetap.
- Menampilkan kelas dan jadwal input admin pada katalog pendaftaran siswa.
- Menampilkan pendaftaran siswa pada dashboard admin setelah pembayaran dikonfirmasi.
- Membatasi kelas dan jadwal dashboard tutor berdasarkan profil tutor yang terhubung dengan akun login.
- Mengganti form ringkas trial pada landing page menjadi tombol `Daftar Sekarang` menuju form pendaftaran trial.
- Menghapus data contoh kelas, tutor, siswa, pembayaran, dan waiting list dari `localStorage` serta seeder utama.

### Fixed
- Mengaktifkan kembali route fitur kelas, jadwal, quiz, translate, dan diskusi siswa yang sebelumnya belum terdaftar.
- Mengganti angka hardcode audio dan quiz pada dashboard siswa dengan hasil perhitungan database.
- Memperbaiki relasi model dashboard siswa yang sebelumnya didefinisikan sebagai model bayangan di dalam controller.
- Mempertahankan akun siswa yang sudah aktif ketika pembayaran kelas tambahan ditolak.

### Documentation
- Menyiapkan README sebagai dokumentasi utama proyek.
- Merapikan installation documentation untuk kebutuhan setup lokal.
- Menambahkan dependency documentation pada `docs/dependency.md`.
- Menambahkan template refactoring documentation untuk tahap final.
- Menambahkan template GitHub Actions documentation untuk tahap final.
- Menandai feature documentation sebagai dokumen yang belum diperbarui sampai analisis kebutuhan selesai.

### Dependency
- Belum ada dependency baru yang diinstall pada perubahan dokumentasi ini.
- Dependency aktual didokumentasikan berdasarkan `composer.json` dan `package.json`.

### Refactor
- Memisahkan controller landing page, trial, dashboard admin, data siswa, tutor, waiting list, dan dashboard tutor sesuai tanggung jawabnya.

## [0.1.0] - 2026-06-08

### Added
- Initial Laravel project setup.
- Struktur database awal untuk users, tutors, classes, schedules, registrations, waiting lists, dan payments.
- Struktur dokumentasi proyek PBL.
- Dokumentasi instalasi awal.
- Template dokumentasi feature, dependency, refactoring, dan GitHub Actions.

### Documentation
- Menambahkan README awal.
- Menambahkan changelog awal untuk pelacakan progres mingguan.
