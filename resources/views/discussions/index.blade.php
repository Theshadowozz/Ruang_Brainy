@php
    $activeTab = 'diskusi';
    $activeLabel = $categories[$activeCategory];
    $storeRoute = route($rolePrefix . '.diskusi.store');
    $liveRoute = route($rolePrefix . '.diskusi.live', ['category' => $activeCategory]);
    $isSiswaLayout = $rolePrefix === 'siswa';
    $backFallback = match ($rolePrefix) {
        'admin' => route('admin.dashboard'),
        'tutor' => route('tutor.dashboard'),
        default => route('siswa.dashboard'),
    };
@endphp

@extends($layout)

@section('title', 'Forum Diskusi - Brainy')
@section('page_title', 'Forum Diskusi')
@section('page_description', 'Pantau pertanyaan, keluhan, dan diskusi pembelajaran dari semua role.')

@section('content')
<div class="{{ $isSiswaLayout ? '' : 'space-y-6' }}">
    <div class="text-white px-6 py-8 sm:px-8 {{ $isSiswaLayout ? 'sm:px-10 lg:px-28' : 'rounded-2xl shadow-sm' }}" style="background-color: #1D4ED8;">
        <div class="mx-auto {{ $isSiswaLayout ? 'max-w-7xl' : '' }}">
            <button
                type="button"
                onclick="if (window.history.length > 1 && document.referrer.startsWith(window.location.origin) && document.referrer !== window.location.href) { window.history.back(); } else { window.location.href = '{{ $backFallback }}'; }"
                class="inline-flex items-center gap-2 rounded-md bg-white px-3.5 py-2 text-sm font-bold text-blue-700 shadow-sm transition hover:bg-blue-50"
            >
                <img src="{{ asset('asset/back.svg') }}" alt="" class="h-4 w-4 object-contain">
                <span>Kembali</span>
            </button>

            <div class="mt-7 flex items-center gap-5">
                <div class="flex h-16 w-16 items-center justify-center rounded-lg border border-white/30 bg-white/10">
                    <img src="{{ asset('asset/diskusi.svg') }}" alt="" class="h-9 w-9 object-contain brightness-0 invert">
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight">Forum Diskusi</h1>
                    <p class="mt-2 text-blue-100">Pilih kategori untuk melihat chat forum yang sesuai.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto {{ $isSiswaLayout ? 'max-w-7xl px-6 py-8 sm:px-10 lg:px-28' : '' }}">
        @if(session('success'))
            <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="grid grid-cols-1 gap-8 xl:grid-cols-[1fr_450px]">
            <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <div class="grid grid-cols-1 gap-3 rounded-lg border border-gray-200 bg-gray-50 p-4 md:grid-cols-3">
                    @foreach($categories as $categoryKey => $categoryLabel)
                        <a
                            href="{{ route($rolePrefix . '.diskusi.index', ['category' => $categoryKey]) }}"
                            class="flex items-center justify-between rounded-lg border px-5 py-4 text-sm font-bold transition {{ $activeCategory === $categoryKey ? 'border-blue-200 bg-blue-50 text-blue-700' : 'border-transparent bg-white text-gray-600 hover:border-gray-200 hover:text-gray-950' }}"
                        >
                            <span>{{ $categoryLabel }}</span>
                            <span class="rounded-full bg-white px-3 py-1 text-xs text-gray-700 shadow-sm">{{ $categoryCounts[$categoryKey] ?? 0 }}</span>
                        </a>
                    @endforeach
                </div>

                <div class="mt-7 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-sm font-bold text-gray-500">Kategori aktif</p>
                        <h2 class="mt-1 text-2xl font-extrabold text-gray-950">{{ $activeLabel }}</h2>
                    </div>
                    <p id="discussion-topic-count" class="text-sm text-gray-600">{{ $topics->count() }} topik ditampilkan</p>
                </div>

                <div id="discussion-topic-list" class="mt-6 space-y-5" data-live-url="{{ $liveRoute }}">
                    @include('discussions.partials.topics', [
                        'activeCategory' => $activeCategory,
                        'activeLabel' => $activeLabel,
                        'rolePrefix' => $rolePrefix,
                        'topics' => $topics,
                    ])
                </div>
            </section>

            <aside id="form-topik" class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm xl:sticky xl:top-24">
                <h2 class="text-2xl font-extrabold text-gray-950">Buat Topik Diskusi</h2>
                <p class="mt-2 text-sm text-gray-600">Topik akan muncul di tab kategori yang dipilih.</p>

                <form method="POST" action="{{ $storeRoute }}" class="mt-8 space-y-6">
                    @csrf
                    <div>
                        <label for="category" class="block text-sm font-bold text-gray-950">Kategori</label>
                        <select id="category" name="category" class="mt-3 block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500">
                            @foreach($categories as $categoryKey => $categoryLabel)
                                <option value="{{ $categoryKey }}" {{ old('category', $activeCategory) === $categoryKey ? 'selected' : '' }}>{{ $categoryLabel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="title" class="block text-sm font-bold text-gray-950">Judul</label>
                        <input id="title" name="title" value="{{ old('title') }}" class="mt-3 block w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: Tips meningkatkan speaking">
                    </div>

                    <div>
                        <label for="body" class="block text-sm font-bold text-gray-950">Chat Diskusi</label>
                        <textarea id="body" name="body" rows="6" class="mt-3 block w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Tulis pertanyaan, keluhan, atau topik belajar...">{{ old('body') }}</textarea>
                    </div>

                    <button type="submit" class="flex w-full items-center justify-center rounded-lg bg-blue-600 px-5 py-3 text-base font-bold text-white transition hover:bg-blue-700">
                        Kirim Topik
                    </button>
                </form>
            </aside>
        </div>
    </div>
</div>

<script>
    (() => {
        const topicList = document.getElementById('discussion-topic-list');
        const topicCount = document.getElementById('discussion-topic-count');

        if (!topicList || !topicCount) {
            return;
        }

        let isRefreshing = false;

        const hasActiveDraft = () => {
            const activeElement = document.activeElement;

            if (activeElement && ['TEXTAREA', 'INPUT', 'SELECT'].includes(activeElement.tagName)) {
                return true;
            }

            return Array.from(topicList.querySelectorAll('textarea')).some((textarea) => textarea.value.trim() !== '');
        };

        const refreshDiscussion = async () => {
            if (isRefreshing || hasActiveDraft()) {
                return;
            }

            isRefreshing = true;

            try {
                const response = await fetch(topicList.dataset.liveUrl, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                if (!response.ok) {
                    return;
                }

                const data = await response.json();
                topicList.innerHTML = data.html;
                topicCount.textContent = `${data.topic_count} topik ditampilkan`;
            } catch (error) {
                console.error('Gagal memperbarui forum diskusi:', error);
            } finally {
                isRefreshing = false;
            }
        };

        window.setInterval(refreshDiscussion, 3000);
    })();
</script>
@endsection
