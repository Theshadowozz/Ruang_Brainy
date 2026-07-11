@extends('layouts.admin')

@section('title', 'Brainy Admin - Tutor')
@section('page_title', 'Kelola Tutor')
@section('page_description', 'Profil tutor sekaligus akun login dashboard masing-masing.')
@php
    $activeTab = 'tutors';
@endphp

@section('content')
<section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
    <h2 class="text-lg font-black">Tambah tutor dan akun login</h2>
    <form action="{{ route('admin.tutors.store') }}" method="POST" class="mt-5 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        @csrf
        <input name="name" value="{{ old('name') }}" required placeholder="Nama lengkap" class="h-11 rounded-xl border border-slate-300 px-4">
        <input name="email" type="email" value="{{ old('email') }}" required placeholder="Email login" class="h-11 rounded-xl border border-slate-300 px-4">
        <input name="phone_number" value="{{ old('phone_number') }}" required placeholder="Nomor telepon" class="h-11 rounded-xl border border-slate-300 px-4">
        <input name="expertise" value="{{ old('expertise') }}" required placeholder="Keahlian, contoh: Bahasa Inggris" class="h-11 rounded-xl border border-slate-300 px-4">
        <input name="password" type="password" required placeholder="Password" class="h-11 rounded-xl border border-slate-300 px-4">
        <input name="password_confirmation" type="password" required placeholder="Konfirmasi password" class="h-11 rounded-xl border border-slate-300 px-4">
        <button class="rounded-xl bg-blue-600 px-5 py-3 font-bold text-white hover:bg-blue-700 xl:col-span-3">Simpan Tutor</button>
    </form>
</section>

<section class="grid gap-5 lg:grid-cols-2">
    @forelse ($tutors as $tutor)
        <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-5 flex items-center justify-between">
                <div><h2 class="font-black">{{ $tutor->name }}</h2><p class="text-sm text-slate-500">{{ $tutor->classes_count }} kelas · {{ $tutor->user ? 'Akun login aktif' : 'Belum memiliki akun login' }}</p></div>
                <form action="{{ route('admin.tutors.destroy', $tutor) }}" method="POST" onsubmit="return confirm('Hapus tutor, akun, kelas, dan jadwal terkait?')">
                    @csrf @method('DELETE')
                    <button class="text-sm font-bold text-rose-600">Hapus</button>
                </form>
            </div>
            <form action="{{ route('admin.tutors.update', $tutor) }}" method="POST" class="grid gap-3 sm:grid-cols-2">
                @csrf @method('PUT')
                <input name="name" value="{{ $tutor->name }}" required class="h-10 rounded-lg border border-slate-300 px-3">
                <input name="email" type="email" value="{{ $tutor->email }}" required class="h-10 rounded-lg border border-slate-300 px-3">
                <input name="phone_number" value="{{ $tutor->phone_number }}" required class="h-10 rounded-lg border border-slate-300 px-3">
                <input name="expertise" value="{{ $tutor->expertise }}" required class="h-10 rounded-lg border border-slate-300 px-3">
                <input name="password" type="password" placeholder="{{ $tutor->user ? 'Password baru (opsional)' : 'Password wajib' }}" class="h-10 rounded-lg border border-slate-300 px-3">
                <input name="password_confirmation" type="password" placeholder="Konfirmasi password" class="h-10 rounded-lg border border-slate-300 px-3">
                <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-bold text-white sm:col-span-2">Simpan Perubahan</button>
            </form>
            @if ($tutor->classes->isNotEmpty())
                <div class="mt-5 border-t border-slate-100 pt-4 text-sm text-slate-600">
                    <p class="mb-2 font-bold text-slate-900">Kelas yang diajar</p>
                    @foreach ($tutor->classes as $class)
                        <p>{{ $class->name }} · {{ $class->schedules->count() }} jadwal</p>
                    @endforeach
                </div>
            @endif
        </article>
    @empty
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center text-slate-400 lg:col-span-2">Belum ada tutor. Tambahkan tutor agar kelas dapat dibuat.</div>
    @endforelse
</section>
@endsection
