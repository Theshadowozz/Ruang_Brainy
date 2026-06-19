@extends('layouts.siswa')

@section('title', 'Audio Listening - Brainy')

@section('content')
<!-- Header Banner -->
<div class="text-white py-12 px-6 sm:px-10 lg:px-28" style="background-color: #1D4ED8;">
    <div class="mx-auto max-w-7xl">
        @include('siswa.partials.back-button', ['fallback' => route('siswa.dashboard')])

        <div class="mt-7 flex items-center gap-4">
            <!-- Headphone Icon -->
            <div class="p-3 bg-white/15 rounded-xl">
                <img src="{{ asset('asset/audio_listening.svg') }}" alt="" class="h-10 w-10 object-contain brightness-0 invert">
            </div>
            <div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Audio Listening</h1>
                <p class="mt-2 text-blue-100 text-sm sm:text-base">Latih kemampuan mendengar dengan audio lessons</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Container -->
<div class="mx-auto max-w-7xl px-6 py-8 sm:px-10 lg:px-28 space-y-8">

    <!-- Filter Section (Card) -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-5">
        <form id="filter-form" method="GET" action="{{ url('/siswa/audio') }}">
            <div class="max-w-xs">
                <label for="bahasa" class="text-sm font-semibold text-gray-700 block mb-2">Filter Bahasa</label>
                <select name="bahasa" id="bahasa" onchange="this.form.submit()" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3 bg-white border">
                    <option value="" {{ $filterBahasa == '' ? 'selected' : '' }}>Semua Bahasa</option>
                    <option value="Inggris" {{ $filterBahasa == 'Inggris' ? 'selected' : '' }}>Inggris</option>
                    <option value="Jepang" {{ $filterBahasa == 'Jepang' ? 'selected' : '' }}>Jepang</option>
                    <option value="Korea" {{ $filterBahasa == 'Korea' ? 'selected' : '' }}>Korea</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Audio Grid Section -->
    @if($audioLessons->isEmpty())
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-12 text-center">
            <div class="mx-auto w-16 h-16 text-gray-400 mb-4 flex items-center justify-center bg-gray-50 rounded-full">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                </svg>
            </div>
            <p class="text-gray-600 font-semibold text-lg">Tidak ada audio lesson ditemukan</p>
            <p class="text-gray-400 text-sm mt-1">Silakan coba ganti filter bahasa atau hubungi tutor Anda.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($audioLessons as $audio)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex flex-col justify-between hover:shadow-md transition duration-200">
                    <div class="space-y-4">
                        <!-- Top Row: Badge Level and Badge Bahasa -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="bg-gray-900 text-white text-[10px] sm:text-xs font-semibold px-2.5 py-1 rounded">
                                    {{ $audio->level }}
                                </span>
                                <!-- Listened status indicator -->
                                <span id="listened-badge-{{ $audio->id }}" class="{{ $audio->listens_exists ? '' : 'hidden' }} bg-emerald-50 text-emerald-700 border border-emerald-100 text-[10px] sm:text-xs px-2.5 py-1 rounded font-semibold flex items-center gap-1">
                                    <svg class="h-3.5 w-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Sudah Didengar
                                </span>
                            </div>

                            <span class="border border-gray-300 text-gray-600 text-[10px] sm:text-xs px-2.5 py-1 rounded flex items-center gap-1.5 font-medium bg-gray-50">
                                @if($audio->language == 'Inggris')
                                    <span>🇬🇧</span>
                                @elseif($audio->language == 'Jepang')
                                    <span>🇯🇵</span>
                                @elseif($audio->language == 'Korea')
                                    <span>🇰🇷</span>
                                @endif
                                <span>{{ $audio->language }}</span>
                            </span>
                        </div>

                        <!-- Audio Details -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-950 leading-snug line-clamp-2">
                                {{ $audio->title }}
                            </h3>
                            <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                <svg class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Durasi: {{ $audio->duration }}</span>
                            </p>
                        </div>

                        <!-- Audio Player -->
                        <div class="bg-gray-50 p-2 rounded-lg border border-gray-100">
                            <audio controls class="w-full" onplay="markAsListened({{ $audio->id }})">
                                <source src="{{ asset('storage/' . $audio->audio_file) }}" type="audio/mpeg">
                                Browser Anda tidak mendukung pemutar audio HTML5.
                            </audio>
                        </div>

                        <!-- Transcript Section -->
                        <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Transkrip</h4>
                            <p id="transcript-preview-{{ $audio->id }}" class="text-gray-500 italic text-sm">
                                [Audio transcript akan muncul di sini untuk membantu Anda mengikuti materi...]
                            </p>
                            <p id="transcript-full-{{ $audio->id }}" class="hidden text-gray-700 font-normal leading-relaxed text-sm">
                                {{ $audio->transcript ?? 'Transkrip tidak tersedia.' }}
                            </p>
                        </div>
                    </div>

                    <!-- Footer Action Buttons -->
                    <div class="mt-6 flex items-center gap-3">
                        <!-- Download Audio Button -->
                        <a href="{{ route('siswa.audio.download', $audio->id) }}" class="flex-1 border border-gray-300 rounded-md py-2 px-4 text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 transition text-center flex items-center justify-center gap-2">
                            <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            <span>Download Audio</span>
                        </a>

                        <!-- Toggle Transcript Button -->
                        <button type="button" id="btn-transcript-{{ $audio->id }}" onclick="toggleTranscript({{ $audio->id }})" class="flex-1 border border-gray-300 rounded-md py-2 px-4 text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 transition text-center">
                            Lihat Transkrip Lengkap
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Tips Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-bold text-gray-950 mb-4 flex items-center gap-2">
            <span class="text-blue-600 text-xl">💡</span>
            <span>Tips Belajar dengan Audio</span>
        </h2>
        <ol class="space-y-3.5">
            <li class="flex items-start gap-3">
                <span class="text-blue-600 font-extrabold text-sm mt-0.5 bg-blue-50 h-5 w-5 rounded-full flex items-center justify-center flex-shrink-0">1</span>
                <p class="text-sm text-gray-700 leading-relaxed">Dengarkan audio minimal 3 kali untuk pemahaman maksimal.</p>
            </li>
            <li class="flex items-start gap-3">
                <span class="text-blue-600 font-extrabold text-sm mt-0.5 bg-blue-50 h-5 w-5 rounded-full flex items-center justify-center flex-shrink-0">2</span>
                <p class="text-sm text-gray-700 leading-relaxed">Gunakan transkrip hanya setelah mencoba mendengar tanpa teks.</p>
            </li>
            <li class="flex items-start gap-3">
                <span class="text-blue-600 font-extrabold text-sm mt-0.5 bg-blue-50 h-5 w-5 rounded-full flex items-center justify-center flex-shrink-0">3</span>
                <p class="text-sm text-gray-700 leading-relaxed">Ulangi kata atau frasa yang sulit untuk melatih pronunciation.</p>
            </li>
            <li class="flex items-start gap-3">
                <span class="text-blue-600 font-extrabold text-sm mt-0.5 bg-blue-50 h-5 w-5 rounded-full flex items-center justify-center flex-shrink-0">4</span>
                <p class="text-sm text-gray-700 leading-relaxed">Catat vocabulary baru dan review secara berkala.</p>
            </li>
        </ol>
    </div>

</div>

<!-- Page Javascript functions -->
<script>
    /**
     * Toggles the visibility of the transcript elements for a specific card.
     */
    function toggleTranscript(id) {
        const preview = document.getElementById('transcript-preview-' + id);
        const full = document.getElementById('transcript-full-' + id);
        const btn = document.getElementById('btn-transcript-' + id);
        
        if (full.classList.contains('hidden')) {
            full.classList.remove('hidden');
            preview.classList.add('hidden');
            btn.textContent = 'Sembunyikan Transkrip';
        } else {
            full.classList.add('hidden');
            preview.classList.remove('hidden');
            btn.textContent = 'Lihat Transkrip Lengkap';
        }
    }

    /**
     * Sends a background POST request to mark the audio lesson as listened.
     */
    function markAsListened(id) {
        const url = `/siswa/audio/${id}/listen`;
        
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Dynamically show the "Already Listened" badge
                const badge = document.getElementById('listened-badge-' + id);
                if (badge) {
                    badge.classList.remove('hidden');
                }
            }
        })
        .catch(error => {
            console.error('Error recording audio listen tracking:', error);
        });
    }
</script>
@endsection
