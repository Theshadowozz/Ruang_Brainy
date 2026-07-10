@extends('layouts.admin')

@section('title', 'Brainy Admin - Data Siswa')
@section('page_title', 'Data Siswa & Trial')
@section('page_description', 'Data berasal dari form pendaftaran kelas dan trial.')
@php
    $activeTab = 'siswa';
@endphp

@section('content')
<section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-100 p-5"><h2 class="font-black">Pendaftaran kelas</h2></div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase text-slate-500"><tr><th class="px-5 py-3">Siswa</th><th class="px-5 py-3">Kontak</th><th class="px-5 py-3">Kelas & Jadwal</th><th class="px-5 py-3">Pembayaran</th><th class="px-5 py-3">Status</th></tr></thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($registrations as $registration)
                    <tr>
                        <td class="px-5 py-4 font-bold">{{ $registration->full_name }}</td>
                        <td class="px-5 py-4"><p>{{ $registration->user->email }}</p><p class="text-xs text-slate-500">{{ $registration->phone_number }}</p></td>
                        <td class="px-5 py-4"><p class="font-bold">{{ $registration->schedule->courseClass->name }}</p><p class="text-xs text-slate-500">{{ $registration->schedule->day }}, {{ substr($registration->schedule->start_time, 0, 5) }}–{{ substr($registration->schedule->end_time, 0, 5) }}</p></td>
                        <td class="px-5 py-4 uppercase">{{ $registration->payment?->status ?? '-' }}</td>
                        <td class="px-5 py-4 uppercase">{{ $registration->status }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400">Belum ada pendaftaran kelas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

<section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-100 p-5"><h2 class="font-black">Pendaftaran trial</h2></div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase text-slate-500"><tr><th class="px-5 py-3">Nama</th><th class="px-5 py-3">Email</th><th class="px-5 py-3">Telepon</th><th class="px-5 py-3">Tanggal</th><th class="px-5 py-3">Status</th></tr></thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($trialRegistrations as $trial)
                    <tr><td class="px-5 py-4 font-bold">{{ $trial->user->name }}</td><td class="px-5 py-4">{{ $trial->user->email }}</td><td class="px-5 py-4">{{ $trial->phone_number }}</td><td class="px-5 py-4">{{ $trial->created_at->format('d/m/Y H:i') }}</td><td class="px-5 py-4 uppercase">{{ $trial->status }}</td></tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400">Belum ada pendaftar trial.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
