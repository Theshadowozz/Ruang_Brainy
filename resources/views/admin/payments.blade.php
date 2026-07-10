@extends('layouts.admin')

@section('title', 'Brainy Admin - Pembayaran')
@section('page_title', 'Manajemen Pembayaran')
@section('page_description', 'Konfirmasi pembayaran agar akun siswa dapat digunakan.')

@php
    $activeTab = 'payments';
@endphp

@section('content')
    @if (session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-bold text-emerald-800">{{ session('success') }}</div>
    @endif

    <section class="grid gap-5 md:grid-cols-3">
        <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold text-slate-500">Semua transaksi</p>
            <p class="mt-2 text-3xl font-black">{{ $payments->count() }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold text-slate-500">Menunggu konfirmasi</p>
            <p class="mt-2 text-3xl font-black text-amber-600">Rp {{ number_format($pendingTotal, 0, ',', '.') }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold text-slate-500">Terkonfirmasi</p>
            <p class="mt-2 text-3xl font-black text-emerald-600">Rp {{ number_format($paidTotal, 0, ',', '.') }}</p>
        </article>
    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 p-6">
            <h2 class="text-lg font-black">Daftar pembayaran siswa</h2>
            <p class="mt-1 text-sm text-slate-500">Pembayaran hanya dapat dikonfirmasi setelah siswa menekan tombol “Lakukan Pembayaran”.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Siswa</th>
                        <th class="px-6 py-4">Kelas</th>
                        <th class="px-6 py-4">Jumlah</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($payments as $payment)
                        <tr>
                            <td class="px-6 py-4">
                                <p class="font-bold">{{ $payment->registration->full_name }}</p>
                                <p class="mt-1 text-xs text-slate-500">{{ $payment->registration->user->email }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold">{{ $payment->registration->schedule->courseClass->name }}</p>
                                <p class="mt-1 text-xs text-slate-500">{{ $payment->registration->schedule->day }}</p>
                            </td>
                            <td class="px-6 py-4 font-black">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClass = match ($payment->status) {
                                        'paid' => 'bg-emerald-50 text-emerald-700',
                                        'failed' => 'bg-rose-50 text-rose-700',
                                        default => 'bg-amber-50 text-amber-700',
                                    };
                                @endphp
                                <span class="rounded-full px-3 py-1 text-xs font-extrabold {{ $statusClass }}">{{ strtoupper($payment->status) }}</span>
                                @if (! $payment->transaction_code && $payment->status === 'pending')
                                    <p class="mt-2 text-xs font-semibold text-slate-400">Belum dibayar siswa</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    @if ($payment->status === 'pending' && $payment->transaction_code)
                                        <form action="{{ route('admin.payments.confirm', $payment) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button class="rounded-lg bg-emerald-600 px-3 py-2 text-xs font-bold text-white hover:bg-emerald-700">Konfirmasi</button>
                                        </form>
                                        <form action="{{ route('admin.payments.reject', $payment) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button class="rounded-lg bg-rose-50 px-3 py-2 text-xs font-bold text-rose-700 hover:bg-rose-100">Tolak</button>
                                        </form>
                                    @else
                                        <span class="text-xs font-semibold text-slate-400">Tidak ada aksi</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-14 text-center text-slate-400">Belum ada data pembayaran.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
