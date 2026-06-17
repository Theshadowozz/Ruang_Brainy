@extends('layouts.siswa')

@section('title', 'Quiz & Assessment - Brainy')

@section('content')
<!-- Header Banner -->
<div class="text-white py-12 px-6 sm:px-10 lg:px-28" style="background-color: #1D4ED8;">
    <div class="mx-auto max-w-7xl flex items-center gap-4">
        <!-- Trophy Icon -->
        <div class="p-3 bg-white/15 rounded-xl">
            <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15a7 7 0 007-7V4H5v4a7 7 0 007 7z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 6H3v2c0 2.2 1.8 4 4 4h1M19 6h2v2c0 2.2-1.8 4-4 4h-1" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v4m-4 0h8" />
            </svg>
        </div>
        <div>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Quiz & Assessment</h1>
            <p class="mt-2 text-blue-100 text-sm sm:text-base">Uji pemahaman Anda dengan quiz interaktif</p>
        </div>
    </div>
</div>

<!-- Main Container -->
<div class="mx-auto max-w-7xl px-6 py-8 sm:px-10 lg:px-28 space-y-8">

    <!-- Flash message -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg p-4 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <!-- Quiz Grid Section -->
    <div>
        <h2 class="text-xl font-bold text-gray-950 mb-6 flex items-center gap-2">
            <span>📝</span> Daftar Quiz Tersedia
        </h2>

        @if($quizzes->isEmpty())
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-12 text-center">
                <div class="mx-auto w-16 h-16 text-gray-400 mb-4 flex items-center justify-center bg-gray-50 rounded-full">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <p class="text-gray-600 font-semibold text-lg">Tidak ada quiz yang tersedia saat ini</p>
                <p class="text-gray-400 text-sm mt-1">Hubungi tutor Anda jika belum ada quiz yang ditugaskan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($quizzes as $quiz)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex flex-col justify-between hover:shadow-md transition duration-200">
                        <div class="space-y-4">
                            <!-- Top Row: Badge Level and Badge Bahasa -->
                            <div class="flex items-center justify-between">
                                <span class="bg-gray-900 text-white text-[10px] sm:text-xs font-semibold px-2.5 py-1 rounded">
                                    {{ $quiz->level }}
                                </span>
                                
                                <span class="border border-gray-300 text-gray-600 text-[10px] sm:text-xs px-2.5 py-1 rounded flex items-center gap-1.5 font-medium bg-gray-50">
                                    @if($quiz->language == 'Inggris')
                                        <span>🇬🇧</span>
                                    @elseif($quiz->language == 'Jepang')
                                        <span>🇯🇵</span>
                                    @elseif($quiz->language == 'Korea')
                                        <span>🇰🇷</span>
                                    @endif
                                    <span>{{ $quiz->language }}</span>
                                </span>
                            </div>

                            <!-- Quiz Details -->
                            <div>
                                <h3 class="text-base font-bold text-gray-950 leading-snug line-clamp-2 mt-2">
                                    {{ $quiz->title }}
                                </h3>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $quiz->total_questions }} pertanyaan • {{ $quiz->duration_minutes }} menit
                                </p>
                            </div>

                            <!-- Icons info -->
                            <div class="space-y-2 pt-2">
                                <!-- Durasi -->
                                <div class="flex items-center gap-2 text-xs text-gray-600">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Durasi: {{ $quiz->duration_minutes }} menit</span>
                                </div>
                                <!-- Soal Pilihan Ganda -->
                                <div class="flex items-center gap-2 text-xs text-gray-600">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    <span>{{ $quiz->total_questions }} soal pilihan ganda</span>
                                </div>
                            </div>
                        </div>

                        <!-- Button Mulai Quiz -->
                        <div class="mt-6">
                            <a href="{{ route('siswa.quiz.start', $quiz->id) }}" class="block w-full text-center py-2 px-4 bg-gray-900 hover:bg-gray-700 text-white text-sm font-semibold rounded transition">
                                Mulai Quiz
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Skor Terakhir Section -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
        <div>
            <h2 class="text-lg font-bold text-gray-950">Skor Terakhir</h2>
            <p class="text-xs text-gray-500 mt-0.5">History quiz yang telah Anda kerjakan</p>
        </div>

        <div class="mt-4 divide-y divide-gray-100">
            @forelse($quizResults as $result)
                <div class="py-3.5 flex justify-between items-center gap-4">
                    <div>
                        <h4 class="text-sm font-bold text-gray-900">{{ $result->quiz->title ?? 'Quiz' }}</h4>
                        <p class="text-xs text-gray-500 mt-1">
                            Dikerjakan pada: {{ $result->completed_at ? $result->completed_at->format('d M Y') : '-' }}
                        </p>
                    </div>
                    <div>
                        @if($result->score >= 90)
                            <span class="inline-block px-2.5 py-1 text-xs font-bold text-green-700 bg-green-100 rounded border border-green-150">
                                Skor: {{ $result->score }}
                            </span>
                        @elseif($result->score >= 70)
                            <span class="inline-block px-2.5 py-1 text-xs font-bold text-yellow-700 bg-yellow-100 rounded border border-yellow-150">
                                Skor: {{ $result->score }}
                            </span>
                        @else
                            <span class="inline-block px-2.5 py-1 text-xs font-bold text-red-700 bg-red-100 rounded border border-red-150">
                                Skor: {{ $result->score }}
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500 py-4 italic">Belum ada quiz yang dikerjakan</p>
            @endforelse
        </div>
    </div>

</div>
@endsection
