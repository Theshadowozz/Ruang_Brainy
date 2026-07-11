@extends('layouts.admin')

@section('title', 'Brainy Admin - Waiting List')
@section('page_title', 'Waiting List')
@section('page_description', 'Antrean siswa yang tersimpan pada database.')
@php
    $activeTab = 'waitinglist';
@endphp

@section('content')
<section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-100 p-5"><h2 class="font-black">Daftar antrean ({{ $waitingLists->count() }})</h2></div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase text-slate-500"><tr><th class="px-5 py-3">No. Antrean</th><th class="px-5 py-3">Siswa</th><th class="px-5 py-3">Kontak</th><th class="px-5 py-3">Kelas</th><th class="px-5 py-3">Status</th></tr></thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($waitingLists as $item)
                    <tr><td class="px-5 py-4 font-black">{{ $item->queue_number }}</td><td class="px-5 py-4 font-bold">{{ $item->full_name }}</td><td class="px-5 py-4"><p>{{ $item->user->email }}</p><p class="text-xs text-slate-500">{{ $item->phone_number }}</p></td><td class="px-5 py-4">{{ $item->schedule->courseClass->name }}</td><td class="px-5 py-4 uppercase">{{ $item->status }}</td></tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-12 text-center text-slate-400">Belum ada siswa dalam waiting list.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
