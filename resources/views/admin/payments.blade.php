@extends('layouts.admin')

@section('title', 'Brainy Admin - Pembayaran Midtrans')
@section('page_title', 'Monitor Pembayaran')
@section('page_description', 'Status transaksi berasal dari webhook Midtrans; tidak perlu konfirmasi manual.')

@php $activeTab = 'payments'; @endphp

@section('content')
    @if (session('success'))<div class="rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-bold text-emerald-800">{{ session('success') }}</div>@endif

    <section class="grid gap-5 md:grid-cols-3">
        <article class="rounded-2xl bg-[#092a67] p-6 text-white shadow-lg"><p class="text-xs font-bold uppercase tracking-widest text-blue-200">Menunggu Midtrans</p><p class="mt-3 text-2xl font-black">Rp {{ number_format($pendingTotal, 0, ',', '.') }}</p></article>
        <article class="rounded-2xl border border-emerald-200 bg-emerald-50 p-6"><p class="text-xs font-bold uppercase tracking-widest text-emerald-700">Pembayaran berhasil</p><p class="mt-3 text-2xl font-black text-emerald-950">Rp {{ number_format($paidTotal, 0, ',', '.') }}</p></article>
        <article class="rounded-2xl border border-amber-200 bg-amber-50 p-6"><p class="text-xs font-bold uppercase tracking-widest text-amber-700">Refund tercatat</p><p class="mt-3 text-2xl font-black text-amber-950">Rp {{ number_format($refundedTotal, 0, ',', '.') }}</p></article>
    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 p-6"><h2 class="text-lg font-black">Arus transaksi siswa</h2><p class="mt-1 text-sm text-slate-500">Settlement/capture memproses aktivasi otomatis. Browser tidak dapat mengubah status transaksi.</p></div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500"><tr><th class="px-5 py-4">Siswa & kelas</th><th class="px-5 py-4">Order</th><th class="px-5 py-4">Rincian</th><th class="px-5 py-4">Midtrans</th><th class="px-5 py-4">Akses</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($payments as $payment)
                        @php
                            $registration = $payment->registration;
                            $statusClass = match ($payment->status) {
                                'paid' => 'bg-emerald-50 text-emerald-700',
                                'failed' => 'bg-rose-50 text-rose-700',
                                'cancelled' => 'bg-slate-100 text-slate-600',
                                default => 'bg-amber-50 text-amber-700',
                            };
                        @endphp
                        <tr class="align-top">
                            <td class="px-5 py-5"><p class="font-black">{{ $registration->full_name }}</p><p class="mt-1 text-xs text-slate-500">{{ $registration->user->email }}</p><p class="mt-2 text-sm font-bold text-blue-800">{{ $registration->schedule->courseClass->name }}</p><span class="mt-2 inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-black uppercase">{{ $payment->type }}</span></td>
                            <td class="max-w-64 px-5 py-5"><p class="break-all font-mono text-xs font-bold">{{ $payment->order_id ?? 'Legacy' }}</p><p class="mt-2 text-xs text-slate-400">{{ $payment->created_at->format('d/m/Y H:i') }}</p></td>
                            <td class="px-5 py-5"><p class="text-xs text-slate-500">Subtotal Rp {{ number_format($payment->subtotal, 0, ',', '.') }}</p><p class="text-xs text-slate-500">Admin Rp {{ number_format($payment->admin_fee, 0, ',', '.') }}</p><p class="mt-1 font-black">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p></td>
                            <td class="px-5 py-5"><span class="rounded-full px-3 py-1 text-xs font-black uppercase {{ $statusClass }}">{{ $payment->status }}</span><p class="mt-3 text-xs font-bold text-slate-600">Gateway: {{ strtoupper($payment->midtrans_status ?? 'belum mulai') }}</p>@if($payment->paid_at)<p class="mt-1 text-xs text-slate-400">{{ $payment->paid_at->format('d/m/Y H:i') }}</p>@endif @if($payment->isRefunded())<p class="mt-2 text-xs font-black text-amber-700">Refund: {{ $payment->refund_id }}</p>@endif</td>
                            <td class="px-5 py-5"><p class="text-xs font-black uppercase text-slate-600">{{ $registration->status }}</p>@if($registration->access_ends_at)<p class="mt-2 text-xs text-slate-500">Sampai {{ $registration->access_ends_at->format('d/m/Y H:i') }}</p>@elseif($registration->status === 'waiting_list')<p class="mt-2 text-xs font-bold text-amber-700">Menunggu kursi</p>@endif</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-14 text-center text-slate-400">Belum ada transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
