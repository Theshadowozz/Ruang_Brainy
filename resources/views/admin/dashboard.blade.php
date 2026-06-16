@extends('layouts.admin')

@section('title', 'Brainy Admin - Dashboard')
@section('page_title', 'Dasbor Ringkasan')
@section('page_description', 'Pantau parameter operasional lembaga bahasa asing Brainy.')

@php
    $activeTab = 'dashboard';
@endphp

@section('content')
    <!-- Compact Greeting Banner & Dynamic Calendar widget -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white border border-slate-200/60 rounded-2xl p-5 shadow-sm">
        <div class="max-w-xl">
            <div class="flex items-center gap-2">
                <span class="flex h-2 w-2 rounded-full bg-blue-500 animate-pulse"></span>
                <span class="rounded-full bg-blue-50 px-2.5 py-0.5 text-[11px] font-bold text-blue-600 border border-blue-100/30">Laporan Lembaga</span>
            </div>
            <h2 class="text-xl font-extrabold text-slate-900 tracking-tight mt-2">Selamat Datang Kembali, Admin!</h2>
            <p class="text-xs text-slate-500 mt-1 leading-relaxed">Kelola pendaftaran siswa, verifikasi pembayaran tertunda, dan pantau operasional kelas bahasa secara terpusat.</p>
        </div>
        <div class="flex items-center gap-2.5 rounded-xl border border-slate-100 bg-slate-50/50 px-4 py-2.5 text-xs font-bold text-slate-600 w-max shadow-inner">
            <i data-lucide="calendar-days" class="h-4.5 w-4.5 text-blue-600"></i>
            <span id="current-date">Kamis, 11 Juni 2026</span>
        </div>
    </div>

    <!-- Stats Widget Row - horizontal layout -->
    <section class="grid gap-5 grid-cols-1 md:grid-cols-4">
        <!-- Stat Card 1: Total Siswa -->
        <article class="relative overflow-hidden rounded-2xl border border-slate-200/70 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Siswa</p>
                    <p id="stat-total-siswa" class="text-2xl font-extrabold tracking-tight text-slate-900 mt-1.5">-</p>
                </div>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 border border-blue-100/30">
                    <i data-lucide="users" class="h-5 w-5"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between gap-2">
                <div class="flex items-center gap-1 text-[10px] text-emerald-600 font-extrabold bg-emerald-50 border border-emerald-100/30 rounded-lg px-2 py-0.5">
                    <i data-lucide="trending-up" class="h-3 w-3"></i>
                    <span>+12</span>
                </div>
                <svg id="sparkline-siswa" class="h-7 w-28 shrink-0 text-blue-500" viewBox="0 0 120 30"></svg>
            </div>
        </article>

        <!-- Stat Card 2: Kelas Aktif -->
        <article class="relative overflow-hidden rounded-2xl border border-slate-200/70 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Kelas Aktif</p>
                    <p class="text-2xl font-extrabold tracking-tight text-slate-900 mt-1.5">12</p>
                </div>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-violet-50 text-violet-600 border border-violet-100/30">
                    <i data-lucide="graduation-cap" class="h-5 w-5"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between gap-2">
                <span class="text-[10px] text-violet-600 font-extrabold bg-violet-50 border border-violet-100/30 rounded-lg px-2 py-0.5">
                    7 bahasa
                </span>
                <svg id="sparkline-kelas" class="h-7 w-28 shrink-0 text-violet-500" viewBox="0 0 120 30"></svg>
            </div>
        </article>

        <!-- Stat Card 3: Pendapatan -->
        <article class="relative overflow-hidden rounded-2xl border border-slate-200/70 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Pendapatan</p>
                    <p id="stat-pendapatan" class="text-2xl font-extrabold tracking-tight text-slate-900 mt-1.5">-</p>
                </div>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100/30">
                    <i data-lucide="dollar-sign" class="h-5 w-5"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between gap-2">
                <div class="flex items-center gap-1 text-[10px] text-emerald-600 font-extrabold bg-emerald-50 border border-emerald-100/30 rounded-lg px-2 py-0.5">
                    <i data-lucide="trending-up" class="h-3 w-3"></i>
                    <span>+18%</span>
                </div>
                <svg id="sparkline-pendapatan" class="h-7 w-28 shrink-0 text-emerald-500" viewBox="0 0 120 30"></svg>
            </div>
        </article>

        <!-- Stat Card 4: Waiting List -->
        <article class="relative overflow-hidden rounded-2xl border border-slate-200/70 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Waiting List</p>
                    <p id="stat-waiting-list" class="text-2xl font-extrabold tracking-tight text-slate-900 mt-1.5">-</p>
                </div>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-orange-50 text-orange-600 border border-orange-100/30">
                    <i data-lucide="clipboard-list" class="h-5 w-5"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between gap-2">
                <span class="text-[10px] text-orange-600 font-extrabold bg-orange-50 border border-orange-100/30 rounded-lg px-2 py-0.5">
                    Tindak lanjut
                </span>
                <svg id="sparkline-waiting" class="h-7 w-28 shrink-0 text-orange-500" viewBox="0 0 120 30"></svg>
            </div>
        </article>
    </section>

    <!-- Quick Access Menu Cards -->
    <section>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-sm font-bold text-slate-900">Menu Administrasi Cepat</h2>
        </div>
        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            <!-- Menu 1 -->
            <button onclick="showDevInfo('Kelola Kursus')" class="group relative text-left rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-blue-500/20 border-l-4 border-l-blue-500 cursor-pointer">
                <div class="flex justify-between items-start">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 border border-slate-100 text-slate-700 transition-colors group-hover:bg-blue-50 group-hover:text-blue-600 group-hover:border-blue-100/50">
                        <i data-lucide="graduation-cap" class="h-5 w-5"></i>
                    </div>
                    <span class="text-slate-300 transition-transform group-hover:translate-x-1"><i data-lucide="chevron-right" class="h-4 w-4"></i></span>
                </div>
                <h3 class="mt-4 text-xs font-bold text-slate-900">Kelola Kursus</h3>
                <p class="mt-1 text-[11px] text-slate-500 font-medium leading-relaxed">Tambah, edit, dan hapus kurikulum bahasa.</p>
            </button>

            <!-- Menu 2 -->
            <button onclick="showDevInfo('Pembayaran')" class="group relative text-left rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-blue-500/20 border-l-4 border-l-blue-500 cursor-pointer">
                <div class="flex justify-between items-start">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 border border-slate-100 text-slate-700 transition-colors group-hover:bg-blue-50 group-hover:text-blue-600 group-hover:border-blue-100/50">
                        <i data-lucide="dollar-sign" class="h-5 w-5"></i>
                    </div>
                    <span class="text-slate-300 transition-transform group-hover:translate-x-1"><i data-lucide="chevron-right" class="h-4 w-4"></i></span>
                </div>
                <h3 class="mt-4 text-xs font-bold text-slate-900">Pembayaran</h3>
                <p class="mt-1 text-[11px] text-slate-500 font-medium leading-relaxed">Verifikasi & pantau mutasi invoice pendaftaran.</p>
            </button>

            <!-- Menu 3 -->
            <a href="/admin/waitinglist" class="group relative text-left block rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-blue-500/20 border-l-4 border-l-blue-500">
                <div class="flex justify-between items-start">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 border border-slate-100 text-slate-700 transition-colors group-hover:bg-blue-50 group-hover:text-blue-600 group-hover:border-blue-100/50">
                        <i data-lucide="clipboard-list" class="h-5 w-5"></i>
                    </div>
                    <span class="text-slate-300 transition-transform group-hover:translate-x-1"><i data-lucide="chevron-right" class="h-4 w-4"></i></span>
                </div>
                <h3 class="mt-4 text-xs font-bold text-slate-900">Waiting List</h3>
                <p class="mt-1 text-[11px] text-slate-500 font-medium leading-relaxed">Kelola alokasi kelas pendaftaran penuh.</p>
            </a>

            <!-- Menu 4 -->
            <a href="/admin/tutors" class="group relative text-left block rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-blue-500/20 border-l-4 border-l-blue-500">
                <div class="flex justify-between items-start">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 border border-slate-100 text-slate-700 transition-colors group-hover:bg-blue-50 group-hover:text-blue-600 group-hover:border-blue-100/50">
                        <i data-lucide="user-check" class="h-5 w-5"></i>
                    </div>
                    <span class="text-slate-300 transition-transform group-hover:translate-x-1"><i data-lucide="chevron-right" class="h-4 w-4"></i></span>
                </div>
                <h3 class="mt-4 text-xs font-bold text-slate-900">Kelola Tutor</h3>
                <p class="mt-1 text-[11px] text-slate-500 font-medium leading-relaxed">Atur penugasan dan ketersediaan mengajar.</p>
            </a>

            <!-- Menu 5 -->
            <button onclick="showDevInfo('Jadwal Kelas')" class="group relative text-left rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-blue-500/20 border-l-4 border-l-blue-500 cursor-pointer">
                <div class="flex justify-between items-start">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 border border-slate-100 text-slate-700 transition-colors group-hover:bg-blue-50 group-hover:text-blue-600 group-hover:border-blue-100/50">
                        <i data-lucide="calendar-days" class="h-5 w-5"></i>
                    </div>
                    <span class="text-slate-300 transition-transform group-hover:translate-x-1"><i data-lucide="chevron-right" class="h-4 w-4"></i></span>
                </div>
                <h3 class="mt-4 text-xs font-bold text-slate-900">Jadwal Kelas</h3>
                <p class="mt-1 text-[11px] text-slate-500 font-medium leading-relaxed">Atur pemetaan ruangan dan waktu belajar.</p>
            </button>

            <!-- Menu 6 -->
            <a href="/admin/students" class="group relative text-left block rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-blue-500/20 border-l-4 border-l-blue-500">
                <div class="flex justify-between items-start">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 border border-slate-100 text-slate-700 transition-colors group-hover:bg-blue-50 group-hover:text-blue-600 group-hover:border-blue-100/50">
                        <i data-lucide="users" class="h-5 w-5"></i>
                    </div>
                    <span class="text-slate-300 transition-transform group-hover:translate-x-1"><i data-lucide="chevron-right" class="h-4 w-4"></i></span>
                </div>
                <h3 class="mt-4 text-xs font-bold text-slate-900">Data Siswa</h3>
                <p class="mt-1 text-[11px] text-slate-500 font-medium leading-relaxed">Direktori komprehensif profil & status siswa.</p>
            </a>
        </div>
    </section>

    <!-- Operational Tables Section -->
    <section class="grid gap-5 xl:grid-cols-12">
        <!-- Recent Registrations Table -->
        <div class="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm xl:col-span-7 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-start pb-3.5 border-b border-slate-100">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Pendaftaran Terbaru</h2>
                        <p class="text-[11px] text-slate-500 mt-0.5">Daftar pendaftaran siswa paling mutakhir.</p>
                    </div>
                </div>
                <div id="recent-registrations-list" class="mt-3 divide-y divide-slate-100">
                    <!-- Loaded dynamically via JS -->
                </div>
            </div>
        </div>

        <!-- Pending Payments Table -->
        <div class="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm xl:col-span-5 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-start pb-3.5 border-b border-slate-100">
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Pembayaran Pending</h2>
                        <p class="text-[11px] text-slate-500 mt-0.5">Validasi struk transaksi pendaftaran.</p>
                    </div>
                    <span id="badge-pembayaran-card" class="rounded-full bg-amber-50 border border-amber-100/50 px-2 py-0.5 text-[10px] font-bold text-amber-600">
                        0 Pending
                    </span>
                </div>

                <div id="pending-payments-list" class="mt-3 divide-y divide-slate-100">
                    <!-- Loaded dynamically via JS -->
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // Update greeting banner date
        document.getElementById('current-date').innerText = new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });

        // Load data from localStorage
        function loadDashboard() {
            const totalSiswa = localStorage.getItem('brainy_total_siswa') || '248';
            const pendapatan = parseInt(localStorage.getItem('brainy_pendapatan') || '45200000');
            const waitingList = JSON.parse(localStorage.getItem('brainy_waiting_list') || '[]');
            const pendingPayments = JSON.parse(localStorage.getItem('brainy_pending_payments') || '[]');
            const recentStudents = JSON.parse(localStorage.getItem('brainy_recent_students') || '[]');

            // Set stats text
            document.getElementById('stat-total-siswa').innerText = totalSiswa;
            document.getElementById('stat-waiting-list').innerText = waitingList.length;
            document.getElementById('stat-pendapatan').innerText = 'Rp ' + (pendapatan / 1000000).toFixed(1) + 'M';

            // Draw sparklines
            drawSparkline('sparkline-siswa', [220, 225, 230, 238, 242, parseInt(totalSiswa)], 'text-blue-500');
            drawSparkline('sparkline-kelas', [8, 9, 10, 10, 11, 12], 'text-violet-500');
            drawSparkline('sparkline-pendapatan', [30, 32, 35, 38, 42, pendapatan / 1000000], 'text-emerald-500');
            drawSparkline('sparkline-waiting', [15, 18, 22, 28, 25, waitingList.length], 'text-orange-500');

            // Render Recent Registrations
            const recentContainer = document.getElementById('recent-registrations-list');
            recentContainer.innerHTML = '';
            recentStudents.forEach(student => {
                const item = document.createElement('div');
                item.className = 'flex items-center gap-3.5 py-3 first:pt-0 last:pb-0 group';
                item.innerHTML = `
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl font-bold text-xs ${student.color}">
                        ${student.avatar}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition-colors">${student.name}</p>
                        <p class="text-[10px] text-slate-500 mt-0.5">${student.course}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] text-slate-400 font-semibold">${student.date}</p>
                        <span class="inline-block mt-1 text-[9px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-100/50 rounded-full px-2 py-0.5">
                            Aktif
                        </span>
                    </div>
                `;
                recentContainer.appendChild(item);
            });

            // Render Pending Payments
            const pendingContainer = document.getElementById('pending-payments-list');
            pendingContainer.innerHTML = '';
            document.getElementById('badge-pembayaran-card').innerText = `${pendingPayments.length} Pending`;
            
            if (pendingPayments.length === 0) {
                pendingContainer.innerHTML = `
                    <div class="py-12 text-center text-slate-400 space-y-2">
                        <div class="flex justify-center text-emerald-500">
                            <i data-lucide="check" class="h-8 w-8 rounded-full bg-emerald-50 p-1 border border-emerald-100"></i>
                        </div>
                        <p class="text-xs font-semibold">Semua Pembayaran Selesai divalidasi!</p>
                    </div>
                `;
            } else {
                pendingPayments.forEach(payment => {
                    const item = document.createElement('div');
                    item.className = 'flex items-center gap-4 py-3.5 first:pt-0 last:pb-0';
                    item.innerHTML = `
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-bold text-slate-900">${payment.name}</p>
                            <p class="text-[10px] text-slate-500 mt-0.5">${payment.course}</p>
                            <p class="text-xs font-extrabold text-blue-600 mt-1">${payment.amount}</p>
                        </div>
                        <button
                            onclick="confirmPayment(${payment.id})"
                            class="inline-flex h-8 items-center justify-center rounded-xl bg-blue-600 px-4 text-[11px] font-bold text-white shadow-sm transition hover:bg-blue-700 active:scale-[0.97] hover:shadow-md cursor-pointer"
                        >
                            Konfirmasi
                        </button>
                    `;
                    pendingContainer.appendChild(item);
                });
            }
            lucide.createIcons();
            syncSidebarBadges();
        }

        // Draw Sparkline mathematically using SVG
        function drawSparkline(svgId, points, colorClass) {
            const width = 120;
            const height = 30;
            const padding = 2;
            const maxVal = Math.max(...points);
            const minVal = Math.min(...points);
            const range = maxVal - minVal || 1;
            
            const pathData = points.map((p, idx) => {
                const x = (idx / (points.length - 1)) * (width - padding * 2) + padding;
                const y = height - ((p - minVal) / range) * (height - padding * 2) - padding;
                return `${idx === 0 ? 'M' : 'L'} ${x.toFixed(1)} ${y.toFixed(1)}`;
            }).join(' ');

            const svg = document.getElementById(svgId);
            if (svg) {
                svg.innerHTML = `
                    <path
                        d="${pathData}"
                        fill="none"
                        class="${colorClass} stroke-current"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                `;
            }
        }

        // Action: Confirm Payment
        function confirmPayment(paymentId) {
            const pendingPayments = JSON.parse(localStorage.getItem('brainy_pending_payments') || '[]');
            const payment = pendingPayments.find(p => p.id === paymentId);
            if (!payment) return;

            // Remove from pending
            const updatedPending = pendingPayments.filter(p => p.id !== paymentId);
            localStorage.setItem('brainy_pending_payments', JSON.stringify(updatedPending));

            // Append to recent students
            const initials = payment.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
            const colors = ['bg-blue-50 text-blue-600 border border-blue-100/50', 'bg-emerald-50 text-emerald-600 border border-emerald-100/50', 'bg-indigo-50 text-indigo-600 border border-indigo-100/50'];
            const randomColor = colors[Math.floor(Math.random() * colors.length)];
            
            const newRecent = {
                id: Date.now(),
                name: payment.name,
                course: payment.course,
                date: 'Hari Ini',
                avatar: initials,
                color: randomColor
            };

            const recentStudents = JSON.parse(localStorage.getItem('brainy_recent_students') || '[]');
            recentStudents.unshift(newRecent);
            localStorage.setItem('brainy_recent_students', JSON.stringify(recentStudents.slice(0, 5)));

            // Increment total siswa & pendapatan
            const totalSiswa = parseInt(localStorage.getItem('brainy_total_siswa') || '248') + 1;
            const pendapatan = parseInt(localStorage.getItem('brainy_pendapatan') || '45200000') + payment.rawAmount;
            
            localStorage.setItem('brainy_total_siswa', totalSiswa.toString());
            localStorage.setItem('brainy_pendapatan', pendapatan.toString());

            // Sync with main students directory
            const students = JSON.parse(localStorage.getItem('brainy_students') || '[]');
            const newStudent = {
                id: newRecent.id,
                name: newRecent.name,
                email: `${newRecent.name.toLowerCase().replace(/\s+/g, '')}@email.com`,
                phone: '081234567899',
                course: newRecent.course,
                level: newRecent.course.toLowerCase().includes('begin') ? 'Beginner' : newRecent.course.toLowerCase().includes('adv') ? 'Advanced' : 'Intermediate',
                lang: newRecent.course.toLowerCase().includes('english') ? 'English' : newRecent.course.toLowerCase().includes('japan') ? 'Japanese' : 'Korean',
                joinedDate: 'Hari Ini',
                status: 'Active',
                attendance: 100,
                progress: 0,
                paymentStatus: 'Paid',
                avatar: initials,
                color: randomColor
            };
            students.unshift(newStudent);
            localStorage.setItem('brainy_students', JSON.stringify(students));

            showToast(`Pembayaran ${payment.name} (${payment.amount}) berhasil dikonfirmasi!`, 'success');
            loadDashboard();
        }

        // On Page Load
        document.addEventListener('DOMContentLoaded', () => {
            loadDashboard();
        });
    </script>
@endsection
