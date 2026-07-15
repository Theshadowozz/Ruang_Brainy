@extends('layouts.siswa')

@section('title', 'Jadwal Saya - Brainy')

@section('content')
<div class="bg-blue-700 px-6 py-10 text-white sm:px-10 lg:px-28">
    <div class="mx-auto max-w-7xl">
        @include('siswa.partials.back-button', ['fallback' => route('siswa.dashboard')])
        <h1 class="mt-7 text-3xl font-extrabold sm:text-4xl">Jadwal Saya</h1>
        <p class="mt-2 text-blue-100">Hanya kelas yang pendaftarannya telah dikonfirmasi admin.</p>
    </div>
</div>

<main class="mx-auto max-w-7xl px-6 py-8 sm:px-10 lg:px-28">
    <nav class="mb-7 flex flex-wrap gap-2">
        @foreach (['aktif' => 'Kelas Aktif', 'selesai' => 'Kelas Selesai', 'jadwal' => 'Semua Jadwal'] as $key => $label)
            <a href="{{ route('siswa.jadwal.index', ['tab' => $key]) }}" class="rounded-lg px-4 py-2 text-sm font-bold {{ $activeTab === $key ? 'bg-blue-600 text-white' : 'border border-gray-200 bg-white text-gray-700' }}">{{ $label }}</a>
        @endforeach
    </nav>

    @php
        $visible = $activeTab === 'selesai' ? $finishedRegistrations : $activeRegistrations;
    @endphp
    <div class="grid gap-5 lg:grid-cols-2">
        @forelse ($visible as $registration)
            @php
                $schedule = $registration->schedule;
            @endphp
            <article class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div><span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">{{ $schedule->courseClass->language }} · {{ $schedule->courseClass->level }}</span><h2 class="mt-3 text-xl font-extrabold">{{ $schedule->courseClass->name }}</h2></div>
                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold uppercase text-emerald-700">{{ $registration->status }}</span>
                </div>
                <dl class="mt-5 grid grid-cols-2 gap-4 text-sm">
                    <div><dt class="text-gray-500">Hari</dt><dd class="font-bold">{{ $schedule->day }}</dd></div>
                    <div><dt class="text-gray-500">Jam</dt><dd class="font-bold">{{ substr($schedule->start_time, 0, 5) }}–{{ substr($schedule->end_time, 0, 5) }}</dd></div>
                    <div><dt class="text-gray-500">Tutor</dt><dd class="font-bold">{{ $schedule->courseClass->tutor->name }}</dd></div>
                    <div><dt class="text-gray-500">Ruangan</dt><dd class="font-bold">{{ $schedule->room }}</dd></div>
                    <div class="col-span-2"><dt class="text-gray-500">Periode jadwal</dt><dd class="font-bold">{{ $schedule->start_date->format('d/m/Y') }}–{{ $schedule->end_date->format('d/m/Y') }}</dd></div>
                    <div class="col-span-2"><dt class="text-gray-500">Masa akses</dt><dd class="font-bold {{ $registration->hasActiveAccess() ? 'text-emerald-700' : 'text-amber-700' }}">{{ $registration->access_starts_at?->format('d/m/Y H:i') ?? '-' }}–{{ $registration->access_ends_at?->format('d/m/Y H:i') ?? '-' }}</dd></div>
                </dl>
                @if (! $registration->hasActiveAccess() && $registration->status === 'accepted')
                    <form action="{{ route('siswa.registration.renew', $registration) }}" method="POST" class="mt-5">@csrf<button class="w-full rounded-lg bg-blue-700 px-4 py-3 text-sm font-black text-white">Perpanjang akses satu bulan</button></form>
                @endif
            </article>
        @empty
            <div class="rounded-xl border border-dashed border-gray-300 bg-white p-12 text-center text-gray-400 lg:col-span-2">Belum ada data pada bagian ini.</div>
        @endforelse
    </div>
</main>
@endsection
