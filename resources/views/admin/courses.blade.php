@extends('layouts.admin')

@section('title', 'Brainy Admin - Kelola Kursus')
@section('page_title', 'Kelola Kursus')
@section('page_description', 'Data kelas ini langsung ditampilkan pada halaman pendaftaran siswa.')

@php($activeTab = 'courses')

@section('content')
    @if (session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-bold text-emerald-800">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="rounded-xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm font-bold text-rose-800">{{ $errors->first() }}</div>
    @endif

    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-black">Tambah kelas</h2>
        <form action="{{ route('admin.courses.store') }}" method="POST" class="mt-5 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @csrf
            <input name="name" required placeholder="Nama kelas" class="h-11 rounded-xl border border-slate-300 px-4">
            <select name="language" required class="h-11 rounded-xl border border-slate-300 px-4">
                <option value="">Pilih bahasa</option>
                @foreach (['Inggris', 'Jepang', 'Korea'] as $language)<option>{{ $language }}</option>@endforeach
            </select>
            <select name="level" required class="h-11 rounded-xl border border-slate-300 px-4">
                <option value="">Pilih level</option>
                @foreach (['Beginner', 'Intermediate', 'Advance'] as $level)<option>{{ $level }}</option>@endforeach
            </select>
            <select name="tutor_id" required class="h-11 rounded-xl border border-slate-300 px-4">
                <option value="">Pilih tutor</option>
                @foreach ($tutors as $tutor)<option value="{{ $tutor->id }}">{{ $tutor->name }}</option>@endforeach
            </select>
            <input name="price" type="number" min="0" required placeholder="Harga" class="h-11 rounded-xl border border-slate-300 px-4">
            <textarea name="description" required placeholder="Deskripsi kelas" class="min-h-24 rounded-xl border border-slate-300 px-4 py-3 xl:col-span-2"></textarea>
            <button class="rounded-xl bg-blue-600 px-5 py-3 font-bold text-white hover:bg-blue-700">Simpan Kelas</button>
        </form>
    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 p-6"><h2 class="text-lg font-black">Daftar kelas</h2></div>
        <div class="divide-y divide-slate-100">
            @forelse ($classes as $class)
                <article class="p-6">
                    <form action="{{ route('admin.courses.update', $class) }}" method="POST" class="grid gap-3 md:grid-cols-2 xl:grid-cols-6">
                        @csrf
                        @method('PUT')
                        <input name="name" value="{{ $class->name }}" required class="h-10 rounded-lg border border-slate-300 px-3 xl:col-span-2">
                        <select name="language" class="h-10 rounded-lg border border-slate-300 px-3">
                            @foreach (['Inggris', 'Jepang', 'Korea'] as $language)<option @selected($class->language === $language)>{{ $language }}</option>@endforeach
                        </select>
                        <select name="level" class="h-10 rounded-lg border border-slate-300 px-3">
                            @foreach (['Beginner', 'Intermediate', 'Advance'] as $level)<option @selected($class->level === $level)>{{ $level }}</option>@endforeach
                        </select>
                        <select name="tutor_id" class="h-10 rounded-lg border border-slate-300 px-3">
                            @foreach ($tutors as $tutor)<option value="{{ $tutor->id }}" @selected($class->tutor_id === $tutor->id)>{{ $tutor->name }}</option>@endforeach
                        </select>
                        <input name="price" type="number" value="{{ (int) $class->price }}" required class="h-10 rounded-lg border border-slate-300 px-3">
                        <textarea name="description" required class="min-h-20 rounded-lg border border-slate-300 px-3 py-2 md:col-span-2 xl:col-span-5">{{ $class->description }}</textarea>
                        <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-bold text-white">Simpan Perubahan</button>
                    </form>
                    <div class="mt-3 flex items-center justify-between text-xs text-slate-500">
                        <span>{{ $class->schedules->count() }} jadwal · Tutor {{ $class->tutor->name }}</span>
                        <form action="{{ route('admin.courses.destroy', $class) }}" method="POST" onsubmit="return confirm('Hapus kelas beserta jadwalnya?')">
                            @csrf
                            @method('DELETE')
                            <button class="font-bold text-rose-600">Hapus kelas</button>
                        </form>
                    </div>
                </article>
            @empty
                <p class="p-10 text-center text-slate-400">Belum ada kelas.</p>
            @endforelse
        </div>
    </section>
@endsection
