@extends('layouts.tutor')

@section('title', 'Dashboard Tutor - Brainy')

@section('content')
<div class="bg-blue-700 px-6 py-12 text-white sm:px-10 lg:px-28">
    <div class="mx-auto max-w-7xl">
        <p class="text-sm font-semibold uppercase tracking-wider text-blue-200">Dashboard Tutor</p>
        <h1 class="mt-2 text-3xl font-extrabold sm:text-4xl">Selamat datang, {{ $tutor?->name ?? auth()->user()->name }}!</h1>
        <p class="mt-3 text-blue-100">Jadwal di halaman ini hanya berasal dari kelas yang ditugaskan admin kepada akun Anda.</p>
    </div>
</div>

<main class="mx-auto max-w-7xl space-y-8 px-6 py-10 sm:px-10 lg:px-28">
    @if (! $tutor)
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-5 font-bold text-amber-800">Akun login ini belum terhubung dengan profil tutor. Hubungi admin untuk melengkapinya.</div>
    @endif

    <section class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ([
            ['Kelas Saya', $stats['classes']],
            ['Jadwal Mengajar', $stats['schedules']],
            ['Siswa Aktif', $stats['students']],
            ['Total Kapasitas', $stats['capacity']],
        ] as [$label, $value])
            <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wide text-gray-500">{{ $label }}</p>
                <p class="mt-2 text-3xl font-extrabold text-blue-700">{{ $value }}</p>
            </article>
        @endforeach
    </section>

    <section>
        <div class="mb-4 flex items-center justify-between">
            <div><h2 class="text-xl font-extrabold">Semua Jadwal Mengajar</h2><p class="mt-1 text-sm text-gray-500">Setiap jadwal yang admin buat untuk kelas Anda tampil di bawah.</p></div>
            <a href="{{ route('tutor.classes') }}" class="text-sm font-bold text-blue-700">Lihat kelas</a>
        </div>
        <div class="grid gap-5 lg:grid-cols-2">
            @forelse ($schedules as $schedule)
                <article class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div><span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">{{ $schedule->courseClass->language }} · {{ $schedule->courseClass->level }}</span><h3 class="mt-3 text-lg font-extrabold">{{ $schedule->courseClass->name }}</h3></div>
                        <span class="rounded-lg bg-emerald-50 px-3 py-2 text-sm font-black text-emerald-700">{{ $schedule->students_count }} siswa</span>
                    </div>
                    <dl class="mt-5 grid grid-cols-2 gap-4 text-sm">
                        <div><dt class="text-gray-500">Hari</dt><dd class="mt-1 font-bold">{{ $schedule->day }}</dd></div>
                        <div><dt class="text-gray-500">Jam</dt><dd class="mt-1 font-bold">{{ substr($schedule->start_time, 0, 5) }}–{{ substr($schedule->end_time, 0, 5) }}</dd></div>
                        <div><dt class="text-gray-500">Periode</dt><dd class="mt-1 font-bold">{{ $schedule->start_date->format('d/m/Y') }}–{{ $schedule->end_date->format('d/m/Y') }}</dd></div>
                        <div><dt class="text-gray-500">Ruangan</dt><dd class="mt-1 font-bold">{{ $schedule->room }}</dd></div>
                    </dl>
                </article>
            @empty
                <div class="rounded-xl border border-dashed border-gray-300 bg-white p-12 text-center text-gray-400 lg:col-span-2">Admin belum menambahkan jadwal untuk kelas Anda.</div>
            @endforelse
        </div>
    </section>
</main>
@endsection
