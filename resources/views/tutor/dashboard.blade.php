@extends('layouts.tutor')

@section('title', 'Dashboard Tutor - Brainy')

@section('content')
    <main class="mx-auto max-w-7xl px-6 py-10 sm:px-10 lg:px-28">
        <p class="text-sm font-semibold uppercase tracking-normal text-blue-600">Dashboard Tutor</p>
        <h1 class="mt-2 text-3xl font-bold">Halo, {{ auth()->user()->name }}</h1>
        <p class="mt-3 max-w-2xl text-gray-600">Anda login sebagai tutor. Halaman ini hanya bisa dibuka oleh akun dengan role tutor.</p>

        <a href="{{ route('tutor.diskusi.index') }}" class="mt-8 inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-3 text-sm font-bold text-white transition hover:bg-blue-700">
            <img src="{{ asset('asset/diskusi.svg') }}" alt="" class="h-5 w-5 object-contain brightness-0 invert">
            Forum Diskusi
        </a>
    </main>
@endsection
