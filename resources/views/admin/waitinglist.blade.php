@extends('layouts.admin')

@section('title', 'Brainy Admin - Waiting List')
@section('page_title', 'Waiting List Kapasitas')
@section('page_description', 'Promosikan antrean pertama saat kursi tersedia, atau catat refund yang sudah diproses di Midtrans Dashboard.')
@php $activeTab = 'waitinglist'; @endphp

@section('content')
@if (session('success'))<div class="rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-bold text-emerald-800">{{ session('success') }}</div>@endif
@if ($errors->any())<div class="rounded-xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm font-bold text-rose-800">{{ $errors->first() }}</div>@endif

<section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="flex flex-col justify-between gap-3 border-b border-slate-100 p-6 sm:flex-row sm:items-center"><div><h2 class="text-lg font-black">Antrean siswa ({{ $waitingLists->where('status', 'waiting')->count() }})</h2><p class="mt-1 text-sm text-slate-500">Urutan promosi mengikuti nomor antrean dalam jadwal yang sama.</p></div><span class="rounded-full bg-amber-100 px-4 py-2 text-xs font-black text-amber-900">Bayar dulu · kursi menyusul</span></div>
    <div class="divide-y divide-slate-100">
        @forelse ($waitingLists as $item)
            @php
                $registration = $item->user->registrations->firstWhere('schedule_id', $item->schedule_id);
                $payment = $registration?->latestPayment;
            @endphp
            <article class="grid gap-5 p-6 lg:grid-cols-[auto_1.2fr_1fr_1.4fr] lg:items-center">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#092a67] text-xl font-black text-white">#{{ $item->queue_number }}</div>
                <div><p class="font-black">{{ $item->full_name }}</p><p class="mt-1 text-xs text-slate-500">{{ $item->user->email }} · {{ $item->phone_number }}</p><span class="mt-2 inline-flex rounded-full px-3 py-1 text-[10px] font-black uppercase {{ $item->status === 'waiting' ? 'bg-amber-50 text-amber-700' : 'bg-slate-100 text-slate-600' }}">{{ $item->status }}</span></div>
                <div><p class="font-bold">{{ $item->schedule->courseClass->name }}</p><p class="mt-1 text-xs text-slate-500">{{ $item->schedule->day }} · kapasitas {{ $item->schedule->capacity }}</p>@if($payment)<p class="mt-2 text-xs font-black {{ $payment->status === 'paid' ? 'text-emerald-700' : 'text-amber-700' }}">Midtrans: {{ strtoupper($payment->midtrans_status ?? $payment->status) }} · Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>@endif</div>
                <div class="space-y-3">
                    @if ($item->status === 'waiting' && $payment?->status === 'paid')
                        <form action="{{ route('admin.waitinglist.promote', $item) }}" method="POST">@csrf<button class="w-full rounded-xl bg-emerald-600 px-4 py-3 text-sm font-black text-white hover:bg-emerald-700">Promosikan ke kelas</button></form>
                        <details class="rounded-xl border border-amber-200 bg-amber-50 p-4"><summary class="cursor-pointer text-sm font-black text-amber-900">Catat refund manual</summary><form action="{{ route('admin.waitinglist.refund', $item) }}" method="POST" class="mt-3 space-y-2">@csrf<input name="refund_id" required placeholder="Reference refund Midtrans" class="h-10 w-full rounded-lg border border-amber-200 bg-white px-3 text-sm"><textarea name="refund_note" placeholder="Catatan refund" class="w-full rounded-lg border border-amber-200 bg-white px-3 py-2 text-sm"></textarea><button class="w-full rounded-lg bg-amber-700 px-3 py-2 text-xs font-black text-white">Sudah refund di Midtrans</button></form></details>
                    @else
                        <p class="rounded-xl bg-slate-50 px-4 py-3 text-center text-xs font-bold text-slate-500">{{ $payment?->status === 'paid' ? 'Antrean sudah diproses' : 'Tunggu pembayaran berhasil' }}</p>
                    @endif
                </div>
            </article>
        @empty
            <p class="p-14 text-center text-slate-400">Belum ada siswa dalam waiting list.</p>
        @endforelse
    </div>
</section>
@endsection
