@extends('layouts.admin')

@section('title', 'Brainy Admin - Waiting List')
@section('page_title', 'Daftar Tunggu (Waiting List)')
@section('page_description', 'Kelola antrean kelas siswa karena keterbatasan kapasitas ruangan.')

@php
    $activeTab = 'waitinglist';
@endphp

@section('content')
    <!-- Clean Stats highlights for Waiting List -->
    <section class="grid gap-5 grid-cols-1 sm:grid-cols-3">
        <article class="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-orange-50 text-orange-600 border border-orange-100/30">
                    <i data-lucide="clipboard-list" class="h-5 w-5"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Antrean</p>
                    <p id="stat-waiting-count" class="text-xl font-extrabold text-slate-900 mt-0.5">- Siswa</p>
                </div>
            </div>
        </article>
        <article class="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 border border-blue-100/30">
                    <i data-lucide="graduation-cap" class="h-5 w-5"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Kursus Terpadat</p>
                    <p class="text-xl font-extrabold text-slate-900 mt-0.5">English (12 siswa)</p>
                </div>
            </div>
        </article>
        <article class="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100/30">
                    <i data-lucide="clock" class="h-5 w-5"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Rata-rata Waktu Tunggu</p>
                    <p class="text-xl font-extrabold text-slate-900 mt-0.5">4.2 Hari</p>
                </div>
            </div>
        </article>
    </section>

    <!-- Waiting List Core Panel -->
    <section class="bg-white border border-slate-200/60 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-1.5 p-1 bg-slate-50 border border-slate-200/50 rounded-xl w-max">
                <button onclick="setFilterLang('All')" id="btn-filter-All" class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all bg-white text-blue-600 shadow-sm border border-slate-200/20">All</button>
                <button onclick="setFilterLang('English')" id="btn-filter-English" class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all text-slate-500 hover:text-slate-900">English</button>
                <button onclick="setFilterLang('Japanese')" id="btn-filter-Japanese" class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all text-slate-500 hover:text-slate-900">Japanese</button>
                <button onclick="setFilterLang('Korean')" id="btn-filter-Korean" class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all text-slate-500 hover:text-slate-900">Korean</button>
            </div>

            <div class="relative max-w-sm w-full sm:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i data-lucide="search" class="h-4 w-4"></i>
                </span>
                <input
                    id="search-input"
                    type="text"
                    oninput="handleSearch(this.value)"
                    placeholder="Cari nama, email, kursus..."
                    class="h-9 w-full rounded-xl border border-slate-200 pl-9 pr-4 text-xs font-medium outline-none transition focus:border-blue-500 focus:bg-white"
                />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                        <th class="px-6 py-4">Nama Siswa</th>
                        <th class="px-6 py-4">Kontak</th>
                        <th class="px-6 py-4">Kursus</th>
                        <th class="px-6 py-4">Tanggal Masuk</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="waiting-list-tbody" class="divide-y divide-slate-100 text-slate-700">
                    <!-- Dynamic rendering via JS -->
                </tbody>
            </table>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        let currentFilterLang = 'All';
        let currentSearchQuery = '';

        function renderWaitingList() {
            const list = JSON.parse(localStorage.getItem('brainy_waiting_list') || '[]');
            document.getElementById('stat-waiting-count').innerText = `${list.length} Siswa`;

            const filtered = list.filter(student => {
                const matchesSearch = student.name.toLowerCase().includes(currentSearchQuery.toLowerCase()) || 
                                      student.email.toLowerCase().includes(currentSearchQuery.toLowerCase()) ||
                                      student.phone.includes(currentSearchQuery) ||
                                      student.course.toLowerCase().includes(currentSearchQuery.toLowerCase());
                
                const matchesLang = currentFilterLang === 'All' || student.rawLanguage === currentFilterLang;
                
                return matchesSearch && matchesLang;
            });

            const tbody = document.getElementById('waiting-list-tbody');
            tbody.innerHTML = '';

            if (filtered.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colSpan="5" class="px-6 py-12 text-center text-slate-400">
                            <div class="flex justify-center mb-3">
                                <i data-lucide="clipboard-list" class="h-8 w-8 text-slate-300"></i>
                            </div>
                            <p class="text-xs font-semibold">Tidak ada siswa yang menunggu dalam daftar.</p>
                        </td>
                    </tr>
                `;
            } else {
                filtered.forEach(student => {
                    const row = document.createElement('tr');
                    row.className = 'transition hover:bg-slate-50/30 group';
                    
                    let langBadgeStyle = '';
                    switch(student.rawLanguage) {
                        case 'English': langBadgeStyle = 'bg-blue-50 text-blue-700 border-blue-100/50'; break;
                        case 'Japanese': langBadgeStyle = 'bg-purple-50 text-purple-700 border-purple-100/50'; break;
                        case 'Korean': langBadgeStyle = 'bg-orange-50 text-orange-700 border-orange-100/50'; break;
                        default: langBadgeStyle = 'bg-slate-50 text-slate-700 border-slate-100';
                    }

                    row.innerHTML = `
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl font-bold text-xs ${student.color}">
                                    ${student.avatar}
                                </div>
                                <p class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition-colors">${student.name}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="space-y-0.5">
                                <p class="text-xs text-slate-700 flex items-center gap-1.5"><i data-lucide="mail" class="h-3.5 w-3.5 text-slate-400"></i>${student.email}</p>
                                <p class="text-[10px] text-slate-400 flex items-center gap-1.5"><i data-lucide="phone" class="h-3.5 w-3.5 text-slate-400"></i>${student.phone}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block rounded-full border px-2.5 py-0.5 text-[10px] font-bold ${langBadgeStyle}">
                                ${student.course}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1.5 text-xs text-slate-500 font-medium">
                                <i data-lucide="calendar-days" class="h-4 w-4 text-slate-400"></i>
                                <span>${student.date}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button
                                    onclick="acceptStudent(${student.id})"
                                    class="inline-flex h-8 items-center gap-1.5 rounded-xl bg-blue-600 px-3.5 text-xs font-bold text-white shadow-sm transition hover:bg-blue-700 active:scale-[0.97] cursor-pointer"
                                >
                                    <i data-lucide="user-plus" class="h-3.5 w-3.5"></i>
                                    Terima
                                </button>
                                <button
                                    onclick="rejectStudent(${student.id})"
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-xl text-slate-400 hover:text-red-600 hover:bg-red-50 transition active:scale-[0.95] cursor-pointer"
                                    title="Tolak"
                                >
                                    <i data-lucide="x" class="h-4.5 w-4.5"></i>
                                </button>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            }
            lucide.createIcons();
            syncSidebarBadges();
        }

        function setFilterLang(lang) {
            currentFilterLang = lang;
            ['All', 'English', 'Japanese', 'Korean'].forEach(l => {
                const btn = document.getElementById(`btn-filter-${l}`);
                if (l === lang) {
                    btn.className = "px-4 py-1.5 rounded-lg text-xs font-bold transition-all bg-white text-blue-600 shadow-sm border border-slate-200/20 cursor-pointer";
                } else {
                    btn.className = "px-4 py-1.5 rounded-lg text-xs font-bold transition-all text-slate-500 hover:text-slate-900 cursor-pointer";
                }
            });
            renderWaitingList();
        }

        function handleSearch(query) {
            currentSearchQuery = query;
            renderWaitingList();
        }

        // Implementation of search override
        window.onLocalSearch = function(query) {
            document.getElementById('search-input').value = query;
            handleSearch(query);
        };

        // Actions
        function acceptStudent(studentId) {
            const list = JSON.parse(localStorage.getItem('brainy_waiting_list') || '[]');
            const student = list.find(s => s.id === studentId);
            if (!student) return;

            // Remove from waitlist
            const updatedList = list.filter(s => s.id !== studentId);
            localStorage.setItem('brainy_waiting_list', JSON.stringify(updatedList));

            // Append to recent students
            const newRecent = {
                id: Date.now(),
                name: student.name,
                course: student.course,
                date: 'Hari Ini',
                avatar: student.avatar,
                color: student.color
            };

            const recentStudents = JSON.parse(localStorage.getItem('brainy_recent_students') || '[]');
            recentStudents.unshift(newRecent);
            localStorage.setItem('brainy_recent_students', JSON.stringify(recentStudents.slice(0, 5)));

            // Increment total siswa
            const totalSiswa = parseInt(localStorage.getItem('brainy_total_siswa') || '248') + 1;
            localStorage.setItem('brainy_total_siswa', totalSiswa.toString());

            // Sync with main students directory
            const students = JSON.parse(localStorage.getItem('brainy_students') || '[]');
            const newStudent = {
                id: newRecent.id,
                name: student.name,
                email: student.email,
                phone: student.phone,
                course: student.course,
                level: student.course.toLowerCase().includes('begin') ? 'Beginner' : student.course.toLowerCase().includes('adv') ? 'Advanced' : 'Intermediate',
                lang: student.rawLanguage,
                joinedDate: 'Hari Ini',
                status: 'Active',
                attendance: 100,
                progress: 0,
                paymentStatus: 'Paid',
                avatar: student.avatar,
                color: student.color
            };
            students.unshift(newStudent);
            localStorage.setItem('brainy_students', JSON.stringify(students));

            showToast(`Siswa ${student.name} berhasil diterima masuk kelas ${student.course}!`, 'success');
            renderWaitingList();
        }

        function rejectStudent(studentId) {
            const list = JSON.parse(localStorage.getItem('brainy_waiting_list') || '[]');
            const student = list.find(s => s.id === studentId);
            if (!student) return;

            const updatedList = list.filter(s => s.id !== studentId);
            localStorage.setItem('brainy_waiting_list', JSON.stringify(updatedList));

            showToast(`Antrean daftar tunggu untuk ${student.name} telah dibatalkan.`, 'info');
            renderWaitingList();
        }

        document.addEventListener('DOMContentLoaded', () => {
            renderWaitingList();
        });
    </script>
@endsection
