@extends('layouts.admin')

@section('title', 'Brainy Admin - Quiz Mingguan')
@section('page_title', 'Quiz Mingguan')
@section('page_description', 'Upload gambar quiz mingguan dan pantau jawaban siswa.')

@php
    $activeTab = 'quiz';
@endphp

@section('content')
    @if(session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">
            {{ $errors->first() }}
        </div>
    @endif

    <section class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 to-violet-700 p-6 sm:p-8 text-white shadow-sm">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-white/15">
                    <img src="{{ asset('asset/quiz.svg') }}" alt="" class="h-8 w-8 object-contain brightness-0 invert">
                </div>
                <div>
                    <h2 class="text-3xl font-extrabold tracking-tight">Quiz Mingguan</h2>
                    <p class="mt-2 text-sm font-medium text-blue-50/90">Upload gambar quiz, lalu jawaban siswa akan masuk di halaman ini.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="grid gap-6 xl:grid-cols-[420px_1fr]">
        <div class="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm">
            <h3 class="text-base font-extrabold text-slate-900">Upload Gambar Quiz</h3>
            <p class="mt-1 text-xs font-medium text-slate-500">Gunakan gambar JPG, PNG, atau WebP maksimal 4 MB.</p>

            <form method="POST" action="{{ route('admin.quiz.store') }}" enctype="multipart/form-data" class="mt-5 space-y-4">
                @csrf

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-slate-700">Judul Quiz</label>
                    <input name="title" value="{{ old('title') }}" required placeholder="Contoh: Quiz Minggu 1 - Grammar" class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50/30 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 focus:bg-white">
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-slate-700">Label Minggu</label>
                    <input name="week_label" value="{{ old('week_label') }}" placeholder="Contoh: Minggu ke-1 Juni 2026" class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50/30 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 focus:bg-white">
                </div>

                <div class="grid gap-3 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-slate-700">Bahasa</label>
                        <select name="language" class="h-10 w-full rounded-xl border border-slate-200 bg-white px-3 text-xs font-medium outline-none transition focus:border-blue-500">
                            <option value="Inggris">Inggris</option>
                            <option value="Jepang">Jepang</option>
                            <option value="Korea">Korea</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold text-slate-700">Level</label>
                        <select name="level" class="h-10 w-full rounded-xl border border-slate-200 bg-white px-3 text-xs font-medium outline-none transition focus:border-blue-500">
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advance">Advance</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-slate-700">Catatan untuk Siswa</label>
                    <textarea name="description" rows="4" placeholder="Instruksi singkat untuk mengerjakan quiz..." class="w-full rounded-xl border border-slate-200 bg-slate-50/30 px-3.5 py-3 text-xs font-medium outline-none transition focus:border-blue-500 focus:bg-white">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-slate-700">Gambar Quiz</label>
                    <input name="quiz_image" type="file" accept="image/*" required class="block w-full rounded-xl border border-dashed border-slate-300 bg-slate-50 px-3 py-3 text-xs font-medium text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-600 file:px-3 file:py-2 file:text-xs file:font-bold file:text-white">
                </div>

                <button type="submit" class="flex h-10 w-full items-center justify-center rounded-xl bg-blue-600 px-5 text-xs font-bold text-white shadow-sm transition hover:bg-blue-700">
                    Upload Quiz
                </button>
            </form>
        </div>

        <div class="space-y-6">
            <section class="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between gap-4 border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900">Quiz Terupload</h3>
                        <p class="mt-1 text-xs font-medium text-slate-500">{{ $quizzes->count() }} quiz tersedia untuk siswa.</p>
                    </div>
                </div>

                <div class="mt-5 grid gap-4 md:grid-cols-2">
                    @forelse($quizzes as $quiz)
                        <article class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                            <div class="aspect-video bg-slate-50">
                                @if($quiz->image_path)
                                    <img src="{{ asset('storage/' . $quiz->image_path) }}" alt="{{ $quiz->title }}" class="h-full w-full object-cover">
                                @endif
                            </div>
                            <div class="p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h4 class="text-sm font-extrabold text-slate-900">{{ $quiz->title }}</h4>
                                        <p class="mt-1 text-xs text-slate-500">{{ $quiz->week_label ?: 'Tanpa label minggu' }}</p>
                                    </div>
                                    <span class="rounded-lg bg-blue-50 px-2.5 py-1 text-[11px] font-bold text-blue-700">{{ $quiz->results_count }} jawaban</span>
                                </div>

                                <form method="POST" action="{{ route('admin.quiz.destroy', $quiz) }}" class="mt-4" onsubmit="return confirm('Hapus quiz ini? Jawaban siswa untuk quiz ini juga akan terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="h-9 w-full rounded-xl border border-rose-200 bg-white px-4 text-xs font-bold text-rose-600 transition hover:bg-rose-50">
                                        Hapus Quiz
                                    </button>
                                </form>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center text-sm font-semibold text-slate-500 md:col-span-2">
                            Belum ada quiz yang diupload.
                        </div>
                    @endforelse
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm">
                <div class="border-b border-slate-100 pb-4">
                    <h3 class="text-base font-extrabold text-slate-900">Jawaban Siswa</h3>
                    <p class="mt-1 text-xs font-medium text-slate-500">Jawaban terbaru dari siswa akan muncul di sini.</p>
                </div>

                <div class="mt-4 divide-y divide-slate-100">
                    @forelse($answers as $answer)
                        <div class="py-4 first:pt-0 last:pb-0">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <p class="text-sm font-extrabold text-slate-900">{{ $answer->user->name ?? 'Siswa' }}</p>
                                    <p class="mt-1 text-xs font-semibold text-slate-500">{{ $answer->quiz->title ?? 'Quiz' }} - {{ $answer->answered_at?->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            <p class="mt-3 whitespace-pre-line rounded-xl bg-slate-50 px-4 py-3 text-sm leading-relaxed text-slate-700">{{ $answer->answer_text }}</p>
                        </div>
                    @empty
                        <p class="py-8 text-center text-sm font-semibold text-slate-500">Belum ada jawaban siswa.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </section>
@endsection
