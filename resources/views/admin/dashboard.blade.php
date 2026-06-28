@extends('layouts.admin')

@section('title', 'Brainy Admin - Dashboard')
@section('page_title', 'Dashboard Admin')
@section('page_description', 'Ringkasan operasional pendaftaran, pembayaran, kelas, dan aktivitas terbaru.')

@php
    $activeTab = 'dashboard';
@endphp

@section('content')
    <section class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">Brainy Language Institute</p>
            <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-950">Ringkasan Operasional</h2>
            <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-500">Pantau pendapatan, siswa aktif, kapasitas kelas, dan calon siswa yang masih perlu ditindaklanjuti.</p>
        </div>
        <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700">
            <i data-lucide="calendar-days" class="h-4 w-4 text-blue-600"></i>
            <span id="current-date">Memuat tanggal</span>
        </div>
    </section>

    <section class="grid gap-5 xl:grid-cols-12">
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm xl:col-span-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-500">Pendapatan Bulan Ini</p>
                    <div class="mt-2 flex flex-wrap items-end gap-x-3 gap-y-1">
                        <p id="revenue-value" class="text-3xl font-bold tracking-tight text-slate-950">Rp 45.200.000</p>
                        <span class="mb-1 inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-100">
                            <i data-lucide="trending-up" class="h-3.5 w-3.5"></i>
                            Naik 18% dibanding bulan lalu
                        </span>
                    </div>
                </div>
                <label class="text-xs font-semibold text-slate-500">
                    Periode
                    <select id="revenue-period" class="mt-1 block h-10 rounded-xl border border-slate-200 bg-white px-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                        <option>Minggu Ini</option>
                        <option selected>Bulan Ini</option>
                        <option>Tahun Ini</option>
                    </select>
                </label>
            </div>

            <div class="mt-6">
                <div class="mb-3 flex items-center justify-between text-xs font-semibold text-slate-500">
                    <span>Tren penerimaan pembayaran</span>
                    <span>Dalam juta rupiah</span>
                </div>
                <div id="revenue-chart" class="relative h-64 rounded-xl border border-slate-200 bg-white p-3"></div>
            </div>

            <div class="mt-5 rounded-xl border border-slate-200 bg-slate-50 p-4">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold text-slate-500">Target Bulan</p>
                        <p class="mt-1 text-lg font-bold text-slate-950">Rp 50.000.000</p>
                    </div>
                    <p class="text-lg font-bold text-blue-600">90%</p>
                </div>
                <div class="mt-3 h-2.5 overflow-hidden rounded-full bg-slate-200">
                    <div class="h-full rounded-full bg-blue-600" style="width: 90%"></div>
                </div>
            </div>
        </article>

        <div class="grid gap-5 md:grid-cols-3 xl:col-span-6">
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold text-slate-500">Total Siswa Aktif</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-slate-950"><span id="stat-total-siswa">248</span> Siswa</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600 ring-1 ring-blue-100">
                        <i data-lucide="users" class="h-5 w-5"></i>
                    </div>
                </div>
                <p class="mt-5 inline-flex items-center gap-1.5 rounded-full bg-slate-50 px-3 py-1 text-xs font-semibold text-slate-700 ring-1 ring-slate-200">
                    <i data-lucide="user-plus" class="h-3.5 w-3.5 text-emerald-600"></i>
                    +12 siswa bulan ini
                </p>
            </article>

            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold text-slate-500">Kelas Aktif</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-slate-950">12</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600 ring-1 ring-blue-100">
                        <i data-lucide="graduation-cap" class="h-5 w-5"></i>
                    </div>
                </div>
                <div class="mt-5 space-y-3">
                    <p class="text-sm font-semibold text-slate-700">7 Bahasa</p>
                    <div>
                        <p class="text-xs font-semibold text-slate-500">3 Mode Belajar</p>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <span class="rounded-full border border-slate-200 px-2.5 py-1 text-xs font-semibold text-slate-700">Offline</span>
                            <span class="rounded-full border border-slate-200 px-2.5 py-1 text-xs font-semibold text-slate-700">Online</span>
                            <span class="rounded-full border border-slate-200 px-2.5 py-1 text-xs font-semibold text-slate-700">Hybrid</span>
                        </div>
                    </div>
                </div>
            </article>

            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold text-slate-500">Waiting List</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-slate-950"><span id="stat-waiting-list">5</span> Calon Siswa</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600 ring-1 ring-blue-100">
                        <i data-lucide="clipboard-list" class="h-5 w-5"></i>
                    </div>
                </div>
                <div class="mt-4 space-y-2 text-xs font-semibold text-slate-600">
                    <p class="flex items-center justify-between gap-2"><span>Menunggu Verifikasi</span><span class="text-slate-950">3</span></p>
                    <p class="flex items-center justify-between gap-2"><span>Menunggu Pembayaran</span><span class="text-slate-950">2</span></p>
                </div>
                <a href="/admin/waitinglist" class="mt-4 inline-flex h-9 items-center justify-center rounded-xl bg-blue-600 px-4 text-xs font-bold text-white transition hover:bg-blue-700 active:scale-[0.98]">Lihat Daftar</a>
            </article>
        </div>
    </section>

    <section>
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-950">Quick Action</h2>
        </div>
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            <a href="/admin/courses" class="group rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-blue-300 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 text-blue-600 ring-1 ring-slate-200 transition group-hover:bg-blue-50 group-hover:ring-blue-100">
                        <i data-lucide="book-open-check" class="h-5 w-5"></i>
                    </div>
                    <i data-lucide="arrow-up-right" class="h-4 w-4 text-slate-300 transition group-hover:text-blue-600"></i>
                </div>
                <h3 class="mt-4 text-sm font-bold text-slate-950">Kelola Kursus</h3>
                <p class="mt-1 text-xs leading-5 text-slate-500">Atur program, level, harga, dan kapasitas kelas.</p>
            </a>
            <a href="/admin/payments" class="group rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-blue-300 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 text-blue-600 ring-1 ring-slate-200 transition group-hover:bg-blue-50 group-hover:ring-blue-100">
                        <i data-lucide="credit-card" class="h-5 w-5"></i>
                    </div>
                    <i data-lucide="arrow-up-right" class="h-4 w-4 text-slate-300 transition group-hover:text-blue-600"></i>
                </div>
                <h3 class="mt-4 text-sm font-bold text-slate-950">Pembayaran</h3>
                <p class="mt-1 text-xs leading-5 text-slate-500">Validasi bukti bayar dan pantau invoice siswa.</p>
            </a>
            <a href="/admin/tutors" class="group rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-blue-300 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 text-blue-600 ring-1 ring-slate-200 transition group-hover:bg-blue-50 group-hover:ring-blue-100">
                        <i data-lucide="user-check" class="h-5 w-5"></i>
                    </div>
                    <i data-lucide="arrow-up-right" class="h-4 w-4 text-slate-300 transition group-hover:text-blue-600"></i>
                </div>
                <h3 class="mt-4 text-sm font-bold text-slate-950">Kelola Tutor</h3>
                <p class="mt-1 text-xs leading-5 text-slate-500">Kelola profil, spesialisasi, dan beban mengajar.</p>
            </a>
            <a href="/admin/schedules" class="group rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-blue-300 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 text-blue-600 ring-1 ring-slate-200 transition group-hover:bg-blue-50 group-hover:ring-blue-100">
                        <i data-lucide="calendar-clock" class="h-5 w-5"></i>
                    </div>
                    <i data-lucide="arrow-up-right" class="h-4 w-4 text-slate-300 transition group-hover:text-blue-600"></i>
                </div>
                <h3 class="mt-4 text-sm font-bold text-slate-950">Jadwal Kelas</h3>
                <p class="mt-1 text-xs leading-5 text-slate-500">Susun jadwal tutor, ruangan, dan mode belajar.</p>
            </a>
            <a href="/admin/students" class="group rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-blue-300 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 text-blue-600 ring-1 ring-slate-200 transition group-hover:bg-blue-50 group-hover:ring-blue-100">
                        <i data-lucide="users-round" class="h-5 w-5"></i>
                    </div>
                    <i data-lucide="arrow-up-right" class="h-4 w-4 text-slate-300 transition group-hover:text-blue-600"></i>
                </div>
                <h3 class="mt-4 text-sm font-bold text-slate-950">Data Siswa</h3>
                <p class="mt-1 text-xs leading-5 text-slate-500">Lihat status belajar, pembayaran, dan progres siswa.</p>
            </a>
        </div>
    </section>

    <section class="grid gap-5 xl:grid-cols-12">
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm xl:col-span-7">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h2 class="text-base font-bold text-slate-950">Ringkasan Pendaftaran</h2>
                    <p class="mt-1 text-sm text-slate-500">Jumlah pendaftaran siswa baru per bulan.</p>
                </div>
                <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 ring-1 ring-blue-100">Jan - Jun 2026</span>
            </div>
            <div id="registration-chart" class="mt-6 h-72 rounded-xl border border-slate-200 bg-white p-3"></div>
        </article>

        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm xl:col-span-5">
            <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-4">
                <div>
                    <h2 class="text-base font-bold text-slate-950">Aktivitas Terbaru</h2>
                    <p class="mt-1 text-sm text-slate-500">Log operasional hari ini.</p>
                </div>
                <i data-lucide="activity" class="h-5 w-5 text-blue-600"></i>
            </div>
            <div id="activity-list" class="mt-2 divide-y divide-slate-100"></div>
        </article>
    </section>

    <section class="grid gap-5 xl:grid-cols-12">
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm xl:col-span-7">
            <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-4">
                <div>
                    <h2 class="text-base font-bold text-slate-950">Pendaftaran Terbaru</h2>
                    <p class="mt-1 text-sm text-slate-500">Siswa yang baru masuk ke sistem Brainy.</p>
                </div>
            </div>
            <div id="recent-registrations-list" class="mt-2 divide-y divide-slate-100"></div>
        </article>

        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm xl:col-span-5">
            <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-4">
                <div>
                    <h2 class="text-base font-bold text-slate-950">Pembayaran Pending</h2>
                    <p class="mt-1 text-sm text-slate-500">Validasi pembayaran yang masih menunggu admin.</p>
                </div>
                <span id="badge-pembayaran-card" class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700 ring-1 ring-amber-100">0 Pending</span>
            </div>
            <div id="pending-payments-list" class="mt-2 divide-y divide-slate-100"></div>
        </article>
    </section>
@endsection

@section('scripts')
    <script>
        const REVENUE_SERIES = {
            'Minggu Ini': {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                values: [3.8, 4.2, 5.1, 6.4, 5.8, 7.1, 8.3],
                total: 40700000
            },
            'Bulan Ini': {
                labels: ['1', '5', '10', '15', '20', '25', '30'],
                values: [4.2, 8.7, 13.9, 21.4, 29.8, 37.6, 45.2],
                total: 45200000
            },
            'Tahun Ini': {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                values: [31.4, 34.8, 38.5, 41.2, 43.1, 45.2],
                total: 234200000
            }
        };

        const REGISTRATION_DATA = [
            { label: 'Jan', value: 31 },
            { label: 'Feb', value: 37 },
            { label: 'Mar', value: 42 },
            { label: 'Apr', value: 48 },
            { label: 'Mei', value: 55 },
            { label: 'Jun', value: 61 }
        ];

        const ACTIVITIES = [
            { text: 'Pembayaran diterima dari Ahmad', time: '10 menit lalu' },
            { text: 'Tutor Bahasa Inggris ditambahkan', time: '35 menit lalu' },
            { text: 'Kelas Jepang N5 dibuat', time: '1 jam lalu' },
            { text: 'Siswa baru mendaftar', time: '2 jam lalu' }
        ];

        document.getElementById('current-date').innerText = new Date().toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        function formatRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(value);
        }

        function loadDashboard() {
            const totalSiswa = localStorage.getItem('brainy_total_siswa') || '248';
            const pendapatan = parseInt(localStorage.getItem('brainy_pendapatan') || '45200000');
            const waitingList = JSON.parse(localStorage.getItem('brainy_waiting_list') || '[]');
            const pendingPayments = JSON.parse(localStorage.getItem('brainy_pending_payments') || '[]');
            const recentStudents = JSON.parse(localStorage.getItem('brainy_recent_students') || '[]');

            document.getElementById('stat-total-siswa').innerText = totalSiswa;
            document.getElementById('stat-waiting-list').innerText = waitingList.length || 5;
            document.getElementById('revenue-value').innerText = formatRupiah(pendapatan);
            document.getElementById('badge-pembayaran-card').innerText = `${pendingPayments.length} Pending`;

            renderRevenueChart(document.getElementById('revenue-period').value);
            renderRegistrationChart();
            renderActivities();
            renderRecentStudents(recentStudents);
            renderPendingPayments(pendingPayments);

            lucide.createIcons();
            syncSidebarBadges();
        }

        function renderRevenueChart(period) {
            const data = REVENUE_SERIES[period] || REVENUE_SERIES['Bulan Ini'];
            const chart = document.getElementById('revenue-chart');
            const width = 620;
            const height = 230;
            const pad = { top: 18, right: 22, bottom: 42, left: 44 };
            const max = Math.max(...data.values) * 1.15;
            const points = data.values.map((value, index) => {
                const x = pad.left + (index / (data.values.length - 1)) * (width - pad.left - pad.right);
                const y = height - pad.bottom - (value / max) * (height - pad.top - pad.bottom);
                return { x, y, value, label: data.labels[index] };
            });
            const line = points.map((p, i) => `${i === 0 ? 'M' : 'L'} ${p.x.toFixed(1)} ${p.y.toFixed(1)}`).join(' ');
            const area = `${line} L ${points.at(-1).x.toFixed(1)} ${height - pad.bottom} L ${points[0].x.toFixed(1)} ${height - pad.bottom} Z`;
            const grid = [0, 0.25, 0.5, 0.75, 1].map(step => {
                const y = height - pad.bottom - step * (height - pad.top - pad.bottom);
                const label = Math.round(max * step);
                return `<line x1="${pad.left}" y1="${y}" x2="${width - pad.right}" y2="${y}" stroke="#E2E8F0" stroke-width="1"/><text x="8" y="${y + 4}" fill="#64748B" font-size="11">${label}</text>`;
            }).join('');
            const xLabels = points.map(p => `<text x="${p.x}" y="${height - 14}" fill="#64748B" font-size="11" text-anchor="middle">${p.label}</text>`).join('');
            const dots = points.map(p => `
                <g class="group">
                    <circle cx="${p.x}" cy="${p.y}" r="12" fill="transparent"></circle>
                    <circle cx="${p.x}" cy="${p.y}" r="4" fill="#2563EB" stroke="#FFFFFF" stroke-width="2"></circle>
                    <g class="pointer-events-none opacity-0 transition-opacity group-hover:opacity-100">
                        <rect x="${Math.min(p.x - 58, width - 124)}" y="${Math.max(p.y - 48, 6)}" width="116" height="34" rx="8" fill="#0F172A"></rect>
                        <text x="${Math.min(p.x, width - 66)}" y="${Math.max(p.y - 27, 27)}" fill="#FFFFFF" font-size="11" font-weight="700" text-anchor="middle">${p.label}: Rp ${p.value.toFixed(1)} jt</text>
                    </g>
                </g>
            `).join('');

            chart.innerHTML = `
                <svg viewBox="0 0 ${width} ${height}" class="h-full w-full" role="img" aria-label="Grafik pendapatan ${period}">
                    ${grid}
                    <path d="${area}" fill="#DBEAFE"></path>
                    <path d="${line}" fill="none" stroke="#2563EB" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path>
                    ${dots}
                    ${xLabels}
                </svg>
            `;
        }

        function renderRegistrationChart() {
            const chart = document.getElementById('registration-chart');
            const width = 680;
            const height = 260;
            const pad = { top: 18, right: 22, bottom: 40, left: 42 };
            const max = Math.max(...REGISTRATION_DATA.map(item => item.value)) * 1.2;
            const barArea = width - pad.left - pad.right;
            const barWidth = Math.min(54, barArea / REGISTRATION_DATA.length - 22);
            const grid = [0, 0.25, 0.5, 0.75, 1].map(step => {
                const y = height - pad.bottom - step * (height - pad.top - pad.bottom);
                return `<line x1="${pad.left}" y1="${y}" x2="${width - pad.right}" y2="${y}" stroke="#E2E8F0" stroke-width="1"/>`;
            }).join('');
            const bars = REGISTRATION_DATA.map((item, index) => {
                const x = pad.left + (index + 0.5) * (barArea / REGISTRATION_DATA.length) - barWidth / 2;
                const barHeight = (item.value / max) * (height - pad.top - pad.bottom);
                const y = height - pad.bottom - barHeight;
                return `
                    <g class="group">
                        <rect x="${x}" y="${y}" width="${barWidth}" height="${barHeight}" rx="8" fill="#2563EB"></rect>
                        <text x="${x + barWidth / 2}" y="${y - 9}" fill="#0F172A" font-size="12" font-weight="700" text-anchor="middle">${item.value}</text>
                        <text x="${x + barWidth / 2}" y="${height - 14}" fill="#64748B" font-size="12" font-weight="600" text-anchor="middle">${item.label}</text>
                        <g class="pointer-events-none opacity-0 transition-opacity group-hover:opacity-100">
                            <rect x="${x - 20}" y="${Math.max(y - 47, 4)}" width="${barWidth + 40}" height="32" rx="8" fill="#0F172A"></rect>
                            <text x="${x + barWidth / 2}" y="${Math.max(y - 27, 25)}" fill="#FFFFFF" font-size="11" font-weight="700" text-anchor="middle">${item.value} siswa baru</text>
                        </g>
                    </g>
                `;
            }).join('');

            chart.innerHTML = `
                <svg viewBox="0 0 ${width} ${height}" class="h-full w-full" role="img" aria-label="Grafik pendaftaran siswa baru">
                    ${grid}
                    ${bars}
                </svg>
            `;
        }

        function renderActivities() {
            const container = document.getElementById('activity-list');
            container.innerHTML = ACTIVITIES.map(activity => `
                <div class="flex items-start gap-3 py-4">
                    <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 ring-1 ring-emerald-100">
                        <i data-lucide="check" class="h-3.5 w-3.5"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-slate-900">${activity.text}</p>
                        <p class="mt-1 text-xs font-medium text-slate-500">${activity.time}</p>
                    </div>
                </div>
            `).join('');
        }

        function renderRecentStudents(recentStudents) {
            const container = document.getElementById('recent-registrations-list');
            container.innerHTML = '';

            if (!recentStudents.length) {
                container.innerHTML = '<div class="py-10 text-center text-sm font-semibold text-slate-400">Belum ada pendaftaran terbaru.</div>';
                return;
            }

            recentStudents.slice(0, 5).forEach(student => {
                const item = document.createElement('div');
                item.className = 'flex items-center gap-3 py-4';
                item.innerHTML = `
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-xs font-bold ${student.color}">
                        ${student.avatar}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-bold text-slate-950">${student.name}</p>
                        <p class="mt-1 truncate text-xs font-medium text-slate-500">${student.course}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-semibold text-slate-500">${student.date}</p>
                        <span class="mt-1 inline-flex rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-bold text-emerald-700 ring-1 ring-emerald-100">Aktif</span>
                    </div>
                `;
                container.appendChild(item);
            });
        }

        function renderPendingPayments(pendingPayments) {
            const container = document.getElementById('pending-payments-list');
            container.innerHTML = '';

            if (pendingPayments.length === 0) {
                container.innerHTML = `
                    <div class="py-10 text-center">
                        <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 ring-1 ring-emerald-100">
                            <i data-lucide="check" class="h-5 w-5"></i>
                        </div>
                        <p class="mt-3 text-sm font-semibold text-slate-500">Semua pembayaran sudah divalidasi.</p>
                    </div>
                `;
                return;
            }

            pendingPayments.forEach(payment => {
                const item = document.createElement('div');
                item.className = 'flex items-center gap-4 py-4';
                item.innerHTML = `
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-bold text-slate-950">${payment.name}</p>
                        <p class="mt-1 truncate text-xs font-medium text-slate-500">${payment.course}</p>
                        <p class="mt-2 text-sm font-bold text-blue-600">${payment.amount}</p>
                    </div>
                    <button onclick="confirmPayment(${payment.id})" class="inline-flex h-9 shrink-0 items-center justify-center rounded-xl bg-blue-600 px-4 text-xs font-bold text-white transition hover:bg-blue-700 active:scale-[0.98]">
                        Konfirmasi
                    </button>
                `;
                container.appendChild(item);
            });
        }

        function confirmPayment(paymentId) {
            const pendingPayments = JSON.parse(localStorage.getItem('brainy_pending_payments') || '[]');
            const payment = pendingPayments.find(item => item.id === paymentId);
            if (!payment) return;

            localStorage.setItem('brainy_pending_payments', JSON.stringify(pendingPayments.filter(item => item.id !== paymentId)));

            const initials = payment.name.split(' ').map(name => name[0]).join('').substring(0, 2).toUpperCase();
            const newRecent = {
                id: Date.now(),
                name: payment.name,
                course: payment.course,
                date: 'Hari Ini',
                avatar: initials,
                color: 'bg-blue-50 text-blue-600 border border-blue-100/50'
            };

            const recentStudents = JSON.parse(localStorage.getItem('brainy_recent_students') || '[]');
            recentStudents.unshift(newRecent);
            localStorage.setItem('brainy_recent_students', JSON.stringify(recentStudents.slice(0, 5)));

            const totalSiswa = parseInt(localStorage.getItem('brainy_total_siswa') || '248') + 1;
            const pendapatan = parseInt(localStorage.getItem('brainy_pendapatan') || '45200000') + payment.rawAmount;

            localStorage.setItem('brainy_total_siswa', totalSiswa.toString());
            localStorage.setItem('brainy_pendapatan', pendapatan.toString());

            const students = JSON.parse(localStorage.getItem('brainy_students') || '[]');
            students.unshift({
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
                color: newRecent.color
            });
            localStorage.setItem('brainy_students', JSON.stringify(students));

            showToast(`Pembayaran ${payment.name} (${payment.amount}) berhasil dikonfirmasi!`, 'success');
            loadDashboard();
        }

        document.getElementById('revenue-period').addEventListener('change', event => {
            const selected = event.target.value;
            document.getElementById('revenue-value').innerText = formatRupiah(REVENUE_SERIES[selected].total);
            renderRevenueChart(selected);
        });

        document.addEventListener('DOMContentLoaded', loadDashboard);
    </script>
@endsection
