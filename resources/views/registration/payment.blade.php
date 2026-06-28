<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pembayaran - Brainy Course</title>
    @include('layouts.vite')
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <main class="mx-auto flex min-h-screen max-w-3xl items-center px-5 py-10">
        <section class="w-full rounded-3xl border border-slate-200 bg-white p-7 shadow-sm sm:p-10">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-100 text-2xl text-blue-700">✓</div>
            <h1 class="mt-6 text-3xl font-black">Pendaftaran berhasil dibuat</h1>
            <p class="mt-3 leading-7 text-slate-600">Akun <strong>{{ $registration->user->email }}</strong> belum dapat login sampai pembayaran dikonfirmasi admin.</p>

            @if (session('success'))
                <div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
            @endif

            <div class="mt-8 rounded-2xl bg-slate-50 p-6">
                <div class="flex flex-col justify-between gap-5 sm:flex-row">
                    <div>
                        <p class="text-sm font-semibold text-slate-500">Kelas</p>
                        <p class="mt-1 text-lg font-black">{{ $registration->schedule->courseClass->name }}</p>
                        <p class="mt-1 text-sm text-slate-600">{{ $registration->schedule->day }}, {{ substr($registration->schedule->start_time, 0, 5) }} - {{ substr($registration->schedule->end_time, 0, 5) }} WIB</p>
                    </div>
                    <div class="sm:text-right">
                        <p class="text-sm font-semibold text-slate-500">Total</p>
                        <p class="mt-1 text-2xl font-black text-blue-700">Rp {{ number_format($registration->payment->amount, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-7">
                @if ($registration->payment->status === 'paid')
                    <div class="rounded-xl bg-emerald-50 px-5 py-4 font-bold text-emerald-800">Pembayaran terkonfirmasi. Akunmu sudah aktif dan dapat digunakan untuk login.</div>
                    <a href="{{ route('login') }}" class="mt-4 inline-flex w-full justify-center rounded-xl bg-blue-600 px-6 py-3.5 font-extrabold text-white hover:bg-blue-700">Masuk ke Akun</a>
                @elseif ($registration->payment->status === 'failed')
                    <div class="rounded-xl bg-rose-50 px-5 py-4 font-bold text-rose-800">Pembayaran ditolak admin. Silakan hubungi admin Brainy Course.</div>
                @elseif ($registration->payment->transaction_code)
                    <div class="rounded-xl bg-amber-50 px-5 py-4 font-bold text-amber-800">Pembayaran simulasi sudah dilakukan. Status: menunggu konfirmasi admin.</div>
                    <p class="mt-3 text-center text-sm text-slate-500">Kode transaksi: {{ $registration->payment->transaction_code }}</p>
                @else
                    <form action="{{ route('registration.payment.pay', $registration) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full rounded-xl bg-blue-600 px-6 py-3.5 font-extrabold text-white hover:bg-blue-700">Lakukan Pembayaran</button>
                    </form>
                    <p class="mt-3 text-center text-sm text-slate-500">Untuk saat ini tombol ini hanya mensimulasikan pembayaran.</p>
                @endif
            </div>

            <div class="mt-8 flex justify-center gap-5 text-sm font-bold">
                <a href="{{ url('/') }}" class="text-slate-600 hover:text-blue-700">Kembali ke landing page</a>
                <a href="{{ route('classes.index') }}" class="text-blue-700">Lihat kelas lain</a>
            </div>
        </section>
    </main>
</body>
</html>
