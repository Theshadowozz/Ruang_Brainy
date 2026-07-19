# Setup Midtrans Brainy Course

Integrasi memakai package resmi `midtrans/midtrans-php` 2.6, Snap, webhook, dan rekonsiliasi Get Status API.

## Environment

Salin `.env.example` menjadi `.env`, lalu isi kredensial dari Midtrans Dashboard:

```dotenv
MIDTRANS_SERVER_KEY=SB-Mid-server-...
MIDTRANS_CLIENT_KEY=SB-Mid-client-...
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
PAYMENT_ADMIN_FEE=2500
PAYMENT_EXPIRY_HOURS=24
```

Ambil `Server Key` dan `Client Key` dari Midtrans Dashboard pada **Settings > Access Keys > API Keys**. Sandbox memakai key berawalan `SB-` dan `MIDTRANS_IS_PRODUCTION=false`; Production memakai key live dan nilai `true`. Jangan campur environment.

- `MIDTRANS_SERVER_KEY`: secret; backend saja. Jangan taruh di Blade/JavaScript/log/git.
- `MIDTRANS_CLIENT_KEY`: dipakai Snap.js di browser.
- `MIDTRANS_IS_SANITIZED`: sanitasi payload SDK.
- `MIDTRANS_IS_3DS`: aktifkan 3DS untuk transaksi kartu.
- `PAYMENT_ADMIN_FEE`: biaya yang baru terlihat pada checkout.
- `PAYMENT_EXPIRY_HOURS`: masa reservasi kursi/order awal.

Setelah mengubah `.env`, jalankan `php artisan config:clear`. Jangan commit `.env` atau key nyata.

## Pricing

`config/course_pricing.php` menetapkan harga dalam IDR:

- Beginner: 350000
- Intermediate: 375000
- Advance: 400000
- Admin fee: 2500

`App\Services\CoursePricingService` menyediakan `subtotalFor(string $level)` dan `breakdown(string $level)`.

## Gateway

`App\Contracts\PaymentGateway` menyediakan:

- `createSnapToken(Payment $payment): string`
- `transactionStatus(string $orderId): array`

`App\Services\MidtransPaymentGateway` memakai `Snap::createTransaction()` dan `Transaction::status()`. Contract sudah dibinding singleton di `App\Providers\AppServiceProvider`.

Sebelum meminta Snap token, payment harus punya `order_id`, `subtotal`, `admin_fee`, dan `amount`. `createSnapToken()` menyimpan `snap_token` serta `snap_token_created_at`.

## Database

Jalankan:

```bash
php artisan migrate
```

Migration baru menambah metadata Midtrans dan refund pada `payments`, serta `access_starts_at`, `access_ends_at`, dan `seat_reserved_until` pada `registrations`. Migration lama tidak diubah. Kolom status lama tetap enum agar migration tidak bergantung pada perubahan enum; refund ditandai dengan `refunded_at` dan dapat memakai status `cancelled`.

`Registration` mendukung `payments()`, `latestPayment()`, `hasActiveAccess()`, dan relasi kompatibilitas `payment()` untuk kode lama.

## Notification URL

Atur **Payment Notification URL** pada Midtrans Dashboard:

```text
https://DOMAIN-APLIKASI/webhooks/midtrans
```

URL production wajib HTTPS. Untuk Sandbox lokal, gunakan tunnel HTTPS publik seperti ngrok, lalu isi URL tunnel tersebut. Route ini dikecualikan dari CSRF, tetapi setiap request diverifikasi dengan signature SHA-512, order ID, dan nominal tersimpan.

Browser callback Snap hanya memberi informasi UI. Aktivasi akun hanya terjadi setelah webhook valid berstatus `settlement` atau `capture` dengan fraud status diterima.

## Sandbox end-to-end

1. Jalankan `php artisan migrate` dan `php artisan config:clear`.
2. Jalankan aplikasi serta tunnel HTTPS.
3. Daftar kelas dan buka checkout.
4. Bayar dengan Simulator Midtrans Sandbox.
5. Pastikan route webhook menerima notification dan `payments.status` berubah menjadi `paid`.
6. Jika kursi tersedia, registration menjadi `accepted`; jika penuh, tetap `waiting_list` sampai admin mempromosikannya.
7. Jika webhook terlambat, jalankan `php artisan payments:reconcile-midtrans`.

## Production

Ganti dengan key Production, set `MIDTRANS_IS_PRODUCTION=true`, gunakan domain HTTPS final, lalu perbarui Notification URL pada Dashboard Production. Uji transaksi nominal kecil sebelum membuka sistem untuk siswa.

## Referensi resmi

- SDK: https://github.com/Midtrans/midtrans-php
- Access Keys: https://docs.midtrans.com/docs/access-keys
- Snap.js: https://docs.midtrans.com/reference/snap-js
- HTTP Notification: https://docs.midtrans.com/reference/http-notification
