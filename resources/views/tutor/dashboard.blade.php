@php
    $user = auth()->user();

    // Fallback sementara sampai controller dari alur admin siap mengirim data asli.
    $tutor = $tutor ?? [
        'name' => $user->name ?? 'Sarah Johnson',
        'description' => 'Native speaker dengan sertifikasi TESOL',
        'avatar_url' => null,
    ];

    $stats = $stats ?? [
        'classes' => 2,
        'students' => 27,
        'weekly_sessions' => 6,
    ];

    $classes = $classes ?? [
        [
            'name' => 'English for Beginners',
            'level' => 'beginner',
            'days' => 'Senin & Rabu',
            'time' => '19:00 - 20:30',
            'students_current' => 12,
            'students_capacity' => 15,
            'sessions' => 24,
        ],
        [
            'name' => 'English Intermediate',
            'level' => 'intermediate',
            'days' => 'Selasa & Kamis',
            'time' => '19:00 - 20:30',
            'students_current' => 15,
            'students_capacity' => 15,
            'sessions' => 24,
        ],
    ];

    $upcomingSchedules = $upcomingSchedules ?? [
        [
            'day' => 'Selasa',
            'date' => '23',
            'class_name' => 'English Intermediate',
            'time' => '19:00 - 20:30',
            'session' => 'Session 17: Business Communication',
            'students' => 15,
            'tone' => 'blue',
        ],
        [
            'day' => 'Kamis',
            'date' => '25',
            'class_name' => 'English Intermediate',
            'time' => '19:00 - 20:30',
            'session' => 'Session 18: Email Writing',
            'students' => 15,
            'tone' => 'green',
        ],
        [
            'day' => 'Jumat',
            'date' => '26',
            'class_name' => 'English Advanced',
            'time' => '19:00 - 20:30',
            'session' => 'Session 12: Presentation Skills',
            'students' => 8,
            'tone' => 'purple',
        ],
    ];

    $avatarUrl = data_get($tutor, 'avatar_url');
    $tutorName = data_get($tutor, 'name', $user->name ?? 'Tutor Brainy');
    $initials = collect(explode(' ', $tutorName))
        ->filter()
        ->take(2)
        ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
        ->implode('');

    $scheduleToneClasses = [
        'blue' => 'border-l-blue-600 bg-blue-50 text-blue-700',
        'green' => 'border-l-emerald-500 bg-emerald-50 text-emerald-600',
        'purple' => 'border-l-purple-600 bg-purple-50 text-purple-700',
    ];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tutor - Brainy</title>
    @include('layouts.vite')
</head>
<body class="bg-gray-50 font-sans text-gray-950">
    @include('layouts.header')

    <main>
        <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
            <div class="mx-auto flex max-w-7xl items-center gap-4 px-4 py-8 text-white sm:px-6 lg:px-8">
                <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-full border-2 border-white bg-blue-600 text-xl font-bold shadow-sm">
                    @if ($avatarUrl)
                        <img src="{{ $avatarUrl }}" alt="{{ $tutorName }}" class="h-full w-full object-cover">
                    @else
                        <span>{{ $initials ?: 'BT' }}</span>
                    @endif
                </div>
                <div>
                    <h1 class="text-2xl font-bold leading-tight sm:text-3xl">Selamat Datang, {{ $tutorName }}!</h1>
                    <p class="mt-1 text-sm font-medium text-white/90 sm:text-base">{{ data_get($tutor, 'description') }}</p>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="grid gap-5 md:grid-cols-3">
                <article class="flex min-h-20 items-center justify-between rounded-lg border border-gray-200 bg-white px-5 py-4">
                    <div>
                        <p class="text-xs text-gray-600">Kelas yang Diajar</p>
                        <p class="mt-1 text-2xl font-bold">{{ data_get($stats, 'classes', count($classes)) }}</p>
                    </div>
                    <svg class="h-9 w-9 text-purple-200" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M3 8L12 4L21 8L12 12L3 8Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M7 10V15.5C7 16.6 9.24 18 12 18C14.76 18 17 16.6 17 15.5V10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </article>

                <article class="flex min-h-20 items-center justify-between rounded-lg border border-gray-200 bg-white px-5 py-4">
                    <div>
                        <p class="text-xs text-gray-600">Total Siswa</p>
                        <p class="mt-1 text-2xl font-bold">{{ data_get($stats, 'students') }}</p>
                    </div>
                    <svg class="h-9 w-9 text-blue-200" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M8.5 11C10.43 11 12 9.43 12 7.5C12 5.57 10.43 4 8.5 4C6.57 4 5 5.57 5 7.5C5 9.43 6.57 11 8.5 11Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M2.75 20C3.28 16.85 5.53 14.75 8.5 14.75C11.47 14.75 13.72 16.85 14.25 20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M16 11C17.66 11 19 9.66 19 8C19 6.34 17.66 5 16 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M16.5 14.8C19.04 15.23 20.78 17.14 21.25 20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </article>

                <article class="flex min-h-20 items-center justify-between rounded-lg border border-gray-200 bg-white px-5 py-4">
                    <div>
                        <p class="text-xs text-gray-600">Sesi Minggu Ini</p>
                        <p class="mt-1 text-2xl font-bold">{{ data_get($stats, 'weekly_sessions') }}</p>
                    </div>
                    <svg class="h-9 w-9 text-emerald-200" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M7 3V6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M17 3V6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M4.5 9H19.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M5 5.5H19C19.83 5.5 20.5 6.17 20.5 7V19C20.5 19.83 19.83 20.5 19 20.5H5C4.17 20.5 3.5 19.83 3.5 19V7C3.5 6.17 4.17 5.5 5 5.5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                    </svg>
                </article>
            </div>

            <div class="mt-8 flex items-center justify-between gap-4">
                <h2 class="text-xl font-bold">Kelas yang Saya Ajar</h2>
                <a href="#kelas" class="inline-flex h-8 items-center rounded-md border border-gray-200 bg-white px-4 text-xs font-semibold transition hover:border-blue-200 hover:text-blue-600">Lihat Semua</a>
            </div>

            <div id="kelas" class="mt-5 grid gap-5 lg:grid-cols-2">
                @foreach ($classes as $class)
                    <article class="rounded-lg border border-gray-200 bg-white p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="font-semibold">{{ data_get($class, 'name') }}</h3>
                                <p class="mt-1 text-sm text-gray-600">{{ data_get($class, 'days') }}, {{ data_get($class, 'time') }}</p>
                            </div>
                            <span class="rounded-md bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-700">{{ data_get($class, 'level') }}</span>
                        </div>

                        <div class="mt-7 grid gap-3 sm:grid-cols-2">
                            <div class="rounded-md bg-blue-50 px-4 py-3">
                                <p class="text-xs text-gray-600">Siswa</p>
                                <p class="mt-1 text-lg font-bold text-blue-600">{{ data_get($class, 'students_current') }}/{{ data_get($class, 'students_capacity') }}</p>
                            </div>
                            <div class="rounded-md bg-emerald-50 px-4 py-3">
                                <p class="text-xs text-gray-600">Sesi</p>
                                <p class="mt-1 text-lg font-bold text-emerald-600">{{ data_get($class, 'sessions') }}</p>
                            </div>
                        </div>

                        <div class="mt-4 grid gap-3 sm:grid-cols-2">
                            <a href="#" class="inline-flex h-9 items-center justify-center rounded-md border border-gray-200 bg-white px-4 text-sm font-semibold transition hover:border-blue-200 hover:text-blue-600">Lihat Detail</a>
                            <a href="#jadwal-mengajar" class="inline-flex h-9 items-center justify-center rounded-md bg-gray-950 px-4 text-sm font-semibold text-white transition hover:bg-blue-700">Jadwal</a>
                        </div>
                    </article>
                @endforeach
            </div>

            <section id="jadwal-mengajar" class="mt-6 rounded-lg border border-gray-200 bg-white p-5">
                <h2 class="font-semibold">Jadwal Mengajar Mendatang</h2>
                <p class="mt-1 text-sm text-gray-600">Kelas yang akan datang minggu ini</p>

                <div class="mt-6 space-y-4">
                    @foreach ($upcomingSchedules as $schedule)
                        @php
                            $tone = data_get($scheduleToneClasses, data_get($schedule, 'tone'), $scheduleToneClasses['blue']);
                        @endphp
                        <article class="flex gap-5 rounded-md border-l-4 px-5 py-4 {{ $tone }}">
                            <div class="w-12 shrink-0 text-center">
                                <p class="text-xs font-medium text-gray-700">{{ data_get($schedule, 'day') }}</p>
                                <p class="mt-1 text-2xl font-bold">{{ data_get($schedule, 'date') }}</p>
                            </div>
                            <div class="min-w-0 text-gray-950">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="font-semibold">{{ data_get($schedule, 'class_name') }}</h3>
                                    <span class="rounded bg-white px-2 py-0.5 text-xs font-semibold text-gray-700">{{ data_get($schedule, 'time') }}</span>
                                </div>
                                <p class="mt-1 text-sm text-gray-700">{{ data_get($schedule, 'session') }}</p>
                                <p class="text-xs text-gray-600">{{ data_get($schedule, 'students') }} siswa</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        </section>

        @include('components.forum-discussion')
    </main>
</body>
</html>
