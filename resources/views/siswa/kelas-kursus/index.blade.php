@extends('layouts.siswa')

@section('title', 'Kelas Kursus - Brainy')

@section('content')
<div class="text-white py-10 px-6 sm:px-10 lg:px-28" style="background-color: #1D4ED8;">
    <div class="mx-auto max-w-7xl">
        @include('siswa.partials.back-button', ['fallback' => route('siswa.dashboard')])

        <div class="mt-7 flex items-center gap-4">
            <div class="flex h-14 w-14 items-center justify-center rounded-lg bg-white/15">
                <img src="{{ asset('asset/kelas_kursus.svg') }}" alt="" class="h-8 w-8 object-contain brightness-0 invert">
            </div>
            <div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Kelas Kursus</h1>
                <p class="mt-2 text-blue-100 text-sm sm:text-base">Pilih kelas yang sesuai dengan kebutuhan belajar Anda</p>
            </div>
        </div>
    </div>
</div>

<div class="mx-auto max-w-7xl px-6 py-8 sm:px-10 lg:px-28 space-y-7">
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-5">
        <form id="filter-form" method="GET" action="{{ route('siswa.kelas-kursus.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="bahasa" class="text-sm font-semibold text-gray-700 block mb-2">Bahasa</label>
                    <select name="bahasa" id="bahasa" onchange="this.form.submit()" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5 px-3 bg-gray-50 border">
                        <option value="" {{ $filterBahasa === '' ? 'selected' : '' }}>Semua Bahasa</option>
                        <option value="Inggris" {{ $filterBahasa === 'Inggris' ? 'selected' : '' }}>Inggris</option>
                        <option value="Jepang" {{ $filterBahasa === 'Jepang' ? 'selected' : '' }}>Jepang</option>
                        <option value="Korea" {{ $filterBahasa === 'Korea' ? 'selected' : '' }}>Korea</option>
                    </select>
                </div>

                <div>
                    <label for="level" class="text-sm font-semibold text-gray-700 block mb-2">Level</label>
                    <select name="level" id="level" onchange="this.form.submit()" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5 px-3 bg-gray-50 border">
                        <option value="" {{ $filterLevel === '' ? 'selected' : '' }}>Semua Level</option>
                        <option value="Beginner" {{ $filterLevel === 'Beginner' ? 'selected' : '' }}>Beginner</option>
                        <option value="Intermediate" {{ $filterLevel === 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="Advance" {{ $filterLevel === 'Advance' ? 'selected' : '' }}>Advance</option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    @if($courses->isEmpty())
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-12 text-center">
            <div class="mx-auto w-14 h-14 mb-3 flex items-center justify-center bg-blue-50 rounded-lg">
                <img src="{{ asset('asset/kelas_kursus.svg') }}" alt="" class="h-7 w-7 object-contain">
            </div>
            <p class="text-gray-700 font-bold">Kelas belum ditemukan</p>
            <p class="text-gray-400 text-sm mt-1">Silakan ubah filter bahasa atau level.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($courses as $course)
                <article class="bg-white rounded-lg border border-gray-200 shadow-sm p-5 flex flex-col justify-between hover:shadow-md transition duration-200">
                    <div>
                        <div class="flex items-center justify-between gap-3">
                            <span class="{{ $course['level'] === 'Beginner' ? 'bg-gray-950 text-white' : 'bg-gray-100 text-gray-700' }} rounded-md px-2.5 py-1 text-[11px] font-bold uppercase">
                                {{ $course['level'] }}
                            </span>
                            <span class="rounded-md border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-[11px] font-semibold text-emerald-700">
                                {{ $course['status'] }}
                            </span>
                        </div>

                        <h2 class="mt-4 text-lg font-extrabold text-gray-950 leading-snug">{{ $course['title'] }}</h2>
                        <p class="mt-2 text-sm text-gray-500 leading-relaxed">{{ $course['description'] }}</p>

                        <dl class="mt-6 space-y-3 text-sm text-gray-900">
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                                </svg>
                                <dd>{{ $course['capacity'] }}</dd>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <rect x="3" y="4" width="18" height="18" rx="2" />
                                    <path stroke-linecap="round" d="M16 2v4M8 2v4M3 10h18" />
                                </svg>
                                <dd>{{ $course['schedule'] }}</dd>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <circle cx="12" cy="12" r="9" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2" />
                                </svg>
                                <dd>{{ $course['duration'] }} - {{ $course['sessions'] }}</dd>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <circle cx="12" cy="12" r="9" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4" />
                                </svg>
                                <dd>Mulai: {{ $course['start_date'] }}</dd>
                            </div>
                        </dl>

                        <div class="mt-5 border-t border-gray-200 pt-4 flex items-center gap-3">
                            <img src="{{ asset($course['tutor']['photo']) }}" alt="{{ $course['tutor']['display_name'] }}" class="h-11 w-11 rounded-full object-cover border border-gray-200">
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-gray-950 truncate">{{ $course['tutor']['display_name'] }}</p>
                                <p class="text-xs text-gray-500">{{ $course['tutor']['experience'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <p class="text-2xl font-extrabold text-blue-600">Rp {{ number_format($course['price'], 0, ',', '.') }}</p>
                        <a href="{{ route('siswa.kelas-kursus.show', $course['slug']) }}" class="mt-3 flex w-full items-center justify-center rounded-md bg-gray-950 px-4 py-2.5 text-sm font-bold text-white hover:bg-gray-800 transition">
                            Lihat Detail
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
@endsection
