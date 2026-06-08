# Installation Guide

## System Requirements

Sebelum menjalankan aplikasi, pastikan perangkat telah terinstall:

* PHP 8.2 atau lebih baru
* Composer
* MySQL / MariaDB
* Node.js dan NPM
* Git

---

## Clone Repository

```bash
git clone https://github.com/Theshadowozz/Ruang_Brainy.git
cd Ruang_Brainy
```

---

## Install Dependencies

### Backend Dependency

```bash
composer install
```

### Frontend Dependency

```bash
npm install
```

---

## Environment Setup

Salin file environment:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

---

## Database Setup

Buat database baru pada MySQL.

Contoh:

```sql
CREATE DATABASE ruang_brainy;
```

Sesuaikan konfigurasi database pada file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ruang_brainy
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan migrasi:

```bash
php artisan migrate
```

Jika terdapat data awal (seeder):

```bash
php artisan db:seed
```

---

## Menjalankan Aplikasi

Jalankan server Laravel:

```bash
php artisan serve
```

Aplikasi dapat diakses melalui:

```text
http://127.0.0.1:8000
```

---

## Troubleshooting

### Permission Error

```bash
chmod -R 775 storage bootstrap/cache
```

### Clear Cache

```bash
php artisan optimize:clear
```

### Generate Key Ulang

```bash
php artisan key:generate
```
