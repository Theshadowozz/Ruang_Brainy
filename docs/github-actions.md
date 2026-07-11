# G. GitHub Actions Documentation

**File:**

```text
docs/github_actions.md
```

---

## Workflow yang Digunakan

Workflow GitHub Actions digunakan untuk melakukan proses **Continuous Integration (CI)** secara otomatis pada project Laravel. Workflow ini akan menyiapkan environment PHP, menginstal seluruh dependency menggunakan Composer, membuat konfigurasi aplikasi Laravel, membuat database SQLite untuk pengujian, kemudian menjalankan seluruh Unit Test dan Feature Test menggunakan Laravel Artisan.

---

## Lokasi File

```text
.github/workflows/laravel.yml
```

---

## Trigger

Workflow akan dijalankan secara otomatis ketika terjadi:

- **Push** ke branch `main`
- **Pull Request** ke branch `main`

Konfigurasi trigger:

```yaml
on:
  push:
    branches: [ "main" ]
  pull_request:
    branches: [ "main" ]
```

---

## Tahapan Workflow

### 1. Setup PHP

Menginstal PHP versi **8.2** yang digunakan oleh project Laravel.

```yaml
- uses: shivammathur/setup-php@...
  with:
    php-version: '8.2'
```

---

### 2. Checkout Source Code

Mengambil source code terbaru dari repository GitHub.

```yaml
- uses: actions/checkout@v4
```

---

### 3. Copy Environment File

Membuat file `.env` secara otomatis apabila file tersebut belum tersedia.

```yaml
- name: Copy .env
  run: php -r "file_exists('.env') || copy('.env.example', '.env');"
```

---

### 4. Install Dependencies

Menginstal seluruh dependency project Laravel menggunakan Composer.

```yaml
- name: Install Dependencies
  run: composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist
```

---

### 5. Generate Application Key

Membuat **APP_KEY** yang diperlukan oleh Laravel.

```yaml
- name: Generate key
  run: php artisan key:generate
```

---

### 6. Mengatur Hak Akses Direktori

Memberikan hak akses pada folder yang digunakan Laravel untuk menyimpan cache dan file sementara.

Folder yang diberikan permission:

- `storage`
- `bootstrap/cache`

```yaml
- name: Directory Permissions
  run: chmod -R 777 storage bootstrap/cache
```

---

### 7. Membuat Database SQLite

Membuat file database SQLite yang digunakan selama proses pengujian.

```yaml
- name: Create Database
  run: |
    mkdir -p database
    touch database/database.sqlite
```

---

### 8. Menjalankan Pengujian

Menjalankan seluruh Unit Test dan Feature Test menggunakan Laravel Artisan dengan konfigurasi database SQLite.

```yaml
- name: Execute tests (Unit and Feature tests) via PHPUnit/Pest
  env:
    DB_CONNECTION: sqlite
    DB_DATABASE: database/database.sqlite
  run: php artisan test
```

---

## Environment yang Digunakan

| Komponen | Konfigurasi |
|----------|-------------|
| Operating System | Ubuntu Latest |
| PHP | 8.2 |
| Framework | Laravel |
| CSS Framework | Tailwind CSS |
| Dependency Manager | Composer |
| Database Testing | SQLite |
| Testing Framework | PHPUnit / Pest |

---

## Alur Workflow

1. GitHub mendeteksi **Push** atau **Pull Request** pada branch `main`.
2. GitHub Actions membuat runner dengan sistem operasi **Ubuntu Latest**.
3. Menginstal PHP versi **8.2**.
4. Mengambil source code dari repository.
5. Membuat file `.env`.
6. Menginstal dependency menggunakan Composer.
7. Membuat **Application Key** Laravel.
8. Memberikan permission pada folder `storage` dan `bootstrap/cache`.
9. Membuat database SQLite untuk proses testing.
10. Menjalankan seluruh Unit Test dan Feature Test menggunakan perintah `php artisan test`.

---

## Tujuan Penggunaan GitHub Actions

Implementasi GitHub Actions pada project ini bertujuan untuk:

- Mengotomatisasi proses pengujian aplikasi setiap terjadi perubahan kode.
- Memastikan seluruh dependency berhasil diinstal sebelum aplikasi dijalankan.
- Menjamin konfigurasi Laravel telah siap digunakan pada lingkungan CI.
- Memastikan seluruh Unit Test dan Feature Test berhasil dijalankan.
- Membantu menjaga kualitas kode sebelum perubahan digabungkan ke branch utama.
