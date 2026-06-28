<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Kelas - Brainy Course</title>
    @include('layouts.vite')
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 sm:px-8">
            <a href="{{ url('/') }}" class="flex items-center gap-3 font-extrabold text-blue-700">
                <img src="{{ asset('images/logo_brainy.png') }}" alt="Brainy Course" class="h-11 w-11 object-contain">
                <span class="text-xl">Brainy Course</span>
            </a>
            <div class="flex items-center gap-3 text-sm font-bold">
                <a href="{{ url('/') }}" class="rounded-lg px-4 py-2 text-slate-600 hover:bg-slate-100">Kembali</a>
                <a href="{{ route('login') }}" class="rounded-lg border border-blue-200 bg-white px-4 py-2 text-blue-700 hover:bg-blue-50">Sudah terdaftar? Masuk</a>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-5 py-12 sm:px-8">
        <div class="max-w-3xl">
            <p class="text-sm font-extrabold uppercase tracking-widest text-blue-600">Pendaftaran Siswa</p>
            <h1 class="mt-3 text-4xl font-black tracking-tight sm:text-5xl">Pilih kelas dan jadwal belajarmu</h1>
            <p class="mt-4 text-lg leading-8 text-slate-600">Semua informasi di bawah berasal dari data kelas dan jadwal yang dikelola admin.</p>
        </div>

        @if (session('success'))
            <div class="mt-8 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
        @endif

        <div class="mt-10 space-y-8">
            @forelse ($classes as $class)
                <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="grid gap-6 border-b border-slate-100 p-6 lg:grid-cols-[1fr_auto]">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-extrabold text-blue-700">{{ $class->language }}</span>
                                <span class="rounded-full bg-violet-50 px-3 py-1 text-xs font-extrabold text-violet-700">{{ $class->level }}</span>
                            </div>
                            <h2 class="mt-4 text-2xl font-black">{{ $class->name }}</h2>
                            <p class="mt-2 max-w-3xl leading-7 text-slate-600">{{ $class->description }}</p>
                            <p class="mt-4 text-sm font-semibold text-slate-500">Tutor: <span class="text-slate-900">{{ $class->tutor->name }}</span> · {{ $class->tutor->expertise }}</p>
                        </div>
                        <div class="lg:text-right">
                            <p class="text-sm font-semibold text-slate-500">Biaya kelas</p>
                            <p class="mt-1 text-2xl font-black text-blue-700">Rp {{ number_format($class->price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="grid gap-4 p-6 lg:grid-cols-2">
                        @foreach ($class->schedules as $schedule)
                            @php
                                $remainingSeats = max(0, $schedule->capacity - $schedule->occupied_seats);
                            @endphp
                            <article class="rounded-xl border border-slate-200 p-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <h3 class="font-black">{{ $schedule->day }}</h3>
                                        <p class="mt-1 text-sm text-slate-600">{{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }} WIB</p>
                                    </div>
                                    <span class="rounded-full px-3 py-1 text-xs font-extrabold {{ $remainingSeats > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                        {{ $remainingSeats > 0 ? $remainingSeats.' kursi tersisa' : 'Penuh' }}
                                    </span>
                                </div>
                                <dl class="mt-5 grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <dt class="text-slate-500">Periode</dt>
                                        <dd class="mt-1 font-bold">{{ $schedule->start_date->format('d M Y') }} - {{ $schedule->end_date->format('d M Y') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-slate-500">Ruangan</dt>
                                        <dd class="mt-1 font-bold">{{ $schedule->room }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-slate-500">Kapasitas</dt>
                                        <dd class="mt-1 font-bold">{{ $schedule->capacity }} siswa</dd>
                                    </div>
                                    <div>
                                        <dt class="text-slate-500">Terisi</dt>
                                        <dd class="mt-1 font-bold">{{ $schedule->occupied_seats }} siswa</dd>
                                    </div>
                                </dl>
                                @if ($remainingSeats > 0)
                                    <a href="{{ route('registration.create', $schedule) }}" class="mt-5 inline-flex w-full items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-extrabold text-white hover:bg-blue-700">Daftar Jadwal Ini</a>
                                @else
                                    <button disabled class="mt-5 w-full cursor-not-allowed rounded-xl bg-slate-200 px-5 py-3 text-sm font-extrabold text-slate-500">Jadwal Penuh</button>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </section>
            @empty
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">
                    <h2 class="text-xl font-black">Belum ada jadwal kelas tersedia</h2>
                    <p class="mt-2 text-slate-500">Admin perlu menambahkan data kelas dan jadwal terlebih dahulu.</p>
                </div>
            @endforelse
        </div>
    </main>
</body>
</html>
