@php
    use App\Models\User;

    $forumCategories = $forumCategories ?? [];
    $forumTopics = $forumTopics ?? collect();

    $categoryStyles = [
        'brainy' => 'border-blue-200 bg-blue-50 text-blue-700',
        'keluhan' => 'border-rose-200 bg-rose-50 text-rose-700',
        'pembelajaran' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
    ];

    $categoryTabStyles = [
        'brainy' => 'border-blue-200 bg-blue-50 text-blue-700',
        'keluhan' => 'border-rose-200 bg-rose-50 text-rose-700',
        'pembelajaran' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
    ];

    $defaultForumCategory = array_key_first($forumCategories) ?? 'pembelajaran';
    $activeForumCategory = request('forum_category', old('category', $defaultForumCategory));

    if (! array_key_exists($activeForumCategory, $forumCategories)) {
        $activeForumCategory = $defaultForumCategory;
    }

    $visibleForumTopics = $forumTopics
        ->where('category', $activeForumCategory)
        ->values();

    $categoryCounts = collect($forumCategories)
        ->mapWithKeys(fn ($label, $value) => [$value => $forumTopics->where('category', $value)->count()]);

    $roleLabel = function ($role) {
        return match ((int) $role) {
            User::ROLE_ADMIN => 'Admin',
            User::ROLE_TUTOR => 'Tutor',
            default => 'Siswa',
        };
    };

    $initials = function ($name) {
        return collect(explode(' ', (string) $name))
            ->filter()
            ->take(2)
            ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
            ->implode('') ?: 'BR';
    };
@endphp

<section id="forum-diskusi" class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="rounded-lg border border-gray-200 bg-white">
        <div class="flex flex-col gap-5 border-b border-gray-200 bg-blue-700 px-5 py-6 text-white sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg border border-white/40 text-white">
                    <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M4 5.5C4 4.67 4.67 4 5.5 4H18.5C19.33 4 20 4.67 20 5.5V14.5C20 15.33 19.33 16 18.5 16H9L4 20V5.5Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <div>
                    <h2 class="text-2xl font-bold">Forum Diskusi</h2>
                    <p class="mt-1 text-sm text-white/90">Pilih kategori untuk melihat chat forum yang sesuai.</p>
                </div>
            </div>
            <a href="#topik-baru" class="inline-flex h-10 items-center justify-center rounded-md bg-white px-4 text-sm font-semibold text-blue-700 transition hover:bg-blue-50">
                Topik Baru
            </a>
        </div>

        <div class="grid gap-6 p-5 lg:grid-cols-[minmax(0,1fr)_360px]">
            <div class="space-y-4">
                @if (session('forum_success'))
                    <div class="rounded-md border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-semibold text-blue-700">
                        {{ session('forum_success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="rounded-lg border border-gray-200 bg-gray-50 p-3">
                    <div class="grid gap-2 sm:grid-cols-3" aria-label="Kategori forum diskusi">
                        @foreach ($forumCategories as $value => $label)
                            @php
                                $isActiveCategory = $activeForumCategory === $value;
                                $activeClass = $categoryTabStyles[$value] ?? 'border-gray-200 bg-white text-gray-700';
                            @endphp
                            <a
                                href="{{ request()->fullUrlWithQuery(['forum_category' => $value]) }}#forum-diskusi"
                                class="flex min-h-14 items-center justify-between rounded-md border px-4 py-3 text-sm font-bold transition {{ $isActiveCategory ? $activeClass : 'border-transparent bg-white text-gray-600 hover:border-gray-200 hover:text-gray-950' }}"
                                @if ($isActiveCategory) aria-current="page" @endif
                            >
                                <span>{{ $label }}</span>
                                <span class="rounded-full bg-white px-2 py-0.5 text-xs text-gray-600">{{ $categoryCounts[$value] ?? 0 }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500">Kategori aktif</p>
                        <h3 class="text-xl font-bold">{{ $forumCategories[$activeForumCategory] ?? 'Forum Diskusi' }}</h3>
                    </div>
                    <p class="text-sm text-gray-600">{{ $visibleForumTopics->count() }} topik ditampilkan</p>
                </div>

                @forelse ($visibleForumTopics as $topic)
                    @php
                        $author = $topic->user;
                        $authorName = $author->name ?? 'Pengguna Brainy';
                        $categoryClass = $categoryStyles[$topic->category] ?? 'border-gray-200 bg-gray-50 text-gray-700';
                    @endphp
                    <article class="rounded-lg border border-gray-200 bg-white p-5">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-blue-50 text-sm font-bold text-blue-600">
                                {{ $initials($authorName) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="rounded-full border px-3 py-1 text-xs font-semibold {{ $categoryClass }}">
                                        {{ $forumCategories[$topic->category] ?? ucfirst($topic->category) }}
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $topic->created_at?->diffForHumans() }}</span>
                                </div>
                                <h3 class="mt-3 text-lg font-bold">{{ $topic->title }}</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    {{ $authorName }} - {{ $roleLabel($author->role ?? User::ROLE_SISWA) }} - {{ $topic->replies_count }} balasan
                                </p>
                                <p class="mt-4 text-sm leading-6 text-gray-800">{{ $topic->body }}</p>

                                <div class="mt-5 space-y-3 border-t border-gray-100 pt-4">
                                    @foreach ($topic->replies->take(3) as $reply)
                                        @php
                                            $replyUser = $reply->user;
                                            $replyName = $replyUser->name ?? 'Pengguna Brainy';
                                        @endphp
                                        <div class="flex gap-3 rounded-md bg-gray-50 p-3">
                                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white text-xs font-bold text-blue-600">
                                                {{ $initials($replyName) }}
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-xs font-bold text-gray-950">
                                                    {{ $replyName }}
                                                    <span class="ml-1 font-semibold text-gray-500">{{ $roleLabel($replyUser->role ?? User::ROLE_SISWA) }} - {{ $reply->created_at?->diffForHumans() }}</span>
                                                </p>
                                                <p class="mt-1 text-sm leading-6 text-gray-700">{{ $reply->body }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <form action="{{ route('forum.replies.store', $topic) }}" method="POST" class="mt-4">
                                    @csrf
                                    <label for="reply-{{ $topic->id }}" class="text-sm font-semibold text-gray-950">Balas Diskusi</label>
                                    <textarea id="reply-{{ $topic->id }}" name="body" rows="2" required maxlength="1500" placeholder="Tulis balasan Anda..." class="mt-2 w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-sm outline-none transition focus:border-blue-500 focus:bg-white"></textarea>
                                    <button type="submit" class="mt-2 inline-flex h-9 items-center rounded-md bg-gray-950 px-4 text-sm font-semibold text-white transition hover:bg-blue-700">Kirim Balasan</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-lg border border-dashed border-gray-300 bg-gray-50 px-5 py-10 text-center">
                        <h3 class="text-lg font-bold text-gray-950">Belum ada diskusi {{ strtolower($forumCategories[$activeForumCategory] ?? '') }}</h3>
                        <p class="mt-2 text-sm text-gray-600">Buat topik pada kategori ini agar semua role bisa langsung melihat dan membalas.</p>
                    </div>
                @endforelse
            </div>

            <aside id="topik-baru" class="h-fit rounded-lg border border-gray-200 bg-gray-50 p-5">
                <h3 class="text-lg font-bold">Buat Topik Diskusi</h3>
                <p class="mt-1 text-sm text-gray-600">Topik akan muncul di tab kategori yang dipilih.</p>

                <form action="{{ route('forum.topics.store') }}" method="POST" class="mt-5 space-y-4">
                    @csrf
                    <div>
                        <label for="forum-category" class="text-sm font-semibold text-gray-950">Kategori</label>
                        <select id="forum-category" name="category" required class="mt-2 h-11 w-full rounded-md border border-gray-200 bg-white px-3 text-sm outline-none transition focus:border-blue-500">
                            @foreach ($forumCategories as $value => $label)
                                <option value="{{ $value }}" @selected(old('category', $activeForumCategory) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="forum-title" class="text-sm font-semibold text-gray-950">Judul</label>
                        <input id="forum-title" name="title" value="{{ old('title') }}" required maxlength="120" placeholder="Contoh: Tips meningkatkan speaking" class="mt-2 h-11 w-full rounded-md border border-gray-200 bg-white px-3 text-sm outline-none transition focus:border-blue-500">
                    </div>

                    <div>
                        <label for="forum-body" class="text-sm font-semibold text-gray-950">Chat Diskusi</label>
                        <textarea id="forum-body" name="body" rows="5" required maxlength="2000" placeholder="Tulis pertanyaan, keluhan, atau topik belajar..." class="mt-2 w-full rounded-md border border-gray-200 bg-white px-3 py-2 text-sm outline-none transition focus:border-blue-500"></textarea>
                    </div>

                    <button type="submit" class="inline-flex h-10 w-full items-center justify-center rounded-md bg-blue-600 px-4 text-sm font-semibold text-white transition hover:bg-blue-700">Kirim Topik</button>
                </form>
            </aside>
        </div>
    </div>
</section>
