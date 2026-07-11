@extends('layouts.admin')

@section('title', 'Brainy Admin - Jadwal Kelas')
@section('page_title', 'Jadwal Kelas')
@section('page_description', 'Jadwal aktif akan muncul pada katalog pendaftaran siswa.')

@php
    $activeTab = 'schedules';
@endphp

@section('content')
    @if (session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-bold text-emerald-800">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="rounded-xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm font-bold text-rose-800">{{ $errors->first() }}</div>
    @endif

    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-black">Tambah jadwal</h2>
        <form action="{{ route('admin.schedules.store') }}" method="POST" class="mt-5 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @csrf
            <select name="class_id" required class="h-11 rounded-xl border border-slate-300 px-4 md:col-span-2">
                <option value="">Pilih kelas</option>
                @foreach ($classes as $class)<option value="{{ $class->id }}">{{ $class->name }}</option>@endforeach
            </select>
            <input name="day" required placeholder="Hari, contoh: Senin & Rabu" class="h-11 rounded-xl border border-slate-300 px-4">
            <input name="room" required placeholder="Ruangan" class="h-11 rounded-xl border border-slate-300 px-4">
            <label class="text-xs font-bold text-slate-500">Tanggal mulai<input name="start_date" type="date" required class="mt-1 h-11 w-full rounded-xl border border-slate-300 px-4 text-slate-900"></label>
            <label class="text-xs font-bold text-slate-500">Tanggal selesai<input name="end_date" type="date" required class="mt-1 h-11 w-full rounded-xl border border-slate-300 px-4 text-slate-900"></label>
            <label class="text-xs font-bold text-slate-500">Jam mulai<input name="start_time" type="time" required class="mt-1 h-11 w-full rounded-xl border border-slate-300 px-4 text-slate-900"></label>
            <label class="text-xs font-bold text-slate-500">Jam selesai<input name="end_time" type="time" required class="mt-1 h-11 w-full rounded-xl border border-slate-300 px-4 text-slate-900"></label>
            <input name="capacity" type="number" min="1" required placeholder="Kapasitas siswa" class="h-11 rounded-xl border border-slate-300 px-4">
            <button class="rounded-xl bg-blue-600 px-5 py-3 font-bold text-white hover:bg-blue-700">Simpan Jadwal</button>
        </form>
    </section>

    <section class="grid gap-5 lg:grid-cols-2">
        @forelse ($schedules as $schedule)
            <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST" class="grid gap-3 sm:grid-cols-2">
                    @csrf
                    @method('PUT')
                    <select name="class_id" class="h-10 rounded-lg border border-slate-300 px-3 sm:col-span-2">
                        @foreach ($classes as $class)<option value="{{ $class->id }}" @selected($schedule->class_id === $class->id)>{{ $class->name }}</option>@endforeach
                    </select>
                    <input name="day" value="{{ $schedule->day }}" required class="h-10 rounded-lg border border-slate-300 px-3">
                    <input name="room" value="{{ $schedule->room }}" required class="h-10 rounded-lg border border-slate-300 px-3">
                    <input name="start_date" type="date" value="{{ $schedule->start_date->format('Y-m-d') }}" required class="h-10 rounded-lg border border-slate-300 px-3">
                    <input name="end_date" type="date" value="{{ $schedule->end_date->format('Y-m-d') }}" required class="h-10 rounded-lg border border-slate-300 px-3">
                    <input name="start_time" type="time" value="{{ substr($schedule->start_time, 0, 5) }}" required class="h-10 rounded-lg border border-slate-300 px-3">
                    <input name="end_time" type="time" value="{{ substr($schedule->end_time, 0, 5) }}" required class="h-10 rounded-lg border border-slate-300 px-3">
                    <input name="capacity" type="number" min="1" value="{{ $schedule->capacity }}" required class="h-10 rounded-lg border border-slate-300 px-3">
                    <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-bold text-white">Simpan Perubahan</button>
                </form>
                <div class="mt-4 flex items-center justify-between text-xs text-slate-500">
                    <span>Tutor {{ $schedule->courseClass->tutor->name }}</span>
                    <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="font-bold text-rose-600">Hapus jadwal</button>
                    </form>
                </div>
            </article>
        @empty
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center text-slate-400 lg:col-span-2">Belum ada jadwal.</div>
        @endforelse
    </section>
@endsection
