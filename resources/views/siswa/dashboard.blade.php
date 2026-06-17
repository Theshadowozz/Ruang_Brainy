@extends('layouts.siswa')

@section('title', 'Dashboard Siswa - Brainy')

@section('content')
@php
    \Illuminate\Support\Carbon::setLocale('id');
@endphp

<!-- Header Banner -->
<div class="text-white py-12 px-6 sm:px-10 lg:px-28" style="background-color: #1D4ED8;">
    <div class="mx-auto max-w-7xl">
        <p class="text-sm font-semibold uppercase tracking-wider text-blue-300">Dashboard Siswa</p>
        <h1 class="mt-2 text-3xl sm:text-4xl font-extrabold tracking-tight">Selamat datang kembali, {{ auth()->user()->name }}!</h1>
        <p class="mt-3 text-blue-100 max-w-2xl text-sm sm:text-base">Siap untuk melanjutkan pembelajaran hari ini? Pantau progres kelas Anda dan pelajari materi baru di bawah ini.</p>
    </div>
</div>

<!-- Stats Section (Overlapping Header) -->
<div class="mx-auto max-w-7xl px-6 sm:px-10 lg:px-28 -mt-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Stat Card 1 -->
        <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14v7" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas Aktif</p>
                <p class="text-2xl font-bold text-gray-950 mt-1">{{ $kelasAktif }}</p>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas Selesai</p>
                <p class="text-2xl font-bold text-gray-950 mt-1">{{ $kelasSelesai }}</p>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-purple-50 text-purple-600 rounded-lg">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Audio Didengar</p>
                <p class="text-2xl font-bold text-gray-950 mt-1">{{ $audioDidengar }}</p>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-amber-50 text-amber-600 rounded-lg">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Quiz Selesai</p>
                <p class="text-2xl font-bold text-gray-950 mt-1">{{ $quizSelesai }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Section -->
<main class="mx-auto max-w-7xl px-6 py-10 sm:px-10 lg:px-28">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column (Kelas Aktif & Fitur Pembelajaran) -->
        <div class="lg:col-span-2 space-y-10">
            
            <!-- Section: Kelas Aktif Saya -->
            <section aria-labelledby="kelas-aktif-title">
                <h2 id="kelas-aktif-title" class="text-xl font-bold text-gray-950 mb-4 flex items-center gap-2">
                    <span>📚</span> Kelas Aktif Saya
                </h2>
                
                @if($kelasAktifList->isEmpty())
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-8 text-center">
                        <div class="mx-auto w-12 h-12 text-gray-400 mb-3 flex items-center justify-center bg-gray-50 rounded-full">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada kelas aktif</p>
                        <p class="text-gray-400 text-xs mt-1">Silakan mendaftar kelas baru melalui katalog kursus.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @foreach($kelasAktifList as $reg)
                            @if($reg->schedule && $reg->schedule->class)
                                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-5 flex flex-col justify-between hover:shadow transition duration-200">
                                    <div>
                                        <!-- Level Badge & Title -->
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="bg-gray-900 text-white text-[10px] font-semibold tracking-wider uppercase px-2.5 py-0.5 rounded">
                                                {{ $reg->schedule->class->level }}
                                            </span>
                                            <span class="text-xs text-blue-600 font-semibold uppercase tracking-wider">
                                                {{ $reg->schedule->class->language }}
                                            </span>
                                        </div>
                                        
                                        <h3 class="text-base font-bold text-gray-950 mt-2 line-clamp-1">
                                            {{ $reg->schedule->class->name }}
                                        </h3>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Tutor: <span class="font-medium text-gray-700">{{ $reg->schedule->class->tutor->name ?? '-' }}</span>
                                        </p>
                                        
                                        <!-- Progress Bar -->
                                        <div class="mt-4">
                                            <div class="flex justify-between items-center text-xs font-semibold text-gray-700 mb-1">
                                                <span>Progres Belajar</span>
                                                <span>{{ $reg->progress }}%</span>
                                            </div>
                                            <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                                                <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $reg->progress }}%"></div>
                                            </div>
                                        </div>
                                        
                                        <!-- Schedule Info -->
                                        <div class="mt-4 pt-3 border-t border-gray-100 flex items-start gap-2 text-xs text-gray-600">
                                            <span class="mt-0.5 text-gray-400">📅</span>
                                            <div>
                                                <p class="font-medium text-gray-800">{{ $reg->schedule->day }}</p>
                                                <p class="text-[11px] text-gray-500 mt-0.5">
                                                    {{ substr($reg->schedule->start_time, 0, 5) }} - {{ substr($reg->schedule->end_time, 0, 5) }} • Ruang {{ $reg->schedule->room }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Buttons -->
                                    <div class="mt-6 grid grid-cols-2 gap-3">
                                        <a href="#" class="flex items-center justify-center py-2 px-3 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 transition text-center">
                                            Lihat Detail
                                        </a>
                                        <a href="#" class="flex items-center justify-center py-2 px-3 bg-gray-950 text-xs font-medium rounded text-white hover:bg-gray-800 transition text-center">
                                            Mulai Belajar
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </section>

            <!-- Section: Fitur Pembelajaran -->
            <section aria-labelledby="fitur-title">
                <h2 id="fitur-title" class="text-xl font-bold text-gray-950 mb-4 flex items-center gap-2">
                    <span>⚡</span> Fitur Pembelajaran
                </h2>
                
                <div class="space-y-4">
                    <!-- Baris 1: 4 Kolom -->
                    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Katalog Kursus -->
                        <a href="{{ url('/siswa/katalog') }}" class="flex flex-col items-center justify-center p-5 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-blue-600 hover:shadow-md transition duration-200 text-center">
                            <div class="mb-3 p-3 bg-blue-50 text-blue-600 rounded-full">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <span class="text-sm font-bold text-gray-900">Katalog Kursus</span>
                        </a>

                        <!-- Audio Listening -->
                        <a href="{{ url('/siswa/audio') }}" class="flex flex-col items-center justify-center p-5 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-purple-600 hover:shadow-md transition duration-200 text-center">
                            <div class="mb-3 p-3 bg-purple-50 text-purple-600 rounded-full">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                                </svg>
                            </div>
                            <span class="text-sm font-bold text-gray-900">Audio Listening</span>
                        </a>

                        <!-- Quiz -->
                        <a href="{{ url('/siswa/quiz') }}" class="flex flex-col items-center justify-center p-5 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-amber-600 hover:shadow-md transition duration-200 text-center">
                            <div class="mb-3 p-3 bg-amber-50 text-amber-600 rounded-full">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                            </div>
                            <span class="text-sm font-bold text-gray-900">Quiz</span>
                        </a>

                        <!-- Diskusi -->
                        <a href="{{ url('/siswa/diskusi') }}" class="flex flex-col items-center justify-center p-5 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-emerald-600 hover:shadow-md transition duration-200 text-center">
                            <div class="mb-3 p-3 bg-emerald-50 text-emerald-600 rounded-full">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <span class="text-sm font-bold text-gray-900">Diskusi</span>
                        </a>
                    </div>

                    <!-- Baris 2: 2 Kolom -->
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Translate -->
                        <a href="{{ url('/siswa/translate') }}" class="flex flex-col items-center justify-center p-5 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-red-600 hover:shadow-md transition duration-200 text-center">
                            <div class="mb-3 p-3 bg-red-50 text-red-600 rounded-full">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 11.37 7.31 16.5 3 19" />
                                </svg>
                            </div>
                            <span class="text-sm font-bold text-gray-900">Translate</span>
                        </a>

                        <!-- Jadwal Saya -->
                        <a href="{{ url('/siswa/jadwal') }}" class="flex flex-col items-center justify-center p-5 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-blue-600 hover:shadow-md transition duration-200 text-center">
                            <div class="mb-3 p-3 bg-blue-50 text-blue-600 rounded-full">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-sm font-bold text-gray-900">Jadwal Saya</span>
                        </a>
                    </div>
                </div>
            </section>

        </div>

        <!-- Right Column (Jadwal Kelas Mendatang) -->
        <div class="space-y-6">
            
            <!-- Section: Jadwal Kelas Mendatang -->
            <section aria-labelledby="jadwal-title" class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <h2 id="jadwal-title" class="text-lg font-bold text-gray-950 mb-4 flex items-center gap-2 border-b border-gray-100 pb-3">
                    <span>📅</span> Jadwal Kelas Mendatang
                </h2>
                
                @if($jadwalMendatang->isEmpty())
                    <div class="text-center py-8">
                        <div class="mx-auto w-10 h-10 text-gray-400 mb-2 flex items-center justify-center bg-gray-50 rounded-full">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-xs text-gray-500 font-medium">Tidak ada jadwal mendatang</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($jadwalMendatang as $jadwal)
                            @if($jadwal->class)
                                <div class="flex items-start justify-between gap-3 p-3 bg-gray-50 hover:bg-gray-100 transition rounded-md border border-gray-100">
                                    <div class="flex gap-3">
                                        <!-- Color-coded calendar icon -->
                                        <div class="mt-0.5 p-2 bg-blue-100 text-blue-700 rounded">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-900 leading-tight">
                                                {{ $jadwal->class->name }}
                                            </h4>
                                            <p class="text-[11px] text-gray-500 mt-1">
                                                {{ $jadwal->class->tutor->name ?? 'Tutor' }}
                                            </p>
                                            <p class="text-[11px] font-semibold text-gray-700 mt-0.5">
                                                {{ \Illuminate\Support\Carbon::parse($jadwal->start_date)->translatedFormat('l, d F Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Time on right -->
                                    <div class="text-right flex-shrink-0">
                                        <span class="inline-block text-[10px] font-semibold text-blue-700 bg-blue-50 px-2 py-0.5 rounded border border-blue-100">
                                            {{ substr($jadwal->start_time, 0, 5) }} - {{ substr($jadwal->end_time, 0, 5) }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </section>
            
        </div>

    </div>
</main>
@endsection
