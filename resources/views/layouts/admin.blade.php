<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Brainy Admin')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @include('layouts.vite')
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased" style="font-family: Outfit, sans-serif">
@php
    $activeTab = $activeTab ?? '';
    $pendingPaymentCount = \App\Models\Payment::query()
        ->where('status', 'pending')
        ->whereNotNull('transaction_code')
        ->count();
    $waitingCount = \App\Models\WaitingList::query()->where('status', 'waiting')->count();
@endphp

<div class="min-h-screen lg:flex">
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full border-r border-slate-200 bg-white p-5 transition lg:static lg:translate-x-0">
        <div class="mb-8 flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo_brainy.png') }}" alt="Brainy" class="h-10 w-10 object-contain">
                <span class="text-lg font-extrabold text-slate-900">Brainy <span class="text-blue-600">Admin</span></span>
            </a>
            <button type="button" class="text-slate-500 lg:hidden" onclick="toggleSidebar(false)">✕</button>
        </div>

        <nav class="space-y-1 text-sm font-bold">
            @php
                $menus = [
                    ['dashboard', 'admin.dashboard', 'home', 'Dashboard', null],
                    ['courses', 'admin.courses.index', 'graduation-cap', 'Kelola Kursus', null],
                    ['payments', 'admin.payments.index', 'badge-dollar-sign', 'Pembayaran', $pendingPaymentCount],
                    ['waitinglist', 'admin.waitinglist', 'clipboard-list', 'Waiting List', $waitingCount],
                    ['tutors', 'admin.tutors.index', 'user-check', 'Kelola Tutor', null],
                    ['schedules', 'admin.schedules.index', 'calendar-days', 'Jadwal Kelas', null],
                    ['siswa', 'admin.students', 'users', 'Data Siswa & Trial', null],
                    ['quiz', 'admin.quiz.index', 'file-question', 'Quiz Mingguan', null],
                    ['diskusi', 'admin.diskusi.index', 'message-square', 'Forum Diskusi', null],
                ];
            @endphp

            @foreach ($menus as [$key, $routeName, $icon, $label, $count])
                <a href="{{ route($routeName) }}" class="flex items-center justify-between rounded-xl px-3 py-2.5 transition {{ $activeTab === $key ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <span class="flex items-center gap-3">
                        <i data-lucide="{{ $icon }}" class="h-5 w-5"></i>
                        {{ $label }}
                    </span>
                    @if ($count)
                        <span class="rounded-full bg-blue-600 px-2 py-0.5 text-xs text-white">{{ $count }}</span>
                    @endif
                </a>
            @endforeach
        </nav>
    </aside>

    <div id="sidebar-overlay" class="fixed inset-0 z-30 hidden bg-slate-900/40 lg:hidden" onclick="toggleSidebar(false)"></div>

    <div class="min-w-0 flex-1">
        <header class="border-b border-slate-200 bg-white px-5 py-4 sm:px-7">
            <div class="mx-auto flex max-w-[1500px] items-center justify-between gap-4">
                <div class="flex min-w-0 items-center gap-3">
                    <button type="button" onclick="toggleSidebar(true)" class="rounded-lg border border-slate-200 p-2 lg:hidden">
                        <i data-lucide="menu" class="h-5 w-5"></i>
                    </button>
                    <div>
                        <h1 class="truncate text-lg font-extrabold text-slate-900">@yield('page_title', 'Dashboard')</h1>
                        <p class="hidden text-xs text-slate-500 sm:block">@yield('page_description')</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="hidden text-sm font-bold text-slate-700 sm:inline">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="rounded-xl bg-slate-900 px-4 py-2 text-xs font-bold text-white hover:bg-slate-800">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-[1500px] space-y-6 p-5 sm:p-7">
            @if (session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-bold text-emerald-800">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="rounded-xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm font-bold text-rose-800">{{ $errors->first() }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</div>

<script>
    function toggleSidebar(open) {
        document.getElementById('sidebar').classList.toggle('-translate-x-full', !open);
        document.getElementById('sidebar-overlay').classList.toggle('hidden', !open);
    }
    document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
</script>
@yield('scripts')
</body>
</html>
