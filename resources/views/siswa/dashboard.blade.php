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
            <div class="p-3 bg-blue-50 rounded-lg">
                <img src="{{ asset('asset/kelas_aktif.svg') }}" alt="" class="h-6 w-6 object-contain">
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas Aktif</p>
                <p class="text-2xl font-bold text-gray-950 mt-1">{{ $kelasAktif }}</p>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-emerald-50 rounded-lg">
                <img src="{{ asset('asset/kelas_selesai.svg') }}" alt="" class="h-6 w-6 object-contain">
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas Selesai</p>
                <p class="text-2xl font-bold text-gray-950 mt-1">{{ $kelasSelesai }}</p>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-purple-50 rounded-lg">
                <img src="{{ asset('asset/audio_didengar.svg') }}" alt="" class="h-6 w-6 object-contain">
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Audio Didengar</p>
                <p class="text-2xl font-bold text-gray-950 mt-1">{{ $audioDidengar }}</p>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-amber-50 rounded-lg">
                <img src="{{ asset('asset/quiz_selesai.svg') }}" alt="" class="h-6 w-6 object-contain">
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
                    <img src="{{ asset('asset/kelas_aktif_saya.svg') }}" alt="" class="h-6 w-6 object-contain">
                    <span>Kelas Aktif Saya</span>
                </h2>
                
                @if($kelasAktifList->isEmpty())
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-8 text-center">
                        <div class="mx-auto w-12 h-12 mb-3 flex items-center justify-center bg-gray-50 rounded-full">
                            <img src="{{ asset('asset/kelas_aktif_saya.svg') }}" alt="" class="h-6 w-6 object-contain">
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada kelas aktif</p>
                        <p class="text-gray-400 text-xs mt-1">Silakan mendaftar kelas baru melalui kelas kursus.</p>
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
                                            <img src="{{ asset('asset/jadwal_saya.svg') }}" alt="" class="mt-0.5 h-4 w-4 object-contain">
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
                    <img src="{{ asset('asset/fitur_pembelajaran.svg') }}" alt="" class="h-6 w-6 object-contain">
                    <span>Fitur Pembelajaran</span>
                </h2>
                
                <div class="space-y-4">
                    <!-- Baris 1: 4 Kolom -->
                    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Kelas Kursus -->
                        <a href="{{ route('siswa.kelas-kursus.index') }}" class="flex flex-col items-center justify-center p-5 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-blue-600 hover:shadow-md transition duration-200 text-center">
                            <div class="mb-3 p-3 bg-blue-50 rounded-full">
                                <img src="{{ asset('asset/kelas_kursus.svg') }}" alt="" class="h-6 w-6 object-contain">
                            </div>
                            <span class="text-sm font-bold text-gray-900">Kelas Kursus</span>
                        </a>

                        <!-- Audio Listening -->
                        <a href="{{ url('/siswa/audio') }}" class="flex flex-col items-center justify-center p-5 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-purple-600 hover:shadow-md transition duration-200 text-center">
                            <div class="mb-3 p-3 bg-purple-50 rounded-full">
                                <img src="{{ asset('asset/audio_listening.svg') }}" alt="" class="h-6 w-6 object-contain">
                            </div>
                            <span class="text-sm font-bold text-gray-900">Audio Listening</span>
                        </a>

                        <!-- Quiz -->
                        <a href="{{ url('/siswa/quiz') }}" class="flex flex-col items-center justify-center p-5 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-amber-600 hover:shadow-md transition duration-200 text-center">
                            <div class="mb-3 p-3 bg-amber-50 rounded-full">
                                <img src="{{ asset('asset/quiz.svg') }}" alt="" class="h-6 w-6 object-contain">
                            </div>
                            <span class="text-sm font-bold text-gray-900">Quiz</span>
                        </a>

                        <!-- Diskusi -->
                        <a href="{{ url('/siswa/diskusi') }}" class="flex flex-col items-center justify-center p-5 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-emerald-600 hover:shadow-md transition duration-200 text-center">
                            <div class="mb-3 p-3 bg-emerald-50 rounded-full">
                                <img src="{{ asset('asset/diskusi.svg') }}" alt="" class="h-6 w-6 object-contain">
                            </div>
                            <span class="text-sm font-bold text-gray-900">Diskusi</span>
                        </a>
                    </div>

                    <!-- Baris 2: 2 Kolom -->
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Translate -->
                        <a href="{{ url('/siswa/translate') }}" class="flex flex-col items-center justify-center p-5 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-red-600 hover:shadow-md transition duration-200 text-center">
                            <div class="mb-3 p-3 bg-red-50 rounded-full">
                                <img src="{{ asset('asset/translate.svg') }}" alt="" class="h-6 w-6 object-contain">
                            </div>
                            <span class="text-sm font-bold text-gray-900">Translate</span>
                        </a>

                        <!-- Jadwal Saya -->
                        <a href="{{ url('/siswa/jadwal') }}" class="flex flex-col items-center justify-center p-5 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-blue-600 hover:shadow-md transition duration-200 text-center">
                            <div class="mb-3 p-3 bg-blue-50 rounded-full">
                                <img src="{{ asset('asset/jadwal_saya.svg') }}" alt="" class="h-6 w-6 object-contain">
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
                    <img src="{{ asset('asset/jadwal_kelas_mendatang.svg') }}" alt="" class="h-5 w-5 object-contain">
                    <span>Jadwal Kelas Mendatang</span>
                </h2>
                
                @if($jadwalMendatang->isEmpty())
                    <div class="text-center py-8">
                        <div class="mx-auto w-10 h-10 mb-2 flex items-center justify-center bg-gray-50 rounded-full">
                            <img src="{{ asset('asset/jadwal_kelas_mendatang.svg') }}" alt="" class="h-5 w-5 object-contain">
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
                                        <div class="mt-0.5 p-2 bg-blue-100 rounded">
                                            <img src="{{ asset('asset/jadwal_kelas_mendatang.svg') }}" alt="" class="h-4 w-4 object-contain">
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
