<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Trial - Brainy Course</title>
    @include('layouts.vite')
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <main class="mx-auto flex min-h-screen max-w-3xl items-center px-5 py-10">
        <section class="w-full rounded-3xl border border-slate-200 bg-white p-7 shadow-sm sm:p-10">
            <a href="{{ route('landing') }}" class="text-sm font-bold text-blue-700">← Kembali ke landing page</a>
            <p class="mt-8 text-sm font-extrabold uppercase tracking-widest text-blue-600">Trial Class</p>
            <h1 class="mt-2 text-3xl font-black">Daftar trial sekarang</h1>
            <p class="mt-2 text-slate-500">Isi data berikut. Data pendaftaran akan langsung diterima admin.</p>

            @if (session('success'))
                <div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-bold text-emerald-800">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="mt-6 rounded-xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm font-bold text-rose-800">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('trial.store') }}" method="POST" class="mt-7 grid gap-5 sm:grid-cols-2">
                @csrf
                <label class="sm:col-span-2">
                    <span class="text-sm font-bold">Nama lengkap</span>
                    <input name="full_name" value="{{ old('full_name') }}" required autocomplete="name" class="mt-2 h-12 w-full rounded-xl border border-slate-300 px-4 outline-none focus:border-blue-500">
                </label>
                <label>
                    <span class="text-sm font-bold">Email</span>
                    <input name="email" type="email" value="{{ old('email') }}" required autocomplete="email" class="mt-2 h-12 w-full rounded-xl border border-slate-300 px-4 outline-none focus:border-blue-500">
                </label>
                <label>
                    <span class="text-sm font-bold">Nomor telepon</span>
                    <input name="phone_number" value="{{ old('phone_number') }}" required autocomplete="tel" class="mt-2 h-12 w-full rounded-xl border border-slate-300 px-4 outline-none focus:border-blue-500">
                </label>
                <label>
                    <span class="text-sm font-bold">Password</span>
                    <input name="password" type="password" required autocomplete="new-password" class="mt-2 h-12 w-full rounded-xl border border-slate-300 px-4 outline-none focus:border-blue-500">
                </label>
                <label>
                    <span class="text-sm font-bold">Konfirmasi password</span>
                    <input name="password_confirmation" type="password" required autocomplete="new-password" class="mt-2 h-12 w-full rounded-xl border border-slate-300 px-4 outline-none focus:border-blue-500">
                </label>
                <button class="sm:col-span-2 rounded-xl bg-blue-600 px-6 py-3.5 font-extrabold text-white hover:bg-blue-700">Kirim Pendaftaran Trial</button>
            </form>
        </section>
    </main>
</body>
</html>
