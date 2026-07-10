@extends('layouts.siswa')

@section('title', 'Kelas Kursus - Brainy')

@section('content')
<div class="bg-blue-700 px-6 py-10 text-white sm:px-10 lg:px-28">
    <div class="mx-auto max-w-7xl">
        @include('siswa.partials.back-button', ['fallback' => route('siswa.dashboard')])
        <h1 class="mt-7 text-3xl font-extrabold sm:text-4xl">Kelas Kursus</h1>
        <p class="mt-2 text-blue-100">Daftar kelas dan jadwal berikut berasal dari input admin.</p>
    </div>
</div>

<main class="mx-auto max-w-7xl space-y-7 px-6 py-8 sm:px-10 lg:px-28">
    <form method="GET" action="{{ route('siswa.kelas-kursus.index') }}" class="grid gap-4 rounded-xl border border-gray-200 bg-white p-5 shadow-sm md:grid-cols-2">
        <select name="bahasa" onchange="this.form.submit()" class="h-11 rounded-lg border border-gray-300 px-3">
            <option value="">Semua Bahasa</option>
            @foreach (['Inggris', 'Jepang', 'Korea'] as $language)<option @selected($filterBahasa === $language)>{{ $language }}</option>@endforeach
        </select>
        <select name="level" onchange="this.form.submit()" class="h-11 rounded-lg border border-gray-300 px-3">
            <option value="">Semua Level</option>
            @foreach (['Beginner', 'Intermediate', 'Advance'] as $level)<option @selected($filterLevel === $level)>{{ $level }}</option>@endforeach
        </select>
    </form>

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($courses as $course)
            @php
                $capacity = $course->schedules->sum('capacity');
                $occupied = $course->schedules->sum('occupied_seats');
            @endphp
            <article class="flex flex-col justify-between rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div>
                    <div class="flex gap-2"><span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">{{ $course->language }}</span><span class="rounded-full bg-violet-50 px-3 py-1 text-xs font-bold text-violet-700">{{ $course->level }}</span></div>
                    <h2 class="mt-4 text-xl font-extrabold">{{ $course->name }}</h2>
                    <p class="mt-2 text-sm leading-6 text-gray-600">{{ $course->description }}</p>
                    <dl class="mt-5 space-y-2 text-sm">
                        <div><dt class="text-gray-500">Tutor</dt><dd class="font-bold">{{ $course->tutor->name }}</dd></div>
                        <div><dt class="text-gray-500">Jadwal tersedia</dt><dd class="font-bold">{{ $course->schedules->count() }}</dd></div>
                        <div><dt class="text-gray-500">Kursi terisi</dt><dd class="font-bold">{{ $occupied }}/{{ $capacity }}</dd></div>
                    </dl>
                </div>
                <div class="mt-6">
                    <p class="text-2xl font-black text-blue-700">Rp {{ number_format($course->price, 0, ',', '.') }}</p>
                    <a href="{{ route('siswa.kelas-kursus.show', $course) }}" class="mt-3 flex justify-center rounded-lg bg-gray-950 px-4 py-3 text-sm font-bold text-white">Lihat Jadwal</a>
                </div>
            </article>
        @empty
            <div class="rounded-xl border border-dashed border-gray-300 bg-white p-12 text-center text-gray-400 md:col-span-2 xl:col-span-3">Tidak ada kelas yang cocok dengan filter.</div>
        @endforelse
    </div>
</main>
@endsection
