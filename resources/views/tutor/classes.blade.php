@extends('layouts.tutor')

@section('title', 'Kelas yang Saya Ajar - Brainy')

@section('content')
<div class="bg-blue-700 px-6 py-12 text-white sm:px-10 lg:px-28">
    <div class="mx-auto max-w-7xl">
        <a href="{{ route('tutor.dashboard') }}" class="font-bold text-blue-100 hover:text-white">← Dashboard</a>
        <h1 class="mt-5 text-3xl font-extrabold sm:text-4xl">Kelas yang Saya Ajar</h1>
        <p class="mt-2 text-blue-100">Daftar ini otomatis mengikuti tutor yang dipilih admin pada data kelas.</p>
    </div>
</div>

<main class="mx-auto max-w-7xl px-6 py-10 sm:px-10 lg:px-28">
    <div class="space-y-6">
        @forelse ($classes as $class)
            <article class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col justify-between gap-5 border-b border-gray-100 pb-5 sm:flex-row">
                    <div>
                        <div class="flex gap-2"><span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">{{ $class->language }}</span><span class="rounded-full bg-violet-50 px-3 py-1 text-xs font-bold text-violet-700">{{ $class->level }}</span></div>
                        <h2 class="mt-3 text-xl font-extrabold">{{ $class->name }}</h2>
                        <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600">{{ $class->description }}</p>
                    </div>
                    <p class="text-xl font-black text-blue-700">Rp {{ number_format($class->price, 0, ',', '.') }}</p>
                </div>
                <div class="mt-5 grid gap-4 md:grid-cols-2">
                    @forelse ($class->schedules as $schedule)
                        <div class="rounded-lg bg-gray-50 p-4">
                            <div class="flex items-center justify-between"><p class="font-extrabold">{{ $schedule->day }}</p><span class="text-sm font-bold text-emerald-700">{{ $schedule->students_count }}/{{ $schedule->capacity }} siswa</span></div>
                            <p class="mt-2 text-sm text-gray-600">{{ substr($schedule->start_time, 0, 5) }}–{{ substr($schedule->end_time, 0, 5) }} · {{ $schedule->room }}</p>
                            <p class="mt-1 text-xs text-gray-500">{{ $schedule->start_date->format('d/m/Y') }}–{{ $schedule->end_date->format('d/m/Y') }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Belum ada jadwal pada kelas ini.</p>
                    @endforelse
                </div>
            </article>
        @empty
            <div class="rounded-xl border border-dashed border-gray-300 bg-white p-12 text-center text-gray-400">Belum ada kelas yang ditugaskan kepada Anda.</div>
        @endforelse
    </div>
</main>
@endsection
