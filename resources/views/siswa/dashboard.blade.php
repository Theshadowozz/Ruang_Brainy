@php
    $user = auth()->user();
    $studentName = $user->name ?? 'Andi Wijaya';

    $stats = [
        ['label' => 'Kelas Aktif', 'value' => 2, 'icon' => 'mortar', 'tone' => 'text-blue-200'],
        ['label' => 'Kelas Selesai', 'value' => 24, 'icon' => 'calendar', 'tone' => 'text-emerald-200'],
        ['label' => 'Audio Didengar', 'value' => 15, 'icon' => 'audio', 'tone' => 'text-purple-200'],
        ['label' => 'Quiz Selesai', 'value' => 8, 'icon' => 'book', 'tone' => 'text-orange-200'],
    ];

    $activeClasses = [
        [
            'name' => 'English Intermediate',
            'tutor' => 'Sarah Johnson',
            'level' => 'Level 2',
            'progress' => 65,
            'schedule' => 'Selasa & Kamis, 19:00 - 20:30',
        ],
        [
            'name' => 'Japanese Beginner',
            'tutor' => 'Yuki Tanaka',
            'level' => 'Level 1',
            'progress' => 40,
            'schedule' => 'Senin & Rabu, 18:00 - 19:30',
        ],
    ];

    $features = [
        ['label' => 'Katalog Kursus', 'desc' => 'Lihat semua kursus', 'href' => '#kelas-aktif', 'color' => 'text-blue-600', 'icon' => 'book'],
        ['label' => 'Audio Listening', 'desc' => 'Latihan mendengar', 'href' => '#kelas-aktif', 'color' => 'text-purple-600', 'icon' => 'audio'],
        ['label' => 'Quiz', 'desc' => 'Tes pemahaman', 'href' => '#kelas-aktif', 'color' => 'text-orange-600', 'icon' => 'mortar'],
        ['label' => 'Diskusi', 'desc' => 'Forum diskusi', 'href' => '#forum-diskusi', 'color' => 'text-emerald-600', 'icon' => 'chat'],
        ['label' => 'Translate', 'desc' => 'Alat terjemahan', 'href' => '#kelas-aktif', 'color' => 'text-rose-600', 'icon' => 'translate'],
        ['label' => 'Jadwal Saya', 'desc' => 'Lihat jadwal kelas', 'href' => '#jadwal-kelas', 'color' => 'text-indigo-600', 'icon' => 'calendar'],
    ];

    $schedules = [
        ['class' => 'English Intermediate', 'meta' => 'Sarah Johnson - Selasa, 23 Mei 2026', 'time' => '19:00 - 20:30', 'tone' => 'bg-blue-50 text-blue-600'],
        ['class' => 'Japanese Beginner', 'meta' => 'Yuki Tanaka - Rabu, 24 Mei 2026', 'time' => '18:00 - 19:30', 'tone' => 'bg-purple-50 text-purple-600'],
        ['class' => 'English Intermediate', 'meta' => 'Sarah Johnson - Kamis, 25 Mei 2026', 'time' => '19:00 - 20:30', 'tone' => 'bg-blue-50 text-blue-600'],
    ];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - Brainy</title>
    @include('layouts.vite')
</head>
<body class="bg-gray-50 font-sans text-gray-950">
    @include('layouts.header')

    <main>
        <section class="bg-blue-700 text-white">
            <div class="mx-auto max-w-7xl px-4 py-9 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold">Dashboard Siswa</h1>
                <p class="mt-2 text-base text-white/90">Selamat datang kembali, {{ $studentName }}!</p>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8">
            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($stats as $stat)
                    <article class="flex min-h-20 items-center justify-between rounded-lg border border-gray-200 bg-white px-5 py-4">
                        <div>
                            <p class="text-xs text-gray-600">{{ $stat['label'] }}</p>
                            <p class="mt-1 text-2xl font-bold">{{ $stat['value'] }}</p>
                        </div>
                        <x-dashboard-icon :name="$stat['icon']" class="h-9 w-9 {{ $stat['tone'] }}" />
                    </article>
                @endforeach
            </div>

            <div id="kelas-aktif" class="mt-8">
                <h2 class="text-xl font-bold">Kelas Aktif Saya</h2>
                <div class="mt-5 grid gap-5 lg:grid-cols-2">
                    @foreach ($activeClasses as $class)
                        <article class="rounded-lg border border-gray-200 bg-white p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h3 class="font-semibold">{{ $class['name'] }}</h3>
                                    <p class="text-sm text-gray-600">{{ $class['tutor'] }}</p>
                                </div>
                                <span class="rounded-md bg-gray-950 px-2 py-1 text-xs font-semibold text-white">{{ $class['level'] }}</span>
                            </div>
                            <div class="mt-6">
                                <div class="flex justify-between text-xs font-semibold text-gray-600">
                                    <span>Progress</span>
                                    <span>{{ $class['progress'] }}%</span>
                                </div>
                                <div class="mt-2 h-2 rounded-full bg-gray-200">
                                    <div class="h-full rounded-full bg-blue-600" style="width: {{ $class['progress'] }}%"></div>
                                </div>
                            </div>
                            <p class="mt-4 flex items-center gap-2 text-sm text-gray-600">
                                <x-dashboard-icon name="calendar" class="h-4 w-4 text-gray-500" />
                                {{ $class['schedule'] }}
                            </p>
                            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                <a href="#" class="inline-flex h-9 items-center justify-center rounded-md border border-gray-200 bg-white px-4 text-sm font-semibold transition hover:border-blue-200 hover:text-blue-600">Lihat Detail</a>
                                <a href="#" class="inline-flex h-9 items-center justify-center rounded-md bg-gray-950 px-4 text-sm font-semibold text-white transition hover:bg-blue-700">Mulai Belajar</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <div class="mt-8">
                <h2 class="text-xl font-bold">Fitur Pembelajaran</h2>
                <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($features as $feature)
                        <a href="{{ $feature['href'] }}" class="flex min-h-28 flex-col items-center justify-center rounded-lg border border-gray-200 bg-white p-5 text-center transition hover:border-blue-200 hover:shadow-sm">
                            <x-dashboard-icon :name="$feature['icon']" class="h-9 w-9 {{ $feature['color'] }}" />
                            <h3 class="mt-3 text-sm font-bold">{{ $feature['label'] }}</h3>
                            <p class="mt-1 text-xs text-gray-600">{{ $feature['desc'] }}</p>
                        </a>
                    @endforeach
                </div>
            </div>

            <section id="jadwal-kelas" class="mt-8">
                <h2 class="text-xl font-bold">Jadwal Kelas Mendatang</h2>
                <div class="mt-5 rounded-lg border border-gray-200 bg-white p-5">
                    @foreach ($schedules as $schedule)
                        <article class="flex flex-col gap-3 border-b border-gray-100 py-4 first:pt-0 last:border-b-0 last:pb-0 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex items-center gap-4">
                                <span class="flex h-11 w-11 items-center justify-center rounded-md {{ $schedule['tone'] }}">
                                    <x-dashboard-icon name="calendar" class="h-5 w-5" />
                                </span>
                                <div>
                                    <h3 class="text-sm font-bold">{{ $schedule['class'] }}</h3>
                                    <p class="text-sm text-gray-600">{{ $schedule['meta'] }}</p>
                                </div>
                            </div>
                            <span class="w-fit rounded-md border border-gray-200 px-3 py-1 text-xs font-semibold">{{ $schedule['time'] }}</span>
                        </article>
                    @endforeach
                </div>
            </section>
        </section>

        @include('components.forum-discussion')
    </main>
</body>
</html>
