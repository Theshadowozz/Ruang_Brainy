@extends('layouts.siswa')

@section('title', 'Jadwal Saya - Brainy')

@section('content')
@php
    $tabs = [
        'aktif' => [
            'label' => 'Kelas Aktif',
            'description' => 'Pantau kelas yang sedang berjalan',
        ],
        'selesai' => [
            'label' => 'Kelas Selesai',
            'description' => 'Lihat hasil kelas yang sudah selesai',
        ],
        'jadwal' => [
            'label' => 'Jadwal',
            'description' => 'Cek agenda belajar minggu ini',
        ],
    ];
@endphp

<div class="text-white py-10 px-6 sm:px-10 lg:px-28" style="background-color: #1D4ED8;">
    <div class="mx-auto max-w-7xl">
        @include('siswa.partials.back-button', ['fallback' => route('siswa.dashboard')])

        <div class="mt-7 flex items-center gap-4">
            <div class="flex h-14 w-14 items-center justify-center rounded-lg bg-white/15">
                <img src="{{ asset('asset/jadwal_saya.svg') }}" alt="" class="h-8 w-8 object-contain brightness-0 invert">
            </div>
            <div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Jadwal Saya</h1>
                <p class="mt-2 text-blue-100 text-sm sm:text-base">Kelola jadwal, kelas aktif, dan riwayat kelas selesai Anda</p>
            </div>
        </div>
    </div>
</div>

<main class="mx-auto max-w-7xl px-6 py-8 sm:px-10 lg:px-28">
    <nav class="flex justify-center" aria-label="Pilihan jadwal saya">
        <div class="grid w-full max-w-3xl grid-cols-1 gap-3 rounded-xl border border-gray-200 bg-white p-3 shadow-sm sm:grid-cols-3">
            @foreach($tabs as $tabKey => $tab)
                <a
                    href="{{ route('siswa.jadwal.index', ['tab' => $tabKey]) }}"
                    class="rounded-lg border px-5 py-4 text-center transition {{ $activeTab === $tabKey ? 'border-blue-200 bg-blue-50 text-blue-700 shadow-sm' : 'border-transparent bg-gray-50 text-gray-700 hover:border-gray-200 hover:bg-white' }}"
                >
                    <span class="block text-base font-extrabold">{{ $tab['label'] }}</span>
                    <span class="mt-1 block text-xs font-medium leading-snug text-gray-500">{{ $tab['description'] }}</span>
                </a>
            @endforeach
        </div>
    </nav>

    <section class="mt-8 space-y-6">
        @if($activeTab === 'aktif')
            @foreach($activeClasses as $class)
                <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="text-xl font-extrabold text-gray-950">{{ $class['title'] }}</h2>
                                <span class="rounded-md bg-gray-950 px-2.5 py-1 text-[11px] font-bold text-white">{{ $class['level'] }}</span>
                            </div>
                            <p class="mt-2 text-sm text-gray-600">{{ $class['tutor'] }} - {{ $class['schedule'] }}</p>
                        </div>
                        <span class="w-max rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700">Aktif</span>
                    </div>

                    <div class="mt-7">
                        <div class="mb-2 flex items-center justify-between text-sm font-bold">
                            <span>Progress Keseluruhan</span>
                            <span class="text-blue-600">{{ $class['progress'] }}%</span>
                        </div>
                        <div class="h-3 overflow-hidden rounded-full bg-gray-200">
                            <div class="h-full rounded-full bg-blue-600" style="width: {{ $class['progress'] }}%"></div>
                        </div>
                        <p class="mt-2 text-xs font-medium text-gray-500">{{ $class['completed_sessions'] }} dari {{ $class['total_sessions'] }} sesi selesai</p>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div class="rounded-lg bg-blue-50 p-4">
                            <p class="text-xs font-semibold text-gray-600">Kehadiran</p>
                            <p class="mt-2 text-2xl font-extrabold text-blue-600">{{ $class['attendance'] }}%</p>
                        </div>
                        <div class="rounded-lg bg-emerald-50 p-4">
                            <p class="text-xs font-semibold text-gray-600">Rata-rata Nilai</p>
                            <p class="mt-2 text-2xl font-extrabold text-emerald-600">{{ $class['average_score'] }}%</p>
                        </div>
                        <div class="rounded-lg bg-purple-50 p-4">
                            <p class="text-xs font-semibold text-gray-600">Tugas Selesai</p>
                            <p class="mt-2 text-2xl font-extrabold text-purple-600">{{ $class['tasks_done'] }}/{{ $class['tasks_total'] }}</p>
                        </div>
                    </div>

                    <div class="mt-6 border-t border-gray-200 pt-5">
                        <h3 class="text-sm font-extrabold text-gray-950">Materi Tersedia</h3>
                        <div class="mt-4 space-y-3">
                            @foreach($class['materials'] as $material)
                                <div class="flex flex-col gap-3 rounded-lg bg-gray-50 px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
                                    <div class="flex items-start gap-3">
                                        <img src="{{ asset('asset/kelas_kursus.svg') }}" alt="" class="mt-0.5 h-5 w-5 object-contain">
                                        <div>
                                            <p class="text-sm font-bold text-gray-950">{{ $material['title'] }}</p>
                                            <p class="text-xs text-gray-500">{{ $material['meta'] }}</p>
                                        </div>
                                    </div>
                                    <button type="button" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-bold text-gray-700 transition hover:bg-gray-50">
                                        Download
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <a href="{{ route('siswa.audio.index') }}" class="flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-3 text-sm font-bold text-gray-800 transition hover:bg-gray-50">
                            Audio Lessons
                        </a>
                        <a href="{{ route('siswa.diskusi.index') }}" class="flex items-center justify-center rounded-md bg-gray-950 px-4 py-3 text-sm font-bold text-white transition hover:bg-gray-800">
                            Forum Diskusi
                        </a>
                    </div>
                </article>
            @endforeach
        @elseif($activeTab === 'selesai')
            @foreach($finishedClasses as $class)
                <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="text-xl font-extrabold text-gray-950">{{ $class['title'] }}</h2>
                                <span class="rounded-md bg-gray-100 px-2.5 py-1 text-[11px] font-bold text-gray-700">{{ $class['level'] }}</span>
                            </div>
                            <p class="mt-2 text-sm text-gray-600">{{ $class['tutor'] }} - Selesai pada {{ $class['finished_at'] }}</p>
                        </div>
                        <span class="w-max rounded-full border border-gray-200 bg-gray-50 px-3 py-1 text-xs font-bold text-gray-700">Selesai</span>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div class="rounded-lg bg-blue-50 p-4">
                            <p class="text-xs font-semibold text-gray-600">Nilai Akhir</p>
                            <p class="mt-2 text-2xl font-extrabold text-blue-600">{{ $class['final_score'] }}/100</p>
                        </div>
                        <div class="rounded-lg bg-emerald-50 p-4">
                            <p class="text-xs font-semibold text-gray-600">Kehadiran</p>
                            <p class="mt-2 text-2xl font-extrabold text-emerald-600">{{ $class['attendance'] }}%</p>
                        </div>
                        <div class="rounded-lg bg-purple-50 p-4">
                            <p class="text-xs font-semibold text-gray-600">Predikat</p>
                            <p class="mt-2 text-2xl font-extrabold text-purple-600">{{ $class['predicate'] }}</p>
                        </div>
                    </div>
                </article>
            @endforeach
        @else
            <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
                <div>
                    <h2 class="text-lg font-extrabold text-gray-950">Jadwal Minggu Ini</h2>
                    <p class="mt-2 text-sm text-gray-600">22 - 28 Mei 2026</p>
                </div>

                <div class="mt-6 space-y-4">
                    @foreach($weeklySchedules as $schedule)
                        <div class="rounded-lg border-l-4 {{ $schedule['color'] === 'green' ? 'border-emerald-500 bg-emerald-50' : 'border-blue-600 bg-blue-50' }} px-5 py-4">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                                <div class="w-14 text-center">
                                    <p class="text-xs font-semibold text-gray-600">{{ $schedule['day'] }}</p>
                                    <p class="{{ $schedule['color'] === 'green' ? 'text-emerald-600' : 'text-blue-600' }} text-2xl font-extrabold">{{ $schedule['date'] }}</p>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h3 class="text-base font-extrabold text-gray-950">{{ $schedule['course'] }}</h3>
                                        <span class="rounded-full border border-gray-300 bg-white px-2.5 py-1 text-xs font-bold text-gray-700">{{ $schedule['time'] }}</span>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-700">{{ $schedule['tutor'] }} - {{ $schedule['session'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </article>
        @endif
    </section>
</main>
@endsection
