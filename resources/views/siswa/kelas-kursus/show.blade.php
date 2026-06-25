@extends('layouts.siswa')

@section('title', 'Detail Kelas - Brainy')

@section('content')
@php
    $materials = [
        ['title' => 'Dasar Tata Bahasa', 'description' => 'Memahami struktur kalimat dan aturan gramatika.'],
        ['title' => 'Kosakata Esensial', 'description' => '500+ kosakata untuk percakapan sehari-hari.'],
        ['title' => 'Latihan Speaking', 'description' => 'Praktik percakapan interaktif dengan tutor.'],
        ['title' => 'Listening Comprehension', 'description' => 'Audio lessons dan latihan mendengarkan.'],
        ['title' => 'Reading & Writing', 'description' => 'Latihan membaca dan menulis dengan feedback.'],
        ['title' => 'Quiz & Assessment', 'description' => 'Evaluasi berkala untuk monitor progress.'],
    ];
@endphp

<div class="text-white py-10 px-6 sm:px-10 lg:px-28" style="background-color: #1D4ED8;">
    <div class="mx-auto max-w-7xl">
        @include('siswa.partials.back-button', ['fallback' => route('siswa.kelas-kursus.index')])

        <div class="mt-7 flex items-center gap-4">
            <div class="flex h-14 w-14 items-center justify-center rounded-lg bg-white/15">
                <img src="{{ asset('asset/kelas_kursus.svg') }}" alt="" class="h-8 w-8 object-contain brightness-0 invert">
            </div>
            <div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Detail Kelas</h1>
                <p class="mt-2 text-blue-100 text-sm sm:text-base">{{ $course['title'] }}</p>
            </div>
        </div>
    </div>
</div>

<div class="mx-auto max-w-7xl px-6 py-8 sm:px-10 lg:px-28">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-7 items-start">
        <div class="lg:col-span-2 space-y-6">
            <section class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <span class="bg-gray-950 text-white rounded-md px-2.5 py-1 text-[11px] font-bold uppercase">{{ $course['level'] }}</span>
                    <span class="rounded-md border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-[11px] font-semibold text-emerald-700">{{ $course['status'] }}</span>
                </div>

                <h2 class="mt-5 text-2xl font-extrabold text-gray-950">{{ $course['title'] }}</h2>
                <p class="mt-2 text-sm text-gray-500">{{ $course['description'] }}</p>

                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="rounded-lg bg-gray-50 p-4 flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full border border-blue-200 text-blue-600">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="9" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Durasi</p>
                            <p class="text-sm font-bold text-gray-950">{{ $course['duration'] }}</p>
                        </div>
                    </div>

                    <div class="rounded-lg bg-gray-50 p-4 flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full border border-blue-200 text-blue-600">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" />
                                <path stroke-linecap="round" d="M16 2v4M8 2v4M3 10h18" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Total Sesi</p>
                            <p class="text-sm font-bold text-gray-950">{{ $course['sessions'] }}</p>
                        </div>
                    </div>

                    <div class="rounded-lg bg-gray-50 p-4 flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full border border-blue-200 text-blue-600">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Kapasitas</p>
                            <p class="text-sm font-bold text-gray-950">{{ $course['capacity'] }}</p>
                        </div>
                    </div>

                    <div class="rounded-lg bg-gray-50 p-4 flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full border border-blue-200 text-blue-600">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="9" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Mulai Kelas</p>
                            <p class="text-sm font-bold text-gray-950">{{ $course['start_date'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 border-t border-gray-200 pt-5">
                    <h3 class="text-base font-extrabold text-gray-950">Jadwal Kelas</h3>
                    <p class="mt-3 text-sm text-gray-700">{{ $course['schedule'] }}</p>
                </div>
            </section>

            <section class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <h3 class="text-base font-extrabold text-gray-950">Tutor</h3>
                <div class="mt-5 flex flex-col sm:flex-row gap-4">
                    <img src="{{ asset($course['tutor']['photo']) }}" alt="{{ $course['tutor']['display_name'] }}" class="h-20 w-20 rounded-full object-cover border border-gray-200">
                    <div>
                        <h4 class="text-lg font-extrabold text-gray-950">{{ $course['tutor']['display_name'] }}</h4>
                        <p class="mt-1 inline-flex rounded-md bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700">{{ $course['tutor']['experience'] }}</p>
                        <p class="mt-3 text-sm text-gray-600 leading-relaxed">{{ $course['tutor']['bio'] }}</p>
                        <p class="mt-3 text-sm text-gray-600">{{ $course['tutor']['email'] }}</p>
                    </div>
                </div>
            </section>

            <section class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <h3 class="text-base font-extrabold text-gray-950">Materi Pembelajaran</h3>
                <div class="mt-5 space-y-4">
                    @foreach($materials as $material)
                        <div class="flex gap-3">
                            <div class="mt-0.5 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full border border-emerald-500 text-emerald-600">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-950">{{ $material['title'] }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $material['description'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <aside class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 lg:sticky lg:top-24">
            <h3 class="text-base font-extrabold text-gray-950">Pendaftaran Online</h3>
            <p class="mt-1 text-sm text-gray-500">Daftar sekarang dan mulai belajar</p>

            <div class="mt-6">
                <p class="text-3xl font-extrabold text-blue-600">Rp {{ number_format($course['price'], 0, ',', '.') }}</p>
                <p class="mt-1 text-sm text-gray-500">Untuk {{ $course['duration'] }} kursus</p>
            </div>

            <a href="#" class="mt-5 flex w-full items-center justify-center rounded-md bg-gray-950 px-4 py-2.5 text-sm font-bold text-white hover:bg-gray-800 transition">
                Daftar Sekarang
            </a>

            <div class="mt-6 border-t border-gray-200 pt-5 space-y-3">
                @foreach(['Jadwal fleksibel', 'Sertifikat setelah lulus', 'Akses materi selamanya', 'Forum diskusi eksklusif'] as $benefit)
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <span class="flex h-5 w-5 items-center justify-center rounded-full border border-emerald-500 text-emerald-600">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 7" />
                            </svg>
                        </span>
                        <span>{{ $benefit }}</span>
                    </div>
                @endforeach
            </div>
        </aside>
    </div>
</div>
@endsection
