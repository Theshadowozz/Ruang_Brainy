@extends('layouts.siswa')

@section('title', 'Quiz Mingguan - Brainy')

@section('content')
<div class="text-white py-12 px-6 sm:px-10 lg:px-28" style="background-color: #1D4ED8;">
    <div class="mx-auto max-w-7xl">
        @include('siswa.partials.back-button', ['fallback' => route('siswa.dashboard')])

        <div class="mt-7 flex items-center gap-4">
            <div class="p-3 bg-white/15 rounded-xl">
                <img src="{{ asset('asset/quiz.svg') }}" alt="" class="h-10 w-10 object-contain brightness-0 invert">
            </div>
            <div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Quiz Mingguan</h1>
                <p class="mt-2 text-blue-100 text-sm sm:text-base">Lihat gambar quiz dari admin, lalu kirim jawaban Anda.</p>
            </div>
        </div>
    </div>
</div>

<main class="mx-auto max-w-7xl px-6 py-8 sm:px-10 lg:px-28">
    @if(session('success'))
        <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    @if($quizzes->isEmpty())
        <section class="rounded-lg border border-gray-200 bg-white p-12 text-center shadow-sm">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-50">
                <img src="{{ asset('asset/quiz.svg') }}" alt="" class="h-8 w-8 object-contain">
            </div>
            <p class="text-lg font-bold text-gray-700">Belum ada quiz minggu ini</p>
            <p class="mt-1 text-sm text-gray-500">Quiz akan muncul setelah admin mengupload gambar.</p>
        </section>
    @else
        <div class="space-y-8">
            @foreach($quizzes as $quiz)
                @php
                    $answer = $answers->get($quiz->id);
                @endphp

                <article class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                    <div class="border-b border-gray-100 px-5 py-4 sm:px-6">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <h2 class="text-xl font-extrabold text-gray-950">{{ $quiz->title }}</h2>
                                    <span class="rounded-md bg-gray-950 px-2.5 py-1 text-[11px] font-bold text-white">{{ $quiz->level }}</span>
                                    <span class="rounded-md border border-gray-200 bg-gray-50 px-2.5 py-1 text-[11px] font-bold text-gray-700">{{ $quiz->language }}</span>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    {{ $quiz->week_label ?: 'Quiz minggu ini' }}
                                    @if($quiz->published_at)
                                        - Diunggah {{ $quiz->published_at->diffForHumans() }}
                                    @endif
                                </p>
                            </div>

                            @if($answer)
                                <span class="w-max rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700">
                                    Sudah dijawab
                                </span>
                            @endif
                        </div>

                        @if($quiz->description)
                            <p class="mt-4 rounded-lg bg-blue-50 px-4 py-3 text-sm leading-relaxed text-gray-700">
                                {{ $quiz->description }}
                            </p>
                        @endif
                    </div>

                    <div class="bg-gray-50 p-4 sm:p-6">
                        <div class="mx-auto max-w-4xl overflow-hidden rounded-lg border border-gray-200 bg-white">
                            @if($quiz->image_path)
                                <img src="{{ asset('storage/' . $quiz->image_path) }}" alt="{{ $quiz->title }}" class="w-full object-contain">
                            @else
                                <div class="flex min-h-64 items-center justify-center text-sm font-semibold text-gray-500">
                                    Gambar quiz belum tersedia.
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="px-5 py-5 sm:px-6">
                        @if($answer)
                            <div class="mb-4 rounded-lg border border-emerald-100 bg-emerald-50 px-4 py-3">
                                <p class="text-xs font-bold uppercase tracking-wide text-emerald-700">Jawaban terkirim</p>
                                <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-gray-800">{{ $answer->answer_text }}</p>
                                <p class="mt-2 text-xs font-medium text-gray-500">{{ $answer->answered_at?->format('d M Y, H:i') }}</p>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('siswa.quiz.answer', $quiz) }}" class="rounded-2xl border border-gray-200 bg-gray-50 p-2 shadow-inner">
                            @csrf
                            <div class="flex items-end gap-2">
                                <textarea
                                    name="answer_text"
                                    rows="1"
                                    class="min-h-12 flex-1 resize-none rounded-xl border-0 bg-white px-4 py-3 text-sm leading-6 text-gray-900 shadow-sm placeholder:text-gray-400 focus:ring-2 focus:ring-blue-500"
                                    placeholder="Tulis jawaban Anda di sini..."
                                    required
                                >{{ old('answer_text', $answer->answer_text ?? '') }}</textarea>
                                <button type="submit" class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm transition hover:bg-blue-700" aria-label="Kirim jawaban">
                                    <img src="{{ asset('asset/send.svg') }}" alt="" class="h-5 w-5 object-contain brightness-0 invert">
                                </button>
                            </div>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</main>
@endsection
