@extends('layouts.siswa')

@section('title', 'Mengerjakan Quiz - Brainy')

@section('content')
<!-- Header Banner -->
<div class="text-white py-8 px-6 sm:px-10 lg:px-28" style="background-color: #1D4ED8;">
    <div class="mx-auto max-w-4xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="bg-white/20 text-white text-xs font-semibold px-2.5 py-1 rounded">
                {{ $quiz->level }} • {{ $quiz->language }}
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight mt-2">{{ $quiz->title }}</h1>
        </div>
        <div class="flex items-center gap-4 text-sm font-medium">
            <div class="bg-white/10 px-4 py-2 rounded-lg flex items-center gap-2">
                <svg class="h-5 w-5 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Durasi: {{ $quiz->duration_minutes }} Menit</span>
            </div>
            <div class="bg-white/10 px-4 py-2 rounded-lg flex items-center gap-2">
                <svg class="h-5 w-5 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>{{ count($questions) }} Soal</span>
            </div>
        </div>
    </div>
</div>

<!-- Main Container -->
<div class="mx-auto max-w-4xl px-6 py-8 sm:px-10 lg:px-28">

    <form action="{{ route('siswa.quiz.submit', $quiz->id) }}" method="POST" class="space-y-6">
        @csrf

        @foreach($questions as $index => $question)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-4">
                <!-- Question Number and text -->
                <div class="flex items-start gap-3">
                    <span class="flex-shrink-0 bg-blue-50 text-blue-700 font-extrabold text-sm h-6 w-6 rounded-full flex items-center justify-center">
                        {{ $index + 1 }}
                    </span>
                    <h3 class="text-base font-bold text-gray-900 leading-relaxed pt-0.5">
                        {{ $question->question }}
                    </h3>
                </div>

                <!-- Answer options -->
                <div class="grid grid-cols-1 gap-2.5 pt-2">
                    @foreach(['a', 'b', 'c', 'd'] as $optionKey)
                        @php
                            $optionField = 'option_' . $optionKey;
                            $optionText = $question->$optionField;
                        @endphp
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer transition select-none">
                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $optionKey }}" required class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="text-xs font-bold text-gray-400 uppercase bg-gray-100 rounded px-1.5 py-0.5">{{ $optionKey }}</span>
                            <span class="text-sm text-gray-700">{{ $optionText }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach

        <!-- Submit Panel -->
        <div class="flex items-center justify-between bg-white rounded-lg border border-gray-200 shadow-sm p-4 mt-8">
            <p class="text-xs text-gray-500 font-medium">Pastikan semua jawaban telah terisi sebelum menekan submit.</p>
            <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white text-sm font-bold px-6 py-2.5 rounded-md shadow-sm transition">
                Submit Quiz
            </button>
        </div>
    </form>

</div>
@endsection
