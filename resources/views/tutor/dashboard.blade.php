@extends('layouts.tutor')

@section('title', 'Dashboard Tutor - Brainy')

@section('content')
@php
    $tutorName = data_get($tutor, 'name', auth()->user()->name ?? 'Tutor Brainy');
    $firstName = explode(' ', trim($tutorName))[0] ?? $tutorName;
    $nearestSchedule = $nextSchedules->first();
@endphp

<div class="px-6 py-12 text-white sm:px-10 lg:px-28" style="background-color: #1D4ED8;">
    <div class="mx-auto max-w-7xl">
        <p class="text-sm font-semibold uppercase tracking-wider text-blue-200">Dashboard Tutor</p>
        <h1 class="mt-2 text-3xl font-extrabold tracking-tight sm:text-4xl">Selamat datang kembali, {{ $firstName }}!</h1>
        <p class="mt-3 max-w-2xl text-sm text-blue-100 sm:text-base">Pantau jadwal terdekat, kelas aktif, dan hal penting hari ini tanpa informasi yang berulang.</p>
    </div>
</div>

<div class="mx-auto max-w-7xl px-6 sm:px-10 lg:px-28 -mt-8">
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="flex items-center gap-4 rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <div class="rounded-lg bg-blue-50 p-3">
                <img src="{{ asset('asset/kelas_aktif.svg') }}" alt="" class="h-6 w-6 object-contain">
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Kelas Aktif</p>
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

        <div class="flex items-center gap-4 rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <div class="rounded-lg bg-amber-50 p-3">
                <img src="{{ asset('asset/quiz_selesai.svg') }}" alt="" class="h-6 w-6 object-contain">
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Rating Siswa</p>
                <p class="mt-1 text-2xl font-bold text-gray-950">{{ data_get($stats, 'rating') }}</p>
            </div>
        </div>
    </div>
</div>

<main class="mx-auto max-w-7xl px-6 py-10 sm:px-10 lg:px-28">
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <div class="space-y-8 lg:col-span-2">
            <section aria-labelledby="today-focus-title" class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-4 border-b border-gray-100 pb-5 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <h2 id="today-focus-title" class="flex items-center gap-2 text-lg font-bold text-gray-950">
                            <img src="{{ asset('asset/jadwal_kelas_mendatang.svg') }}" alt="" class="h-5 w-5 object-contain">
                            <span>Sesi Mengajar Terdekat</span>
                        </h2>
                        <p class="mt-1 text-sm text-gray-500">Satu jadwal paling dekat agar fokus hari ini jelas.</p>
                    </div>
                    <a href="{{ route('tutor.classes') }}" class="inline-flex h-9 items-center justify-center rounded border border-gray-300 bg-white px-4 text-xs font-semibold text-gray-700 transition hover:border-blue-600 hover:text-blue-700">
                        Lihat di Kelas
                    </a>
                </div>

                @if ($nearestSchedule)
                    <div class="mt-5 rounded-md border border-blue-100 bg-blue-50 p-5">
                        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex gap-4">
                                <div class="flex h-16 w-16 shrink-0 flex-col items-center justify-center rounded-lg bg-white text-blue-700">
                                    <span class="text-xs font-bold">{{ data_get($nearestSchedule, 'day') }}</span>
                                    <span class="text-2xl font-extrabold">{{ data_get($nearestSchedule, 'date_short') }}</span>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-gray-950">{{ data_get($nearestSchedule, 'class_name') }}</h3>
                                    <p class="mt-1 text-sm text-gray-600">{{ data_get($nearestSchedule, 'topic') }}</p>
                                    <p class="mt-2 text-xs font-semibold text-gray-700">{{ data_get($nearestSchedule, 'time') }} &bull; {{ data_get($nearestSchedule, 'room') }}</p>
                                </div>
                            </div>
                            <div class="rounded-md bg-white px-4 py-3 text-sm">
                                <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Peserta</p>
                                <p class="mt-1 text-xl font-bold text-blue-700">{{ data_get($nearestSchedule, 'students') }} siswa</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mt-5 rounded-md border border-gray-100 bg-gray-50 p-8 text-center">
                        <p class="text-sm font-medium text-gray-500">Belum ada jadwal mengajar minggu ini.</p>
                    </div>
                @endif
            </section>

            <section aria-labelledby="class-summary-title">
                <div class="mb-4 flex items-center justify-between gap-4">
                    <h2 id="class-summary-title" class="flex items-center gap-2 text-xl font-bold text-gray-950">
                        <img src="{{ asset('asset/kelas_aktif_saya.svg') }}" alt="" class="h-6 w-6 object-contain">
                        <span>Kelas Aktif</span>
                    </h2>
                    <a href="{{ route('tutor.classes') }}" class="text-xs font-bold uppercase tracking-wider text-blue-700 hover:text-blue-900">Lihat semua</a>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    @foreach ($classes as $class)
                        @php
                            $progress = round((data_get($class, 'sessions_done') / max(data_get($class, 'sessions_total'), 1)) * 100);
                        @endphp
                        <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm transition hover:border-blue-200 hover:shadow">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <span class="rounded bg-gray-950 px-2.5 py-0.5 text-[10px] font-semibold uppercase tracking-wider text-white">{{ data_get($class, 'level') }}</span>
                                    <h3 class="mt-3 text-base font-bold text-gray-950">{{ data_get($class, 'name') }}</h3>
                                    <p class="mt-1 text-xs text-gray-500">{{ data_get($class, 'schedule') }}, {{ data_get($class, 'time') }}</p>
                                </div>
                                <span class="rounded border border-gray-200 px-2 py-1 text-[11px] font-semibold text-gray-600">{{ data_get($class, 'students_current') }} siswa</span>
                            </div>

                            <div class="mt-5">
                                <div class="mb-1 flex items-center justify-between text-xs font-semibold text-gray-700">
                                    <span>Progres sesi</span>
                                    <span>{{ data_get($class, 'sessions_done') }}/{{ data_get($class, 'sessions_total') }}</span>
                                </div>
                                <div class="h-2 w-full overflow-hidden rounded-full bg-gray-100">
                                    <div class="h-2 rounded-full bg-blue-600" style="width: {{ $progress }}%"></div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        </div>

        <aside class="space-y-6">
            <section aria-labelledby="quick-actions-title" class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <h2 id="quick-actions-title" class="text-lg font-bold text-gray-950">Akses Cepat</h2>
                <div class="mt-5 grid gap-3">
                    <a href="{{ route('tutor.classes') }}" class="flex items-center justify-between rounded-md border border-gray-200 p-4 transition hover:border-blue-600 hover:bg-blue-50">
                        <span class="flex items-center gap-3 text-sm font-bold text-gray-900">
                            <img src="{{ asset('asset/kelas_aktif_saya.svg') }}" alt="" class="h-5 w-5 object-contain">
                            Kelas yang Saya Ajar
                        </span>
                        <span class="text-blue-700">&rarr;</span>
                    </a>
                </div>
            </section>

            <section aria-labelledby="week-overview-title" class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <h2 id="week-overview-title" class="text-lg font-bold text-gray-950">Ringkasan Minggu Ini</h2>
                <div class="mt-5 space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <span class="text-sm text-gray-500">Jam mengajar</span>
                        <span class="font-bold text-emerald-600">{{ data_get($stats, 'teaching_hours') }} jam</span>
                    </div>
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <span class="text-sm text-gray-500">Kehadiran</span>
                        <span class="font-bold text-purple-600">{{ data_get($stats, 'attendance') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Kapasitas kelas</span>
                        <span class="font-bold text-blue-700">{{ data_get($stats, 'students') }}/{{ $classes->sum('students_capacity') }}</span>
                    </div>
                </div>
            </section>
        </aside>
    </div>

    @include('components.forum-discussion')
</main>
@endsection
