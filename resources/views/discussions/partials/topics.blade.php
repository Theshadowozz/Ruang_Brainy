@forelse($topics as $topic)
    @php
        $authorRole = match ($topic->user->role) {
            \App\Models\User::ROLE_ADMIN => 'Admin',
            \App\Models\User::ROLE_TUTOR => 'Tutor',
            default => 'Siswa',
        };
    @endphp
    <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h3 class="text-lg font-extrabold text-gray-950">{{ $topic->title }}</h3>
                <p class="mt-1 text-xs font-semibold text-gray-500">
                    {{ $topic->user->name }} - {{ $authorRole }} - {{ $topic->created_at->diffForHumans() }}
                </p>
            </div>
            <span class="w-max rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">
                {{ $topic->messages_count }} chat
            </span>
        </div>

        <div class="mt-5 space-y-3">
            @foreach($topic->messages as $message)
                @php
                    $messageRole = match ($message->user->role) {
                        \App\Models\User::ROLE_ADMIN => 'Admin',
                        \App\Models\User::ROLE_TUTOR => 'Tutor',
                        default => 'Siswa',
                    };
                @endphp
                <div class="rounded-lg border border-gray-100 bg-gray-50 px-4 py-3">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <p class="text-sm font-bold text-gray-950">{{ $message->user->name }}</p>
                        <p class="text-xs font-semibold text-gray-500">{{ $messageRole }} - {{ $message->created_at->diffForHumans() }}</p>
                    </div>
                    <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-gray-700">{{ $message->body }}</p>
                </div>
            @endforeach
        </div>

        <form method="POST" action="{{ route($rolePrefix . '.diskusi.messages.store', $topic) }}" class="mt-4 flex flex-col gap-3 sm:flex-row">
            @csrf
            <textarea name="body" rows="2" class="min-h-12 flex-1 rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Tulis balasan..."></textarea>
            <button type="submit" class="rounded-lg bg-gray-950 px-5 py-3 text-sm font-bold text-white transition hover:bg-gray-800">
                Balas
            </button>
        </form>
    </article>
@empty
    <div class="rounded-lg border border-dashed border-gray-300 bg-gray-50 px-6 py-14 text-center">
        <h3 class="text-xl font-extrabold text-gray-950">Belum ada diskusi {{ strtolower($activeLabel) }}</h3>
        <p class="mt-4 text-gray-600">Buat topik pada kategori ini agar semua role bisa langsung melihat dan membalas.</p>
    </div>
@endforelse
