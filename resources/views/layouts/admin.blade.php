<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Brainy Admin')</title>
    <!-- Outfit Font from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @include('layouts.vite')
    
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif;
        }
        
        /* Keyframe animations matching the React dashboard */
        @keyframes slideIn {
            from { transform: translateY(1rem); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        @keyframes scaleIn {
            from { transform: scale(0.97); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .animate-slide-in {
            animation: slideIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .animate-scale-in {
            animation: scaleIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-800 antialiased min-h-screen">

    <!-- Admin Authentication State Sync -->
    <script>
        localStorage.setItem('brainy_admin_auth', 'true');

        // Initialize Global State in localStorage if not exists
        const DEFAULT_STUDENTS = [
            { id: 1, name: 'Ahmad Fauzi', email: 'ahmad@email.com', phone: '081234567890', course: 'English Intermediate', level: 'Intermediate', lang: 'English', joinedDate: '26 Mei 2026', status: 'Active', attendance: 95, progress: 85, paymentStatus: 'Paid', avatar: 'AF', color: 'bg-blue-50 text-blue-600 border border-blue-100/50' },
            { id: 2, name: 'Dewi Lestari', email: 'dewi@email.com', phone: '081234567891', course: 'Korean for Beginners', level: 'Beginner', lang: 'Korean', joinedDate: '26 Mei 2026', status: 'Active', attendance: 92, progress: 78, paymentStatus: 'Paid', avatar: 'DL', color: 'bg-orange-50 text-orange-600 border border-orange-100/50' },
            { id: 3, name: 'Farhan Malik', email: 'farhan@email.com', phone: '081234567892', course: 'Japanese Intermediate', level: 'Intermediate', lang: 'Japanese', joinedDate: '25 Mei 2026', status: 'Active', attendance: 88, progress: 65, paymentStatus: 'Paid', avatar: 'FM', color: 'bg-purple-50 text-purple-600 border border-purple-100/50' },
            { id: 4, name: 'Larasati Putri', email: 'laras@email.com', phone: '081234567893', course: 'English Advanced', level: 'Advanced', lang: 'English', joinedDate: '24 Mei 2026', status: 'Active', attendance: 100, progress: 92, paymentStatus: 'Paid', avatar: 'LP', color: 'bg-blue-50 text-blue-600 border border-blue-100/50' },
            { id: 5, name: 'Rizky Pratama', email: 'rizky@email.com', phone: '081234567894', course: 'Korean Intermediate', level: 'Intermediate', lang: 'Korean', joinedDate: '24 Mei 2026', status: 'Active', attendance: 85, progress: 70, paymentStatus: 'Paid', avatar: 'RP', color: 'bg-orange-50 text-orange-600 border border-orange-100/50' },
            { id: 6, name: 'Siti Nurhaliza', email: 'siti@email.com', phone: '081234567895', course: 'Japanese Beginner', level: 'Beginner', lang: 'Japanese', joinedDate: '21 Mei 2026', status: 'Active', attendance: 90, progress: 60, paymentStatus: 'Paid', avatar: 'SN', color: 'bg-purple-50 text-purple-600 border border-purple-100/50' },
            { id: 7, name: 'Budi Hartono', email: 'budi.h@email.com', phone: '081234567896', course: 'Korean Beginner', level: 'Beginner', lang: 'Korean', joinedDate: '20 Mei 2026', status: 'Inactive', attendance: 75, progress: 40, paymentStatus: 'Unpaid', avatar: 'BH', color: 'bg-orange-50 text-orange-600 border border-orange-100/50' },
            { id: 8, name: 'Dewi Putri', email: 'dewip@email.com', phone: '081234567897', course: 'English Beginner', level: 'Beginner', lang: 'English', joinedDate: '19 Mei 2026', status: 'Active', attendance: 96, progress: 88, paymentStatus: 'Paid', avatar: 'DP', color: 'bg-blue-50 text-blue-600 border border-blue-100/50' },
            { id: 9, name: 'Rahman Ali', email: 'rahman@email.com', phone: '081234567898', course: 'Japanese Intermediate', level: 'Intermediate', lang: 'Japanese', joinedDate: '18 Mei 2026', status: 'Suspended', attendance: 60, progress: 30, paymentStatus: 'Paid', avatar: 'RA', color: 'bg-purple-50 text-purple-600 border border-purple-100/50' }
        ];

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
                </a>

                <!-- Nav Item: Kelola Kursus -->
                <a href="/admin/courses" class="flex w-full items-center justify-between rounded-xl px-3 py-2.5 text-sm font-semibold transition-all duration-200 @if($activeTab === 'courses') bg-blue-50/80 text-blue-600 @else text-slate-600 hover:bg-slate-50 hover:text-slate-900 @endif">
                    <div class="flex items-center gap-3">
                        <i data-lucide="graduation-cap" class="h-5 w-5 @if($activeTab === 'courses') text-blue-600 @else text-slate-400 @endif"></i>
                        <span>Kelola Kursus</span>
                    </div>
                </a>

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
                    </button>
                    <div>
                        <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">
                            @yield('page_title', 'Dasbor Ringkasan')
                        </h1>
                        <p class="hidden sm:block text-xs text-slate-400 font-medium mt-0.5">
                            @yield('page_description', 'Pantau parameter operasional lembaga bahasa asing Brainy.')
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="hidden sm:relative max-w-xs">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i data-lucide="search" class="h-4 w-4"></i>
                        </span>
                        <input id="global-search-bar" type="text" placeholder="Cari data..." oninput="handleGlobalSearch(this.value)" class="h-9 w-60 rounded-xl border border-slate-200 bg-white pl-9 pr-4 text-xs font-medium outline-none transition focus:border-blue-500">
                    </div>

                    <a href="/" class="inline-flex h-9 items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 text-xs font-bold text-slate-700 shadow-sm transition hover:bg-slate-50 active:scale-[0.98]">
                        <i data-lucide="home" class="h-4 w-4"></i>
                        Home
                    </a>

                    <button onclick="handleLogout()" class="inline-flex h-9 items-center gap-2 rounded-xl bg-slate-900 px-4 text-xs font-bold text-white shadow-sm transition hover:bg-slate-800 active:scale-[0.98]">
                        <i data-lucide="log-out" class="h-4 w-4"></i>
                        Logout
                    </button>
                </div>
            </header>

            <main class="flex-1 p-6 space-y-6 max-w-[1600px] w-full mx-auto animate-scale-in">
                @yield('content')
            </main>

            <footer class="border-t border-slate-200/50 bg-white py-4 text-center text-[10px] text-slate-400 mt-10">
                &copy; 2026 Brainy Language Institute Portal Admin. Hak cipta dilindungi.
            </footer>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed bottom-0 right-0 z-50 p-6 flex flex-col gap-3 font-sans"></div>

    <!-- Global Layout Scripts -->
    <script>
        // Toggle Mobile Sidebar
        function toggleSidebar(open) {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if (open) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }

        // Global Search stub - can be overridden in page scripts
        function handleGlobalSearch(query) {
            if (window.onLocalSearch) {
                window.onLocalSearch(query);
            }
        }

        // Admin Logout
        function handleLogout() {
            localStorage.removeItem('brainy_admin_auth');
            showToast('Anda telah keluar dari sistem admin.', 'info');
            setTimeout(() => {
                window.location.href = '/logout';
            }, 600);
        }

        // Custom Toast System
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const id = Date.now();
            
            const toast = document.createElement('div');
            toast.id = `toast-${id}`;
            toast.className = 'flex items-center gap-3 rounded-xl bg-slate-900 px-5 py-4 text-white shadow-xl animate-slide-in border border-slate-800 max-w-sm transition duration-300';
            
            const isSuccess = type === 'success';
            const iconColor = isSuccess ? 'bg-emerald-500/10 text-emerald-400' : 'bg-blue-500/10 text-blue-400';
            const iconName = isSuccess ? 'check' : 'bell';
            
            toast.innerHTML = `
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full ${iconColor}">
                    <i data-lucide="${iconName}" class="h-5 w-5"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold">${isSuccess ? 'Berhasil' : 'Info'}</p>
                    <p class="text-xs text-slate-300 mt-0.5">${message}</p>
                </div>
                <button onclick="removeToast(${id})" class="text-slate-400 hover:text-white transition">
                    <i data-lucide="x" class="h-4 w-4"></i>
                </button>
            `;
            
            container.appendChild(toast);
            lucide.createIcons();

            // Auto dismiss after 4s
            setTimeout(() => {
                removeToast(id);
            }, 4000);
        }

        function removeToast(id) {
            const toast = document.getElementById(`toast-${id}`);
            if (toast) {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }
        }

        // Inform developer of unfinished features
        function showDevInfo(featureName) {
            showToast(`Halaman ${featureName} sedang dikembangkan.`, 'info');
        }

        // Sync Sidebar Badges
        function syncSidebarBadges() {
            try {
                const waitListCount = JSON.parse(localStorage.getItem('brainy_waiting_list') || '[]').length;
                const paymentsCount = JSON.parse(localStorage.getItem('brainy_pending_payments') || '[]').length;
                
                const badgeWaitList = document.getElementById('badge-waiting-list');
                const badgePayments = document.getElementById('badge-pembayaran');
                
                if (badgeWaitList) {
                    badgeWaitList.innerText = waitListCount;
                    if (waitListCount > 0) badgeWaitList.classList.remove('hidden');
                    else badgeWaitList.classList.add('hidden');
                }
                
                if (badgePayments) {
                    badgePayments.innerText = paymentsCount;
                    if (paymentsCount > 0) badgePayments.classList.remove('hidden');
                    else badgePayments.classList.add('hidden');
                }
            } catch (e) {
                console.error(e);
            }
        }

        // On DOM Loaded
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
            syncSidebarBadges();
        });
    </script>
    
    @yield('scripts')
</body>
</html>
