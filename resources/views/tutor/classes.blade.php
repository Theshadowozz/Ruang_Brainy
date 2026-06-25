@extends('layouts.tutor')

@section('title', 'Kelas yang Saya Ajar - Brainy')

@section('content')
@php
    $selectedDay = request('day');
    $filteredClasses = $selectedDay
        ? $classes->filter(fn ($class) => collect(data_get($class, 'schedules', []))->contains('day', $selectedDay))->values()
        : $classes;
@endphp

<div class="px-6 py-12 text-white sm:px-10 lg:px-28" style="background-color: #1D4ED8;">
    <div class="mx-auto max-w-7xl">
        <a href="{{ route('tutor.dashboard') }}" class="inline-flex h-12 items-center gap-3 rounded-lg bg-white px-5 text-sm font-extrabold text-blue-700 shadow-sm transition hover:bg-blue-50">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M15 18L9 12L15 6" />
            </svg>
            <span>Kembali</span>
        </a>

        <div class="mt-8">
            <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">Kelas yang Saya Ajar</h1>
            <p class="mt-2 max-w-2xl text-sm text-blue-100 sm:text-base">Semua jadwal tiap kelas tampil di halaman ini agar informasi tidak tersebar ke halaman lain.</p>
        </div>
    </div>
</div>

<div class="mx-auto max-w-7xl px-6 sm:px-10 lg:px-28 -mt-8">
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
        <div class="flex items-center gap-4 rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <div class="rounded-lg bg-blue-50 p-3">
                <img src="{{ asset('asset/kelas_aktif.svg') }}" alt="" class="h-6 w-6 object-contain">
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Total Kelas</p>
                <p class="mt-1 text-2xl font-bold text-gray-950">{{ data_get($stats, 'classes') }}</p>
            </div>
        </div>

        <div class="flex items-center gap-4 rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <div class="rounded-lg bg-emerald-50 p-3">
                <img src="{{ asset('asset/kelas_selesai.svg') }}" alt="" class="h-6 w-6 object-contain">
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Total Siswa</p>
                <p class="mt-1 text-2xl font-bold text-gray-950">{{ data_get($stats, 'students') }}</p>
            </div>
        </div>

        <div class="flex items-center gap-4 rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <div class="rounded-lg bg-purple-50 p-3">
                <img src="{{ asset('asset/jadwal_saya.svg') }}" alt="" class="h-6 w-6 object-contain">
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Sesi Minggu Ini</p>
                <p class="mt-1 text-2xl font-bold text-gray-950">{{ data_get($stats, 'weekly_sessions') }}</p>
            </div>
        </div>
    </div>
</div>

<main class="mx-auto max-w-7xl px-6 py-10 sm:px-10 lg:px-28">
    <section aria-labelledby="classes-title">
        <div class="mb-5 flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h2 id="classes-title" class="flex items-center gap-2 text-xl font-bold text-gray-950">
                    <img src="{{ asset('asset/kelas_aktif_saya.svg') }}" alt="" class="h-6 w-6 object-contain">
                    <span>Daftar Kelas Aktif</span>
                </h2>
                <p class="mt-1 text-sm text-gray-500">Pilih hari untuk melihat kelas dan jadwal yang berjalan pada hari tersebut.</p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('tutor.classes') }}" class="inline-flex h-9 items-center rounded border px-4 text-xs font-bold transition {{ $selectedDay ? 'border-gray-200 bg-white text-gray-600 hover:border-blue-600 hover:text-blue-700' : 'border-blue-600 bg-blue-600 text-white' }}">
                    Semua
                </a>
                @foreach ($availableDays as $day)
                    <a href="{{ route('tutor.classes', ['day' => $day]) }}" class="inline-flex h-9 items-center rounded border px-4 text-xs font-bold transition {{ $selectedDay === $day ? 'border-blue-600 bg-blue-600 text-white' : 'border-gray-200 bg-white text-gray-600 hover:border-blue-600 hover:text-blue-700' }}">
                        {{ $day }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="space-y-6">
            @forelse ($filteredClasses as $class)
                @php
                    $capacity = max(data_get($class, 'students_capacity'), 1);
                    $fillRate = round((data_get($class, 'students_current') / $capacity) * 100);
                    $sessionProgress = round((data_get($class, 'sessions_done') / max(data_get($class, 'sessions_total'), 1)) * 100);
                    $isFull = data_get($class, 'students_current') >= data_get($class, 'students_capacity');
                    $visibleSchedules = $selectedDay
                        ? collect(data_get($class, 'schedules', []))->where('day', $selectedDay)->values()
                        : collect(data_get($class, 'schedules', []));
                @endphp

                <article class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col gap-5 border-b border-gray-100 pb-6 lg:flex-row lg:items-start lg:justify-between">
                        <div class="max-w-2xl">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded bg-gray-950 px-2.5 py-0.5 text-[10px] font-semibold uppercase tracking-wider text-white">{{ data_get($class, 'level') }}</span>
                                <span class="rounded border border-blue-100 bg-blue-50 px-2.5 py-0.5 text-[10px] font-semibold uppercase tracking-wider text-blue-700">{{ data_get($class, 'language') }}</span>
                                <span class="rounded border px-2.5 py-0.5 text-[10px] font-semibold uppercase tracking-wider {{ $isFull ? 'border-red-100 bg-red-50 text-red-700' : 'border-emerald-100 bg-emerald-50 text-emerald-700' }}">{{ data_get($class, 'status') }}</span>
                            </div>
                            <h3 class="mt-3 text-lg font-bold text-gray-950">{{ data_get($class, 'name') }}</h3>
                            <p class="mt-2 text-sm leading-6 text-gray-600">{{ data_get($class, 'summary') }}</p>
                        </div>

                        <div class="grid min-w-full grid-cols-2 gap-3 sm:min-w-[21rem]">
                            <div class="rounded-md bg-blue-50 p-4">
                                <p class="text-xs font-medium text-gray-500">Siswa</p>
                                <p class="mt-1 text-xl font-bold text-blue-700">{{ data_get($class, 'students_current') }}/{{ data_get($class, 'students_capacity') }}</p>
                            </div>
                            <div class="rounded-md bg-purple-50 p-4">
                                <p class="text-xs font-medium text-gray-500">Durasi</p>
                                <p class="mt-1 text-xl font-bold text-purple-700">{{ data_get($class, 'duration') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 pt-6 lg:grid-cols-3">
                        <div class="lg:col-span-2">
                            <div>
                                <div class="flex items-center justify-between gap-4">
                                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Jadwal Kelas</p>
                                    <span class="rounded bg-blue-50 px-2 py-1 text-[11px] font-bold text-blue-700">{{ $visibleSchedules->count() }} jadwal</span>
                                </div>

                                <div class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                    @foreach ($visibleSchedules as $schedule)
                                        <div class="rounded-md border border-blue-100 bg-blue-50 p-4">
                                            <div class="flex items-start justify-between gap-3">
                                                <div>
                                                    <p class="text-sm font-bold text-gray-950">{{ data_get($schedule, 'day') }}</p>
                                                    <p class="mt-1 text-xs text-gray-500">{{ data_get($schedule, 'date') }}</p>
                                                </div>
                                                <span class="rounded bg-white px-2 py-1 text-[11px] font-bold text-blue-700">{{ data_get($schedule, 'time') }}</span>
                                            </div>
                                            <p class="mt-4 text-sm font-semibold text-gray-800">{{ data_get($schedule, 'topic') }}</p>
                                            <p class="mt-1 text-xs text-gray-500">{{ data_get($schedule, 'room') }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <div class="mb-1 flex items-center justify-between text-xs font-semibold text-gray-700">
                                        <span>Kapasitas siswa</span>
                                        <span>{{ $fillRate }}%</span>
                                    </div>
                                    <div class="h-2 w-full overflow-hidden rounded-full bg-gray-100">
                                        <div class="h-2 rounded-full {{ $isFull ? 'bg-red-500' : 'bg-blue-600' }}" style="width: {{ min($fillRate, 100) }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="mb-1 flex items-center justify-between text-xs font-semibold text-gray-700">
                                        <span>Progres sesi</span>
                                        <span>{{ data_get($class, 'sessions_done') }}/{{ data_get($class, 'sessions_total') }}</span>
                                    </div>
                                    <div class="h-2 w-full overflow-hidden rounded-full bg-gray-100">
                                        <div class="h-2 rounded-full bg-emerald-500" style="width: {{ min($sessionProgress, 100) }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-md border border-gray-100 bg-gray-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Informasi Administrasi</p>
                            <dl class="mt-4 space-y-3 text-sm">
                                <div class="flex items-center justify-between gap-4">
                                    <dt class="text-gray-500">Harga kursus</dt>
                                    <dd class="font-bold text-gray-950">{{ data_get($class, 'price') }}</dd>
                                </div>
                                <div class="flex items-center justify-between gap-4">
                                    <dt class="text-gray-500">Total sesi</dt>
                                    <dd class="font-bold text-gray-950">{{ data_get($class, 'sessions_total') }} sesi</dd>
                                </div>
                                <div class="flex items-center justify-between gap-4">
                                    <dt class="text-gray-500">Sisa kursi</dt>
                                    <dd class="font-bold text-gray-950">{{ max(data_get($class, 'students_capacity') - data_get($class, 'students_current'), 0) }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-lg border border-dashed border-gray-300 bg-white p-10 text-center">
                    <p class="text-sm font-bold text-gray-700">Tidak ada kelas pada hari {{ $selectedDay }}.</p>
                    <p class="mt-1 text-xs text-gray-500">Pilih hari lain atau buka filter Semua.</p>
                </div>
            @endforelse
        </div>
    </section>
</main>
@endsection
