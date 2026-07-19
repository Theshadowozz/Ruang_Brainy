@extends('layouts.siswa')

@section('title', $course->name.' - Brainy')

@section('content')
<div class="bg-blue-700 px-6 py-10 text-white sm:px-10 lg:px-28">
    <div class="mx-auto max-w-7xl">
        @include('siswa.partials.back-button', ['fallback' => route('siswa.kelas-kursus.index')])
        <div class="mt-7 flex gap-2"><span class="rounded-full bg-white/15 px-3 py-1 text-xs font-bold">{{ $course->language }}</span><span class="rounded-full bg-white/15 px-3 py-1 text-xs font-bold">{{ $course->level }}</span></div>
        <h1 class="mt-3 text-3xl font-extrabold sm:text-4xl">{{ $course->name }}</h1>
        <p class="mt-3 max-w-3xl text-blue-100">{{ $course->description }}</p>
    </div>
</div>

<main class="mx-auto max-w-7xl px-6 py-8 sm:px-10 lg:px-28">
    <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col justify-between gap-5 border-b border-gray-100 pb-5 sm:flex-row">
            <div><p class="text-sm text-gray-500">Tutor</p><p class="mt-1 text-lg font-extrabold">{{ $course->tutor->name }}</p><p class="text-sm text-gray-500">{{ $course->tutor->expertise }} · {{ $course->tutor->email }}</p></div>
            <div class="sm:text-right"><p class="text-sm text-gray-500">Biaya</p><p class="mt-1 text-2xl font-black text-blue-700">Rp {{ number_format($course->price, 0, ',', '.') }}</p></div>
        </div>

        <h2 class="mt-6 text-lg font-extrabold">Pilih jadwal</h2>
        <div class="mt-4 grid gap-4 md:grid-cols-2">
            @forelse ($course->schedules as $schedule)
                @php
                    $remaining = max($schedule->capacity - $schedule->occupied_seats, 0);
                @endphp
                <article class="rounded-lg border border-gray-200 p-5">
                    <div class="flex items-start justify-between gap-4"><h3 class="font-extrabold">{{ $schedule->day }}</h3><span class="rounded-full px-3 py-1 text-xs font-bold {{ $remaining ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">{{ $remaining }} kursi</span></div>
                    <p class="mt-2 text-sm text-gray-600">{{ substr($schedule->start_time, 0, 5) }}–{{ substr($schedule->end_time, 0, 5) }} · {{ $schedule->room }}</p>
                    <p class="mt-1 text-xs text-gray-500">{{ $schedule->start_date->format('d/m/Y') }}–{{ $schedule->end_date->format('d/m/Y') }}</p>
                    <a href="{{ route('registration.create', $schedule) }}" class="mt-4 flex justify-center rounded-lg px-4 py-3 text-center text-sm font-bold text-white {{ $remaining ? 'bg-blue-600' : 'bg-amber-600' }}">{{ $remaining ? 'Daftar Jadwal Ini' : 'Daftar & Bayar untuk Waiting List' }}</a>
                </article>
            @empty
                <p class="text-sm text-gray-400">Belum ada jadwal aktif untuk kelas ini.</p>
            @endforelse
        </div>
    </section>
</main>
@endsection
