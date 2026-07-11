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

<<<<<<< HEAD
        const DEFAULT_TUTORS = [
            {
                id: 1,
                name: 'Sarah Johnson',
                desc: 'Native speaker dengan sertifikasi TESOL',
                email: 'sarah@brainy.com',
                exp: 8,
                students: 27,
                lang: 'English',
                flag: '🇬🇧',
                initials: 'SJ',
                avatarColor: 'bg-blue-50 text-blue-600 border-blue-100/50',
                classes: [
                    { name: 'English for Beginners', schedule: 'Senin & Rabu, 19:00 - 20:30' },
                    { name: 'English Intermediate', schedule: 'Selasa & Kamis, 19:00 - 20:30' }
                ]
            },
            {
                id: 2,
                name: 'Michael Brown',
                desc: 'Spesialis Business English dan IELTS',
                email: 'michael@brainy.com',
                exp: 6,
                students: 8,
                lang: 'English',
                flag: '🇬🇧',
                initials: 'MB',
                avatarColor: 'bg-blue-50 text-blue-600 border-blue-100/50',
                classes: [
                    { name: 'English Advanced', schedule: 'Rabu & Jumat, 19:00 - 20:30' }
                ]
            },
            {
                id: 3,
                name: 'Yuki Tanaka',
                desc: 'Native speaker Japan dengan sertifikasi JLPT N1',
                email: 'yuki@brainy.com',
                exp: 10,
                students: 17,
                lang: 'Japanese',
                flag: '🇯🇵',
                initials: 'YT',
                avatarColor: 'bg-purple-50 text-purple-600 border-purple-100/50',
                classes: [
                    { name: 'Japanese for Beginners', schedule: 'Senin & Rabu, 18:00 - 19:30' },
                    { name: 'Japanese Intermediate', schedule: 'Selasa & Kamis, 18:00 - 19:30' }
                ]
            },
            {
                id: 4,
                name: 'Min-Ji Park',
                desc: 'Native speaker Korea dengan pengalaman mengajar internasional',
                email: 'minji@brainy.com',
                exp: 7,
                students: 23,
                lang: 'Korean',
                flag: '🇰🇷',
                initials: 'MP',
                avatarColor: 'bg-orange-50 text-orange-600 border-orange-100/50',
                classes: [
                    { name: 'Korean for Beginners', schedule: 'Senin & Kamis, 19:00 - 20:30' },
                    { name: 'Korean Intermediate', schedule: 'Selasa & Jumat, 19:00 - 20:30' }
                ]
            }
        ];

        const DEFAULT_WAITING_LIST = [
            { id: 1, name: 'Ahmad Fauzi', email: 'ahmad@email.com', phone: '081234567890', course: 'English Intermediate', rawLanguage: 'English', date: '26 Mei 2026', avatar: 'AF', color: 'bg-blue-50 text-blue-600 border border-blue-100/50' },
            { id: 2, name: 'Dewi Lestari', email: 'dewi@email.com', phone: '081234567891', course: 'Korean for Beginners', rawLanguage: 'Korean', date: '26 Mei 2026', avatar: 'DL', color: 'bg-orange-50 text-orange-600 border border-orange-100/50' },
            { id: 3, name: 'Farhan Malik', email: 'farhan@email.com', phone: '081234567892', course: 'Japanese Intermediate', rawLanguage: 'Japanese', date: '25 Mei 2026', avatar: 'FM', color: 'bg-purple-50 text-purple-600 border border-purple-100/50' },
            { id: 4, name: 'Larasati Putri', email: 'laras@email.com', phone: '081234567893', course: 'English Advanced', rawLanguage: 'English', date: '24 Mei 2026', avatar: 'LP', color: 'bg-blue-50 text-blue-600 border border-blue-100/50' },
            { id: 5, name: 'Rizky Pratama', email: 'rizky@email.com', phone: '081234567894', course: 'Korean Intermediate', rawLanguage: 'Korean', date: '24 Mei 2026', avatar: 'RP', color: 'bg-orange-50 text-orange-600 border border-orange-100/50' }
        ];

        const DEFAULT_PENDING_PAYMENTS = [
            { id: 101, name: 'Budi Santoso', course: 'Japanese Intermediate', amount: 'Rp 2.300.000', rawAmount: 2300000 },
            { id: 102, name: 'Lisa Wijaya', course: 'English Intermediate', amount: 'Rp 1.800.000', rawAmount: 1800000 },
            { id: 103, name: 'Agus Susanto', course: 'Korean Beginner', amount: 'Rp 2.000.000', rawAmount: 2000000 }
        ];

        const DEFAULT_RECENT_STUDENTS = [
            { id: 1, name: 'Ahmad Fauzi', course: 'English Beginner', date: '22 Mei 2026', avatar: 'AF', color: 'bg-blue-50 text-blue-600 border border-blue-100/50' },
            { id: 2, name: 'Siti Nurhaliza', course: 'Japanese Intermediate', date: '21 Mei 2026', avatar: 'SN', color: 'bg-indigo-50 text-indigo-600 border border-indigo-100/50' },
            { id: 3, name: 'Budi Hartono', course: 'Korean Beginner', date: '20 Mei 2026', avatar: 'BH', color: 'bg-orange-50 text-orange-600 border border-orange-100/50' },
            { id: 4, name: 'Dewi Putri', course: 'English Advanced', date: '19 Mei 2026', avatar: 'DP', color: 'bg-emerald-50 text-emerald-600 border border-emerald-100/50' },
            { id: 5, name: 'Rahman Ali', course: 'Japanese Beginner', date: '18 Mei 2026', avatar: 'RA', color: 'bg-blue-50 text-blue-600 border border-blue-100/50' }
        ];

        if (!localStorage.getItem('brainy_students')) {
            localStorage.setItem('brainy_students', JSON.stringify(DEFAULT_STUDENTS));
        }
        if (!localStorage.getItem('brainy_tutors')) {
            localStorage.setItem('brainy_tutors', JSON.stringify(DEFAULT_TUTORS));
        }
        if (!localStorage.getItem('brainy_waiting_list')) {
            localStorage.setItem('brainy_waiting_list', JSON.stringify(DEFAULT_WAITING_LIST));
        }
        if (!localStorage.getItem('brainy_pending_payments')) {
            localStorage.setItem('brainy_pending_payments', JSON.stringify(DEFAULT_PENDING_PAYMENTS));
        }
        if (!localStorage.getItem('brainy_recent_students')) {
            localStorage.setItem('brainy_recent_students', JSON.stringify(DEFAULT_RECENT_STUDENTS));
        }
        if (!localStorage.getItem('brainy_total_siswa')) {
            localStorage.setItem('brainy_total_siswa', '248');
        }
        if (!localStorage.getItem('brainy_pendapatan')) {
            localStorage.setItem('brainy_pendapatan', '45200000');
        }
    </script>

    <div class="min-h-screen bg-[#F8FAFC] flex text-slate-800 font-sans w-full">
        
        <!-- Sidebar Navigation -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 flex h-screen w-64 flex-col overflow-hidden border-r border-slate-200/80 bg-white px-5 py-6 transition-transform -translate-x-full lg:translate-x-0">
            <div class="mb-8 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-600 text-white shadow-md shadow-blue-500/10">
                        <i data-lucide="book-open" class="h-5 w-5 animate-pulse" stroke-width="2.2"></i>
                    </div>
                    <span class="text-lg font-bold tracking-tight text-slate-900">Brainy <span class="text-blue-600">Admin</span></span>
                </div>
                <button onclick="toggleSidebar(false)" class="lg:hidden text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="h-5 w-5"></i>
                </button>
            </div>

            <nav class="flex-1 space-y-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 px-3 block mb-2">Menu Utama</span>
                
                <!-- Nav Item: Dashboard -->
                <a href="/admin/dashboard" class="flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-semibold transition-all duration-200 @if($activeTab === 'dashboard') bg-blue-50/80 text-blue-600 @else text-slate-600 hover:bg-slate-50 hover:text-slate-900 @endif">
                    <div class="flex items-center gap-3">
                        <i data-lucide="home" class="h-5 w-5 @if($activeTab === 'dashboard') text-blue-600 @else text-slate-400 @endif"></i>
                        <span>Dashboard</span>
                    </div>
=======
            @foreach ($menus as [$key, $routeName, $icon, $label, $count])
                <a href="{{ route($routeName) }}" class="flex items-center justify-between rounded-xl px-3 py-2.5 transition {{ $activeTab === $key ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <span class="flex items-center gap-3">
                        <i data-lucide="{{ $icon }}" class="h-5 w-5"></i>
                        {{ $label }}
                    </span>
                    @if ($count)
                        <span class="rounded-full bg-blue-600 px-2 py-0.5 text-xs text-white">{{ $count }}</span>
                    @endif
>>>>>>> 08f0257880bc6a1a2b4ae192c295e716b2e4c819
                </a>
            @endforeach
        </nav>
    </aside>

    <div id="sidebar-overlay" class="fixed inset-0 z-30 hidden bg-slate-900/40 lg:hidden" onclick="toggleSidebar(false)"></div>

<<<<<<< HEAD
                <!-- Nav Item: Pembayaran -->
                <a href="/admin/payments" class="flex w-full items-center justify-between rounded-xl px-3 py-2.5 text-sm font-semibold transition-all duration-200 @if($activeTab === 'payments') bg-blue-50/80 text-blue-600 @else text-slate-600 hover:bg-slate-50 hover:text-slate-900 @endif">
                    <div class="flex items-center gap-3">
                        <i data-lucide="dollar-sign" class="h-5 w-5 @if($activeTab === 'payments') text-blue-600 @else text-slate-400 @endif"></i>
                        <span>Pembayaran</span>
                    </div>
                    <span id="badge-pembayaran" class="rounded-full px-2 py-0.5 text-xs font-bold bg-slate-100 text-slate-600 hidden">0</span>
                </a>

                <!-- Nav Item: Waiting List -->
                <a href="/admin/waitinglist" class="flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-semibold transition-all duration-200 @if($activeTab === 'waitinglist') bg-blue-50/80 text-blue-600 @else text-slate-600 hover:bg-slate-50 hover:text-slate-900 @endif">
                    <div class="flex items-center gap-3">
                        <i data-lucide="clipboard-list" class="h-5 w-5 @if($activeTab === 'waitinglist') text-blue-600 @else text-slate-400 @endif"></i>
                        <span>Waiting List</span>
                    </div>
                    <span id="badge-waiting-list" class="rounded-full px-2 py-0.5 text-xs font-bold @if($activeTab === 'waitinglist') bg-blue-600 text-white @else bg-slate-100 text-slate-600 @endif hidden">0</span>
                </a>

                <!-- Nav Item: Kelola Tutor -->
                <a href="/admin/tutors" class="flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-semibold transition-all duration-200 @if($activeTab === 'tutors') bg-blue-50/80 text-blue-600 @else text-slate-600 hover:bg-slate-50 hover:text-slate-900 @endif">
                    <div class="flex items-center gap-3">
                        <i data-lucide="user-check" class="h-5 w-5 @if($activeTab === 'tutors') text-blue-600 @else text-slate-400 @endif"></i>
                        <span>Kelola Tutor</span>
                    </div>
                </a>

                <!-- Nav Item: Jadwal Kelas -->
                <a href="/admin/schedules" class="flex w-full items-center justify-between rounded-xl px-3 py-2.5 text-sm font-semibold transition-all duration-200 @if($activeTab === 'schedules') bg-blue-50/80 text-blue-600 @else text-slate-600 hover:bg-slate-50 hover:text-slate-900 @endif">
                    <div class="flex items-center gap-3">
                        <i data-lucide="calendar-days" class="h-5 w-5 @if($activeTab === 'schedules') text-blue-600 @else text-slate-400 @endif"></i>
                        <span>Jadwal Kelas</span>
                    </div>
                </a>

                <!-- Nav Item: Data Siswa -->
                <a href="/admin/students" class="flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-semibold transition-all duration-200 @if($activeTab === 'siswa') bg-blue-50/80 text-blue-600 @else text-slate-600 hover:bg-slate-50 hover:text-slate-900 @endif">
                    <div class="flex items-center gap-3">
                        <i data-lucide="users" class="h-5 w-5 @if($activeTab === 'siswa') text-blue-600 @else text-slate-400 @endif"></i>
                        <span>Data Siswa</span>
                    </div>
                </a>

                <!-- Nav Item: Quiz Mingguan -->
                <a href="/admin/quiz" class="flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-semibold transition-all duration-200 @if($activeTab === 'quiz') bg-blue-50/80 text-blue-600 @else text-slate-600 hover:bg-slate-50 hover:text-slate-900 @endif">
                    <div class="flex items-center gap-3">
                        <i data-lucide="file-question" class="h-5 w-5 @if($activeTab === 'quiz') text-blue-600 @else text-slate-400 @endif"></i>
                        <span>Quiz Mingguan</span>
                    </div>
                </a>

                <!-- Nav Item: Forum Diskusi -->
                <a href="/admin/diskusi" class="flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-semibold transition-all duration-200 @if($activeTab === 'diskusi') bg-blue-50/80 text-blue-600 @else text-slate-600 hover:bg-slate-50 hover:text-slate-900 @endif">
                    <div class="flex items-center gap-3">
                        <i data-lucide="message-square" class="h-5 w-5 @if($activeTab === 'diskusi') text-blue-600 @else text-slate-400 @endif"></i>
                        <span>Forum Diskusi</span>
                    </div>
                </a>
            </nav>

            <div class="mt-5 border-t border-slate-100 pt-5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white font-bold text-sm shadow-sm shadow-blue-500/10">
                        AD
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-bold text-slate-900 truncate">Administrator</p>
                        <p class="text-xs text-slate-400 truncate">admin@brainy.com</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Mobile Sidebar Overlay -->
        <div id="sidebar-overlay" onclick="toggleSidebar(false)" class="fixed inset-0 z-30 bg-slate-900/25 backdrop-blur-sm lg:hidden hidden"></div>

        <!-- Main Area -->
        <div class="flex min-w-0 flex-1 flex-col lg:pl-64">
            <!-- Top Header -->
            <header class="sticky top-0 z-20 border-b border-slate-200/60 bg-[#F8FAFC]/95 backdrop-blur-md px-6 py-4 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <button onclick="toggleSidebar(true)" class="lg:hidden p-2 -ml-2 rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-950">
                        <i data-lucide="menu" class="h-6 w-6"></i>
=======
    <div class="min-w-0 flex-1">
        <header class="border-b border-slate-200 bg-white px-5 py-4 sm:px-7">
            <div class="mx-auto flex max-w-[1500px] items-center justify-between gap-4">
                <div class="flex min-w-0 items-center gap-3">
                    <button type="button" onclick="toggleSidebar(true)" class="rounded-lg border border-slate-200 p-2 lg:hidden">
                        <i data-lucide="menu" class="h-5 w-5"></i>
>>>>>>> 08f0257880bc6a1a2b4ae192c295e716b2e4c819
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
