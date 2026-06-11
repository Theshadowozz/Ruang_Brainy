@extends('layouts.admin')

@section('title', 'Brainy Admin - Data Siswa')
@section('page_title', 'Data Siswa (Students)')
@section('page_description', 'Kelola data pribadi, status akademis, dan perkembangan kursus siswa.')

@php
    $activeTab = 'siswa';
@endphp

@section('content')
    <!-- Minimal Metrics Row -->
    <section class="grid gap-5 grid-cols-1 sm:grid-cols-3">
        <article class="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm flex items-center gap-4">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 border border-blue-100/30">
                <i data-lucide="users" class="h-6 w-6"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Siswa Aktif</p>
                <p id="metric-active-siswa" class="text-xl font-extrabold text-slate-900 mt-0.5">- / -</p>
            </div>
        </article>

        <article class="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm flex items-center gap-4">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100/30">
                <i data-lucide="clock" class="h-6 w-6"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Rata-rata Kehadiran</p>
                <p id="metric-avg-attendance" class="text-xl font-extrabold text-slate-900 mt-0.5">-%</p>
            </div>
        </article>

        <article class="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm flex items-center gap-4">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600 border border-violet-100/30">
                <i data-lucide="trending-up" class="h-6 w-6"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Rata-rata Progress</p>
                <p id="metric-avg-progress" class="text-xl font-extrabold text-slate-900 mt-0.5">-%</p>
            </div>
        </article>
    </section>

    <!-- Split View Panel -->
    <section class="grid gap-6 lg:grid-cols-12 items-start">
        
        <!-- Left Panel: Master list (Directory) -->
        <div class="lg:col-span-5 bg-white border border-slate-200/60 rounded-2xl shadow-sm overflow-hidden flex flex-col h-[680px]">
            <!-- Panel Header -->
            <div class="p-4 border-b border-slate-100 flex flex-col gap-3 shrink-0">
                <div class="flex items-center justify-between gap-3">
                    <h2 class="text-sm font-bold text-slate-900">Daftar Siswa</h2>
                    <button
                        onclick="openAddModal()"
                        class="inline-flex h-8 items-center gap-1.5 rounded-lg bg-blue-600 px-3 text-xs font-bold text-white shadow-sm hover:bg-blue-700 active:scale-[0.98] transition cursor-pointer"
                    >
                        <i data-lucide="plus" class="h-3.5 w-3.5"></i>
                        Registrasi Siswa
                    </button>
                </div>

                <!-- Search Input -->
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i data-lucide="search" class="h-4 w-4"></i>
                    </span>
                    <input
                        id="search-input"
                        type="text"
                        oninput="handleSearch(this.value)"
                        placeholder="Cari nama, email, kelas..."
                        class="h-9 w-full rounded-xl border border-slate-200 pl-9 pr-4 text-xs font-medium outline-none transition focus:border-blue-500 bg-slate-50/50 focus:bg-white"
                    />
                </div>

                <!-- Filters Pills -->
                <div class="space-y-1.5 pt-1">
                    <!-- Language Filter -->
                    <div class="flex flex-wrap gap-1">
                        <button onclick="setFilterLang('All')" id="btn-filter-lang-All" class="px-2.5 py-1 rounded-md text-[10px] font-bold transition-all bg-blue-50 text-blue-600 border border-blue-100/30 cursor-pointer">All</button>
                        <button onclick="setFilterLang('English')" id="btn-filter-lang-English" class="px-2.5 py-1 rounded-md text-[10px] font-bold transition-all text-slate-500 hover:text-slate-900 hover:bg-slate-50 cursor-pointer">English</button>
                        <button onclick="setFilterLang('Japanese')" id="btn-filter-lang-Japanese" class="px-2.5 py-1 rounded-md text-[10px] font-bold transition-all text-slate-500 hover:text-slate-900 hover:bg-slate-50 cursor-pointer">Japanese</button>
                        <button onclick="setFilterLang('Korean')" id="btn-filter-lang-Korean" class="px-2.5 py-1 rounded-md text-[10px] font-bold transition-all text-slate-500 hover:text-slate-900 hover:bg-slate-50 cursor-pointer">Korean</button>
                    </div>
                    <!-- Status Filter -->
                    <div class="flex flex-wrap gap-1">
                        <button onclick="setFilterStatus('All')" id="btn-filter-status-All" class="px-2.5 py-1 rounded-md text-[10px] font-bold transition-all bg-slate-800 text-white cursor-pointer">All</button>
                        <button onclick="setFilterStatus('Active')" id="btn-filter-status-Active" class="px-2.5 py-1 rounded-md text-[10px] font-bold transition-all text-slate-500 hover:text-slate-900 hover:bg-slate-50 cursor-pointer">Active</button>
                        <button onclick="setFilterStatus('Inactive')" id="btn-filter-status-Inactive" class="px-2.5 py-1 rounded-md text-[10px] font-bold transition-all text-slate-500 hover:text-slate-900 hover:bg-slate-50 cursor-pointer">Inactive</button>
                        <button onclick="setFilterStatus('Suspended')" id="btn-filter-status-Suspended" class="px-2.5 py-1 rounded-md text-[10px] font-bold transition-all text-slate-500 hover:text-slate-900 hover:bg-slate-50 cursor-pointer">Suspended</button>
                    </div>
                </div>
            </div>

            <!-- Master List Scroll Area -->
            <div id="students-master-list" class="flex-1 overflow-y-auto divide-y divide-slate-100">
                <!-- Loaded dynamically via JS -->
            </div>
        </div>

        <!-- Right Panel: Detail Inspector -->
        <div id="students-detail-inspector" class="lg:col-span-7 bg-white border border-slate-200/60 rounded-2xl shadow-sm p-6 h-[680px] flex flex-col justify-between">
            <!-- Loaded dynamically via JS based on selection -->
        </div>
    </section>

    <!-- Custom Add / Edit Student Form Modal -->
    <div id="student-modal" class="fixed inset-0 z-50 flex items-center justify-center px-4 hidden">
        <div onclick="closeStudentModal()" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"></div>
        
        <div class="relative bg-white rounded-2xl border border-slate-200/80 shadow-2xl max-w-md w-full p-6 animate-scale-in z-10 flex flex-col gap-4">
            <div class="flex justify-between items-start">
                <div>
                    <h3 id="student-modal-title" class="text-base font-extrabold text-slate-900">Registrasi Siswa Baru</h3>
                    <p id="student-modal-desc" class="text-xs text-slate-400 font-medium mt-1">Isi formulir secara lengkap untuk mendaftarkan siswa baru.</p>
                </div>
                <button onclick="closeStudentModal()" class="h-8 w-8 rounded-lg flex items-center justify-center text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition">
                    <i data-lucide="x" class="h-5 w-5"></i>
                </button>
            </div>

            <form onsubmit="handleStudentFormSubmit(event)" class="space-y-3.5">
                <input type="hidden" id="student-id-input">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap</label>
                    <input
                        type="text"
                        id="student-name-input"
                        placeholder="Contoh: Ahmad Fauzi"
                        class="h-10 w-full rounded-xl border border-slate-200 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 bg-slate-50/30 focus:bg-white"
                        required
                    />
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Email</label>
                        <input
                            type="email"
                            id="student-email-input"
                            placeholder="ahmad@email.com"
                            class="h-10 w-full rounded-xl border border-slate-200 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 bg-slate-50/30 focus:bg-white"
                            required
                        />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">No. Handphone</label>
                        <input
                            type="tel"
                            id="student-phone-input"
                            placeholder="081234567890"
                            class="h-10 w-full rounded-xl border border-slate-200 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 bg-slate-50/30 focus:bg-white"
                            required
                        />
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Bahasa</label>
                        <select
                            id="student-lang-select"
                            class="h-10 w-full rounded-xl border border-slate-200 px-2.5 text-xs font-medium outline-none transition focus:border-blue-500 bg-white"
                        >
                            <option value="English">English</option>
                            <option value="Japanese">Japanese</option>
                            <option value="Korean">Korean</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tingkatan</label>
                        <select
                            id="student-level-select"
                            class="h-10 w-full rounded-xl border border-slate-200 px-2.5 text-xs font-medium outline-none transition focus:border-blue-500 bg-white"
                        >
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Biaya</label>
                        <select
                            id="student-payment-select"
                            class="h-10 w-full rounded-xl border border-slate-200 px-2.5 text-xs font-medium outline-none transition focus:border-blue-500 bg-white"
                        >
                            <option value="Paid">Lunas (Paid)</option>
                            <option value="Unpaid">Belum Lunas</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Kursus / Kelas</label>
                    <input
                        type="text"
                        id="student-course-input"
                        placeholder="Contoh: English Intermediate Class"
                        class="h-10 w-full rounded-xl border border-slate-200 px-3.5 text-xs font-medium outline-none transition focus:border-blue-500 bg-slate-50/30 focus:bg-white"
                        required
                    />
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-700 mb-1">Status Rute</label>
                        <select
                            id="student-status-select"
                            class="h-10 w-full rounded-xl border border-slate-200 px-2 text-xs font-medium outline-none transition focus:border-blue-500 bg-white"
                        >
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Suspended">Suspended</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-700 mb-1">Absensi (%)</label>
                        <input
                            type="number"
                            min="0"
                            max="100"
                            id="student-attendance-input"
                            class="h-10 w-full rounded-xl border border-slate-200 px-2.5 text-xs font-medium outline-none transition focus:border-blue-500 bg-slate-50/30 focus:bg-white"
                            required
                        />
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-700 mb-1">Progress (%)</label>
                        <input
                            type="number"
                            min="0"
                            max="100"
                            id="student-progress-input"
                            class="h-10 w-full rounded-xl border border-slate-200 px-2.5 text-xs font-medium outline-none transition focus:border-blue-500 bg-slate-50/30 focus:bg-white"
                            required
                        />
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                    <button
                        type="button"
                        onclick="closeStudentModal()"
                        class="h-9 rounded-xl border border-slate-200 bg-white px-4 text-xs font-bold text-slate-600 hover:bg-slate-50 transition cursor-pointer"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="h-9 rounded-xl bg-blue-600 px-5 text-xs font-bold text-white hover:bg-blue-700 shadow-sm shadow-blue-500/10 transition cursor-pointer"
                    >
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let currentFilterLang = 'All';
        let currentFilterStatus = 'All';
        let currentSearchQuery = '';
        let selectedStudentId = null;

        function loadStudentsData() {
            const students = JSON.parse(localStorage.getItem('brainy_students') || '[]');
            
            // Calculate stats
            const activeCount = students.filter(s => s.status === 'Active').length;
            const avgAttendance = Math.round(students.reduce((acc, s) => acc + s.attendance, 0) / students.length) || 0;
            const avgProgress = Math.round(students.reduce((acc, s) => acc + s.progress, 0) / students.length) || 0;

            document.getElementById('metric-active-siswa').innerText = `${activeCount} / ${students.length}`;
            document.getElementById('metric-avg-attendance').innerText = `${avgAttendance}%`;
            document.getElementById('metric-avg-progress').innerText = `${avgProgress}%`;

            const masterList = document.getElementById('students-master-list');
            masterList.innerHTML = '';

            const filtered = students.filter(student => {
                const matchesSearch = student.name.toLowerCase().includes(currentSearchQuery.toLowerCase()) ||
                                      student.email.toLowerCase().includes(currentSearchQuery.toLowerCase()) ||
                                      student.phone.includes(currentSearchQuery) ||
                                      student.course.toLowerCase().includes(currentSearchQuery.toLowerCase());
                
                const matchesLang = currentFilterLang === 'All' || student.lang === currentFilterLang;
                const matchesStatus = currentFilterStatus === 'All' || student.status === currentFilterStatus;
                
                return matchesSearch && matchesLang && matchesStatus;
            });

            // Auto-select first if none selected or selection is filtered out
            if (filtered.length > 0) {
                const exists = filtered.some(s => s.id === selectedStudentId);
                if (!exists) {
                    selectedStudentId = filtered[0].id;
                }
            } else {
                selectedStudentId = null;
            }

            if (filtered.length === 0) {
                masterList.innerHTML = `
                    <div class="p-12 text-center text-slate-400 space-y-2">
                        <i data-lucide="users" class="h-8 w-8 mx-auto text-slate-300"></i>
                        <p class="text-xs font-semibold">Tidak ada siswa yang sesuai filter.</p>
                    </div>
                `;
            } else {
                filtered.forEach(student => {
                    const isSelected = student.id === selectedStudentId;
                    const card = document.createElement('div');
                    card.className = `p-3.5 flex items-center justify-between gap-3 cursor-pointer transition duration-150 ${
                        isSelected 
                            ? 'bg-blue-50/50 border-l-4 border-l-blue-600 pl-2.5' 
                            : 'hover:bg-slate-50/50 border-l-4 border-l-transparent'
                    }`;
                    card.onclick = () => selectStudent(student.id);

                    let statusBg = 'bg-slate-400';
                    if (student.status === 'Active') statusBg = 'bg-emerald-500';
                    else if (student.status === 'Suspended') statusBg = 'bg-rose-500';

                    card.innerHTML = `
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl font-bold text-xs ${student.color}">
                                ${student.avatar}
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-900 truncate">${student.name}</p>
                                <p class="text-[10px] text-slate-400 truncate mt-0.5">${student.course}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="h-2 w-2 rounded-full ${statusBg}"></span>
                            <i data-lucide="chevron-right" class="h-4 w-4 text-slate-300"></i>
                        </div>
                    `;
                    masterList.appendChild(card);
                });
            }

            renderDetailInspector();
            lucide.createIcons();
            syncSidebarBadges();
        }

        function selectStudent(studentId) {
            selectedStudentId = studentId;
            loadStudentsData();
        }

        function renderDetailInspector() {
            const container = document.getElementById('students-detail-inspector');
            const students = JSON.parse(localStorage.getItem('brainy_students') || '[]');
            const student = students.find(s => s.id === selectedStudentId);

            if (!student) {
                container.innerHTML = `
                    <div class="my-auto text-center text-slate-400 space-y-3">
                        <div class="h-16 w-16 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto border border-blue-100/50 shadow-inner">
                            <i data-lucide="search" class="h-7 w-7"></i>
                        </div>
                        <h3 class="text-sm font-bold text-slate-800">Detail Profil Siswa</h3>
                        <p class="text-xs text-slate-500 max-w-xs mx-auto leading-relaxed">Pilih salah satu siswa di direktori sebelah kiri untuk melihat detail informasi akademis lengkap.</p>
                    </div>
                `;
                return;
            }

            let statusBadge = 'bg-slate-50 text-slate-600 border-slate-100';
            if (student.status === 'Active') statusBadge = 'bg-emerald-50 text-emerald-700 border-emerald-100/50';
            else if (student.status === 'Suspended') statusBadge = 'bg-rose-50 text-rose-700 border-rose-100/50';

            const activeToggleButtons = `
                ${student.status !== 'Active' ? `<button onclick="updateStudentStatus(${student.id}, 'Active')" class="inline-flex h-9 items-center gap-1.5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 text-xs font-bold text-emerald-700 transition hover:bg-emerald-100/50 active:scale-[0.98] cursor-pointer">Aktifkan Siswa</button>` : ''}
                ${student.status !== 'Inactive' ? `<button onclick="updateStudentStatus(${student.id}, 'Inactive')" class="inline-flex h-9 items-center gap-1.5 rounded-xl border border-slate-200 bg-slate-50 px-4 text-xs font-bold text-slate-600 transition hover:bg-slate-100 active:scale-[0.98] cursor-pointer">Nonaktifkan Siswa</button>` : ''}
                ${student.status !== 'Suspended' ? `<button onclick="updateStudentStatus(${student.id}, 'Suspended')" class="inline-flex h-9 items-center gap-1.5 rounded-xl border border-rose-200 bg-rose-50 px-4 text-xs font-bold text-rose-700 transition hover:bg-rose-100/50 active:scale-[0.98] cursor-pointer">Skorsing Siswa</button>` : ''}
            `;

            container.innerHTML = `
                <div class="space-y-6 overflow-y-auto pr-1">
                    <!-- Profile Header Block -->
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 pb-5 border-b border-slate-100 text-center sm:text-left">
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl font-bold text-xl ${student.color} shadow-inner">
                            ${student.avatar}
                        </div>
                        <div class="min-w-0 flex-1 space-y-1">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 justify-center sm:justify-start">
                                <h3 class="text-lg font-bold text-slate-900 truncate">${student.name}</h3>
                                <span class="inline-block mx-auto sm:mx-0 rounded-full border px-2.5 py-0.5 text-[9px] font-bold ${statusBadge}">
                                    ${student.status}
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 font-medium">${student.course} &bull; Level ${student.level}</p>
                        </div>
                    </div>

                    <!-- Info Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-3 bg-[#F8FAFC]/55 border border-slate-100 rounded-xl p-4.5">
                            <h4 class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Informasi Kontak</h4>
                            <div class="space-y-2 text-xs">
                                <div class="flex items-center gap-2.5 text-slate-700">
                                    <i data-lucide="mail" class="h-4 w-4 text-slate-400 shrink-0"></i>
                                    <span class="truncate">${student.email}</span>
                                </div>
                                <div class="flex items-center gap-2.5 text-slate-700">
                                    <i data-lucide="phone" class="h-4 w-4 text-slate-400 shrink-0"></i>
                                    <span>${student.phone}</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3 bg-[#F8FAFC]/55 border border-slate-100 rounded-xl p-4.5">
                            <h4 class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Pendaftaran & Administrasi</h4>
                            <div class="space-y-2 text-xs">
                                <div class="flex items-center gap-2.5 text-slate-700">
                                    <i data-lucide="calendar-days" class="h-4 w-4 text-slate-400 shrink-0"></i>
                                    <span>Terdaftar sejak ${student.joinedDate}</span>
                                </div>
                                <div class="flex items-center gap-2.5 text-slate-700">
                                    <i data-lucide="dollar-sign" class="h-4 w-4 text-slate-400 shrink-0"></i>
                                    <span class="font-semibold flex items-center gap-1.5">
                                        Status Biaya: 
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold ${
                                            student.paymentStatus === 'Paid' 
                                                ? 'bg-emerald-100 text-emerald-800' 
                                                : 'bg-amber-100 text-amber-800'
                                        }">
                                            ${student.paymentStatus === 'Paid' ? 'Lunas' : 'Menunggu Pelunasan'}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Academic Performance Section -->
                    <div class="border border-slate-200/60 rounded-xl p-5 space-y-4">
                        <h4 class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Performa Akademis</h4>
                        
                        <div class="space-y-3.5">
                            <!-- Progress -->
                            <div class="space-y-1.5">
                                <div class="flex items-center justify-between text-xs font-bold text-slate-700">
                                    <span>Penyelesaian Silabus (Progress)</span>
                                    <span class="text-blue-600">${student.progress}%</span>
                                </div>
                                <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-blue-600 rounded-full transition-all duration-500" style="width: ${student.progress}%"></div>
                                </div>
                            </div>

                            <!-- Attendance -->
                            <div class="space-y-1.5">
                                <div class="flex items-center justify-between text-xs font-bold text-slate-700">
                                    <span>Rasio Kehadiran (Attendance)</span>
                                    <span class="text-indigo-600">${student.attendance}%</span>
                                </div>
                                <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-indigo-600 rounded-full transition-all duration-500" style="width: ${student.attendance}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions Area -->
                    <div class="pt-4 border-t border-slate-100 space-y-4 shrink-0">
                        <h4 class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Aksi Administrasi Cepat</h4>
                        <div class="flex flex-wrap gap-2">
                            <button
                                onclick="openEditModal(${student.id})"
                                class="inline-flex h-9 items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-4 text-xs font-bold text-slate-700 transition hover:bg-slate-50 hover:border-slate-300 active:scale-[0.98] cursor-pointer"
                            >
                                <i data-lucide="edit-2" class="h-3.5 w-3.5 text-slate-400"></i>
                                Ubah Profil
                            </button>

                            ${activeToggleButtons}

                            <button
                                onclick="deleteStudent(${student.id}, '${student.name}')"
                                class="inline-flex h-9 items-center gap-1.5 rounded-xl bg-rose-50 text-rose-600 border border-rose-100/50 px-4 text-xs font-bold transition hover:bg-rose-100/80 active:scale-[0.98] sm:ml-auto cursor-pointer"
                            >
                                <i data-lucide="trash-2" class="h-3.5 w-3.5 text-rose-500"></i>
                                Hapus Data Siswa
                            </button>
                        </div>
                    </div>
                </div>
            `;
            lucide.createIcons();
        }

        // Filters pills
        function setFilterLang(lang) {
            currentFilterLang = lang;
            ['All', 'English', 'Japanese', 'Korean'].forEach(l => {
                const btn = document.getElementById(`btn-filter-lang-${l}`);
                if (l === lang) {
                    btn.className = "px-2.5 py-1 rounded-md text-[10px] font-bold transition-all bg-blue-50 text-blue-600 border border-blue-100/30 cursor-pointer";
                } else {
                    btn.className = "px-2.5 py-1 rounded-md text-[10px] font-bold transition-all text-slate-500 hover:text-slate-900 hover:bg-slate-50 cursor-pointer";
                }
            });
            loadStudentsData();
        }

        function setFilterStatus(status) {
            currentFilterStatus = status;
            ['All', 'Active', 'Inactive', 'Suspended'].forEach(s => {
                const btn = document.getElementById(`btn-filter-status-${s}`);
                if (s === status) {
                    btn.className = "px-2.5 py-1 rounded-md text-[10px] font-bold transition-all bg-slate-800 text-white cursor-pointer";
                } else {
                    btn.className = "px-2.5 py-1 rounded-md text-[10px] font-bold transition-all text-slate-500 hover:text-slate-900 hover:bg-slate-50 cursor-pointer";
                }
            });
            loadStudentsData();
        }

        function handleSearch(query) {
            currentSearchQuery = query;
            loadStudentsData();
        }

        // Sidebar search callback
        window.onLocalSearch = function(query) {
            document.getElementById('search-input').value = query;
            handleSearch(query);
        }

        // Form Modal Actions
        function openAddModal() {
            document.getElementById('student-modal-title').innerText = 'Registrasi Siswa Baru';
            document.getElementById('student-modal-desc').innerText = 'Isi formulir secara lengkap untuk mendaftarkan siswa baru.';
            
            document.getElementById('student-id-input').value = '';
            document.getElementById('student-name-input').value = '';
            document.getElementById('student-email-input').value = '';
            document.getElementById('student-phone-input').value = '';
            document.getElementById('student-lang-select').value = 'English';
            document.getElementById('student-level-select').value = 'Intermediate';
            document.getElementById('student-payment-select').value = 'Paid';
            document.getElementById('student-course-input').value = 'English Intermediate Class';
            document.getElementById('student-status-select').value = 'Active';
            document.getElementById('student-attendance-input').value = '100';
            document.getElementById('student-progress-input').value = '0';

            document.getElementById('student-modal').classList.remove('hidden');
        }

        function openEditModal(studentId) {
            const students = JSON.parse(localStorage.getItem('brainy_students') || '[]');
            const student = students.find(s => s.id === studentId);
            if (!student) return;

            document.getElementById('student-modal-title').innerText = 'Ubah Data Siswa';
            document.getElementById('student-modal-desc').innerText = `Ubah profil dan status akademis untuk ${student.name}.`;
            
            document.getElementById('student-id-input').value = student.id;
            document.getElementById('student-name-input').value = student.name;
            document.getElementById('student-email-input').value = student.email;
            document.getElementById('student-phone-input').value = student.phone;
            document.getElementById('student-lang-select').value = student.lang;
            document.getElementById('student-level-select').value = student.level;
            document.getElementById('student-payment-select').value = student.paymentStatus;
            document.getElementById('student-course-input').value = student.course;
            document.getElementById('student-status-select').value = student.status;
            document.getElementById('student-attendance-input').value = student.attendance;
            document.getElementById('student-progress-input').value = student.progress;

            document.getElementById('student-modal').classList.remove('hidden');
        }

        function closeStudentModal() {
            document.getElementById('student-modal').classList.add('hidden');
        }

        function handleStudentFormSubmit(e) {
            e.preventDefault();
            const id = document.getElementById('student-id-input').value;
            const name = document.getElementById('student-name-input').value.trim();
            const email = document.getElementById('student-email-input').value.trim();
            const phone = document.getElementById('student-phone-input').value.trim();
            const lang = document.getElementById('student-lang-select').value;
            const level = document.getElementById('student-level-select').value;
            const paymentStatus = document.getElementById('student-payment-select').value;
            const course = document.getElementById('student-course-input').value.trim();
            const status = document.getElementById('student-status-select').value;
            const attendance = parseInt(document.getElementById('student-attendance-input').value) || 0;
            const progress = parseInt(document.getElementById('student-progress-input').value) || 0;

            const initials = name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
            let students = JSON.parse(localStorage.getItem('brainy_students') || '[]');

            if (id) {
                // Edit mode
                students = students.map(student => {
                    if (student.id === parseInt(id)) {
                        return { ...student, name, email, phone, lang, level, paymentStatus, course, status, attendance, progress, avatar: initials };
                    }
                    return student;
                });
                showToast(`Profil ${name} berhasil diperbarui!`, 'success');
            } else {
                // Add mode
                const colors = [
                    'bg-blue-50 text-blue-600 border border-blue-100/50',
                    'bg-purple-50 text-purple-600 border border-purple-100/50',
                    'bg-orange-50 text-orange-600 border border-orange-100/50'
                ];
                const randomColor = colors[Math.floor(Math.random() * colors.length)];
                
                const newStudent = {
                    id: Date.now(),
                    name, email, phone, course, level, lang,
                    joinedDate: new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }),
                    status, attendance, progress, paymentStatus,
                    avatar: initials,
                    color: randomColor
                };
                
                students.unshift(newStudent);
                selectedStudentId = newStudent.id;

                // Increment total siswa count in localStorage
                const total = parseInt(localStorage.getItem('brainy_total_siswa') || '248') + 1;
                localStorage.setItem('brainy_total_siswa', total.toString());
                
                showToast(`Siswa ${name} berhasil didaftarkan!`, 'success');
            }

            localStorage.setItem('brainy_students', JSON.stringify(students));
            closeStudentModal();
            loadStudentsData();
        }

        function updateStudentStatus(studentId, newStatus) {
            let students = JSON.parse(localStorage.getItem('brainy_students') || '[]');
            students = students.map(s => {
                if (s.id === studentId) {
                    return { ...s, status: newStatus };
                }
                return s;
            });
            localStorage.setItem('brainy_students', JSON.stringify(students));
            showToast(`Status akademis diperbarui menjadi ${newStatus}`, 'success');
            loadStudentsData();
        }

        function deleteStudent(studentId, studentName) {
            if (confirm(`Apakah Anda yakin ingin mengeluarkan/menghapus siswa ${studentName} dari lembaga?`)) {
                let students = JSON.parse(localStorage.getItem('brainy_students') || '[]');
                students = students.filter(s => s.id !== studentId);
                localStorage.setItem('brainy_students', JSON.stringify(students));

                const total = Math.max(0, parseInt(localStorage.getItem('brainy_total_siswa') || '248') - 1);
                localStorage.setItem('brainy_total_siswa', total.toString());

                showToast(`Siswa ${studentName} telah dihapus dari direktori.`, 'info');
                loadStudentsData();
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            loadStudentsData();
        });
    </script>
@endsection
