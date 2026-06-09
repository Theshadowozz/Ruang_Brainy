<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Brainy</title>
    @include('layouts.vite')
</head>
<body class="min-h-screen bg-[#f3f8ff] font-sans text-gray-950">
    <header class="border-b border-gray-200 bg-white">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-6 sm:px-10 lg:px-28">
            <a href="{{ url('/') }}" class="flex items-center" aria-label="Brainy">
                <img src="{{ asset('images/logo_brainy.png') }}" alt="Brainy" class="h-11 w-16 object-contain">
            </a>

            <a href="{{ url('/') }}" class="flex items-center gap-2 text-sm font-semibold text-gray-700 transition hover:text-blue-600">
                <span aria-hidden="true">&larr;</span>
                <span>Kembali ke Beranda</span>
            </a>
        </div>
    </header>

    <main class="flex min-h-[calc(100vh-8rem)] items-center justify-center px-4 py-12">
        <section class="w-full max-w-md">
            <div class="mb-7 text-center">
                <h1 class="text-3xl font-bold tracking-normal text-gray-950">Selamat Datang di Brainy</h1>
                <p class="mt-2 text-sm text-gray-600">Daftar untuk memulai perjalanan belajar Anda</p>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-xl shadow-gray-200/80">
                <div class="mb-6 grid grid-cols-2 rounded-full bg-gray-100 p-1 text-sm font-semibold">
                    <a href="{{ route('login') }}" class="rounded-full py-2 text-center text-gray-600 transition hover:text-gray-950">Login</a>
                    <a href="{{ route('register') }}" class="rounded-full bg-white py-2 text-center shadow-sm">Daftar</a>
                </div>

                @if ($errors->any())
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('register.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="mb-1 block text-sm font-semibold text-gray-800">Nama</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required autocomplete="name" placeholder="Masukkan nama lengkap" class="h-11 w-full rounded-lg border border-transparent bg-gray-100 px-4 text-sm outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100">
                    </div>

                    <div>
                        <label for="email" class="mb-1 block text-sm font-semibold text-gray-800">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@email.com" class="h-11 w-full rounded-lg border border-transparent bg-gray-100 px-4 text-sm outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100">
                    </div>

                    <div>
                        <label for="password" class="mb-1 block text-sm font-semibold text-gray-800">Password</label>
                        <input id="password" name="password" type="password" required autocomplete="new-password" placeholder="Minimal 6 karakter" class="h-11 w-full rounded-lg border border-transparent bg-gray-100 px-4 text-sm outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100">
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-1 block text-sm font-semibold text-gray-800">Konfirmasi Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="Masukkan ulang password" class="h-11 w-full rounded-lg border border-transparent bg-gray-100 px-4 text-sm outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100">
                    </div>

                    <button type="submit" class="flex h-11 w-full items-center justify-center gap-2 rounded-lg bg-gray-950 px-4 text-sm font-bold text-white transition hover:bg-blue-700">
                        <span aria-hidden="true">+</span>
                        Daftar Sekarang
                    </button>
                </form>
            </div>

            <p class="mt-6 text-center text-sm text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-700">Login sekarang</a>
            </p>
        </section>
    </main>

    <footer class="border-t border-gray-200 bg-white py-5 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} Brainy Language Institute. All rights reserved.
    </footer>
</body>
</html>
