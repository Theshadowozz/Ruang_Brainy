<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Brainy</title>
    @include('layouts.vite')
</head>
<body class="bg-white font-sans text-gray-950">
    @include('layouts.header')

    <main class="mx-auto max-w-7xl px-6 py-10 sm:px-10 lg:px-28">
        <p class="text-sm font-semibold uppercase tracking-normal text-blue-600">Dashboard Admin</p>
        <h1 class="mt-2 text-3xl font-bold">Halo, {{ auth()->user()->name }}</h1>
        <p class="mt-3 max-w-2xl text-gray-600">Anda login sebagai admin. Halaman ini hanya bisa dibuka oleh akun dengan role admin.</p>
    </main>
</body>
</html>