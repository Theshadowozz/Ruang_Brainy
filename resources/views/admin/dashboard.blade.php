@extends('layouts.admin')

@section('title', 'Brainy Admin - Dashboard')
@section('page_title', 'Dasbor Ringkasan')
@section('page_description', 'Seluruh angka berikut dihitung dari data pengguna dan transaksi.')
@php
    $activeTab = 'dashboard';
@endphp

@section('content')
<section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-6">
    @foreach ([
        ['Siswa', $stats['students'], 'users', 'text-blue-700 bg-blue-50'],
        ['Kelas', $stats['classes'], 'graduation-cap', 'text-violet-700 bg-violet-50'],
        ['Tutor', $stats['tutors'], 'user-check', 'text-cyan-700 bg-cyan-50'],
        ['Trial', $stats['trials'], 'sparkles', 'text-fuchsia-700 bg-fuchsia-50'],
        ['Waiting List', $stats['waiting'], 'clipboard-list', 'text-amber-700 bg-amber-50'],
    ] as [$label, $value, $icon, $color])
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div><p class="text-xs font-bold uppercase tracking-wide text-slate-400">{{ $label }}</p><p class="mt-2 text-3xl font-black">{{ $value }}</p></div>
                <span class="rounded-xl p-3 {{ $color }}"><i data-lucide="{{ $icon }}" class="h-5 w-5"></i></span>
            </div>
        </article>
    @endforeach
    <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:col-span-2 xl:col-span-1">
        <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Pendapatan</p>
        <p class="mt-2 text-xl font-black text-emerald-700">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</p>
    </article>
</section>

<section class="grid gap-6 xl:grid-cols-2">
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 p-5">
            <h2 class="font-black">Siswa dengan pembayaran terkonfirmasi</h2>
            <p class="mt-1 text-sm text-slate-500">Pendaftaran tampil di sini setelah admin mengonfirmasi pembayaran.</p>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse ($confirmedRegistrations as $registration)
                <div class="flex items-center justify-between gap-4 p-5">
                    <div>
                        <p class="font-bold">{{ $registration->full_name }}</p>
                        <p class="text-sm text-slate-500">{{ $registration->user->email }} · {{ $registration->schedule->courseClass->name }}</p>
                    </div>
                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700">Aktif</span>
                </div>
            @empty
                <p class="p-8 text-center text-sm text-slate-400">Belum ada pembayaran yang dikonfirmasi.</p>
            @endforelse
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-100 p-5">
            <div><h2 class="font-black">Pembayaran menunggu verifikasi</h2><p class="mt-1 text-sm text-slate-500">Siswa sudah menekan tombol pembayaran.</p></div>
            <a href="{{ route('admin.payments.index') }}" class="text-sm font-bold text-blue-700">Buka</a>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse ($pendingPayments as $payment)
                <div class="flex items-center justify-between gap-4 p-5">
                    <div><p class="font-bold">{{ $payment->registration->full_name }}</p><p class="text-sm text-slate-500">{{ $payment->registration->schedule->courseClass->name }}</p></div>
                    <p class="font-black">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                </div>
            @empty
                <p class="p-8 text-center text-sm text-slate-400">Tidak ada pembayaran yang menunggu.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="flex items-center justify-between border-b border-slate-100 p-5">
        <div><h2 class="font-black">Pendaftar trial terbaru</h2><p class="mt-1 text-sm text-slate-500">Data berasal dari form trial pada landing page.</p></div>
        <a href="{{ route('admin.students') }}" class="text-sm font-bold text-blue-700">Lihat semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase text-slate-500"><tr><th class="px-5 py-3">Nama</th><th class="px-5 py-3">Email</th><th class="px-5 py-3">Telepon</th><th class="px-5 py-3">Status</th></tr></thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($trialRegistrations as $trial)
                    <tr><td class="px-5 py-4 font-bold">{{ $trial->user->name }}</td><td class="px-5 py-4">{{ $trial->user->email }}</td><td class="px-5 py-4">{{ $trial->phone_number }}</td><td class="px-5 py-4 uppercase">{{ $trial->status }}</td></tr>
                @empty
                    <tr><td colspan="4" class="px-5 py-8 text-center text-slate-400">Belum ada pendaftar trial.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
