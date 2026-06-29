<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran - Brainy Course</title>
    @include('layouts.vite')
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <main class="mx-auto grid min-h-screen max-w-6xl items-center gap-8 px-5 py-10 lg:grid-cols-[0.85fr_1.15fr]">
        <section class="rounded-2xl bg-gradient-to-br from-blue-700 to-violet-700 p-7 text-white shadow-xl sm:p-9">
            <a href="{{ route('classes.index') }}" class="text-sm font-bold text-blue-100 hover:text-white">← Kembali ke pilihan kelas</a>
            <p class="mt-10 text-sm font-extrabold uppercase tracking-widest text-blue-200">Kelas pilihanmu</p>
            <h1 class="mt-3 text-3xl font-black">{{ $schedule->courseClass->name }}</h1>
            <p class="mt-3 leading-7 text-blue-100">{{ $schedule->courseClass->description }}</p>
            <dl class="mt-8 space-y-5 text-sm">
                <div><dt class="text-blue-200">Bahasa & level</dt><dd class="mt-1 text-lg font-black">{{ $schedule->courseClass->language }} · {{ $schedule->courseClass->level }}</dd></div>
                <div><dt class="text-blue-200">Jadwal</dt><dd class="mt-1 text-lg font-black">{{ $schedule->day }}, {{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }} WIB</dd></div>
                <div><dt class="text-blue-200">Periode</dt><dd class="mt-1 font-bold">{{ $schedule->start_date->format('d M Y') }} - {{ $schedule->end_date->format('d M Y') }}</dd></div>
                <div><dt class="text-blue-200">Tutor</dt><dd class="mt-1 font-bold">{{ $schedule->courseClass->tutor->name }}</dd></div>
                <div><dt class="text-blue-200">Biaya</dt><dd class="mt-1 text-2xl font-black">Rp {{ number_format($schedule->courseClass->price, 0, ',', '.') }}</dd></div>
            </dl>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-9">
            <h2 class="text-3xl font-black">Lengkapi data pendaftaran</h2>
            <p class="mt-2 text-slate-500">Email dan password ini digunakan untuk login setelah pembayaran dikonfirmasi admin.</p>

            @if ($errors->any())
                <div class="mt-6 rounded-xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm font-semibold text-rose-800">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('registration.store', $schedule) }}" method="POST" class="mt-7 grid gap-5 sm:grid-cols-2">
                @csrf
                <label class="sm:col-span-2">
                    <span class="text-sm font-bold">Nama lengkap</span>
                    <input name="full_name" value="{{ old('full_name') }}" required class="mt-2 h-12 w-full rounded-xl border border-slate-300 px-4 outline-none focus:border-blue-500" autocomplete="name">
                </label>
                <label>
                    <span class="text-sm font-bold">Email</span>
                    <input name="email" type="email" value="{{ old('email') }}" required class="mt-2 h-12 w-full rounded-xl border border-slate-300 px-4 outline-none focus:border-blue-500" autocomplete="email">
                </label>
                <label>
                    <span class="text-sm font-bold">Nomor telepon</span>
                    <input name="phone_number" value="{{ old('phone_number') }}" required class="mt-2 h-12 w-full rounded-xl border border-slate-300 px-4 outline-none focus:border-blue-500" autocomplete="tel">
                </label>
                <label>
                    <span class="text-sm font-bold">Password</span>
                    <input name="password" type="password" required class="mt-2 h-12 w-full rounded-xl border border-slate-300 px-4 outline-none focus:border-blue-500" autocomplete="new-password">
                </label>
                <label>
                    <span class="text-sm font-bold">Konfirmasi password</span>
                    <input name="password_confirmation" type="password" required class="mt-2 h-12 w-full rounded-xl border border-slate-300 px-4 outline-none focus:border-blue-500" autocomplete="new-password">
                </label>
                <label class="sm:col-span-2">
                    <span class="text-sm font-bold">Alamat</span>
                    <textarea name="address" rows="4" required class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-blue-500">{{ old('address') }}</textarea>
                </label>
                <button type="submit" class="sm:col-span-2 rounded-xl bg-blue-600 px-6 py-3.5 font-extrabold text-white hover:bg-blue-700">Daftar Kelas</button>
            </form>
        </section>
    </main>
</body>
</html>
