@extends('layouts.admin')

@section('title', 'Brainy Admin - Pembayaran')
@section('page_title', 'Manajemen Pembayaran')
@section('page_description', 'Monitor dan kelola transaksi pembayaran siswa.')

@php
    $activeTab = 'payments';
@endphp

@section('content')
    <section class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-600 to-green-800 p-6 sm:p-8 text-white shadow-sm">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight">Manajemen Pembayaran</h2>
            <p class="mt-2 text-sm font-medium text-emerald-50/90">Monitor dan kelola transaksi pembayaran.</p>
        </div>
    </section>

    <section class="grid gap-5 md:grid-cols-3">
        <article class="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total Pembayaran Bulan Ini</p>
            <p id="metric-total-payments" class="mt-3 text-3xl font-extrabold text-emerald-600">Rp 0</p>
        </article>
        <article class="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Pending</p>
            <p id="metric-pending-payments" class="mt-3 text-3xl font-extrabold text-orange-600">Rp 0</p>
        </article>
        <article class="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Terkonfirmasi</p>
            <p id="metric-confirmed-payments" class="mt-3 text-3xl font-extrabold text-blue-600">Rp 0</p>
        </article>
    </section>

    <section class="rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm">
        <div class="flex flex-col gap-4 border-b border-slate-100 pb-5 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h2 class="text-sm font-bold text-slate-900">Daftar Pembayaran</h2>
                <p class="mt-1 text-sm text-slate-500">Semua transaksi pembayaran siswa.</p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <div class="relative sm:w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i data-lucide="search" class="h-4 w-4"></i>
                    </span>
                    <input id="search-input" type="text" oninput="handleSearch(this.value)" placeholder="Cari siswa, kursus..." class="h-9 w-full rounded-xl border border-slate-200 bg-white pl-9 pr-4 text-xs font-medium outline-none transition focus:border-blue-500">
                </div>

                <div class="flex items-center gap-1.5 rounded-xl border border-slate-200/60 bg-slate-50 p-1">
                    <button onclick="setStatusFilter('All')" id="btn-status-All" class="rounded-lg bg-white px-3 py-1.5 text-xs font-bold text-blue-600 shadow-sm">All</button>
                    <button onclick="setStatusFilter('Terbayar')" id="btn-status-Terbayar" class="rounded-lg px-3 py-1.5 text-xs font-bold text-slate-500 hover:text-slate-900">Terbayar</button>
                    <button onclick="setStatusFilter('Pending')" id="btn-status-Pending" class="rounded-lg px-3 py-1.5 text-xs font-bold text-slate-500 hover:text-slate-900">Pending</button>
                    <button onclick="setStatusFilter('Ditolak')" id="btn-status-Ditolak" class="rounded-lg px-3 py-1.5 text-xs font-bold text-slate-500 hover:text-slate-900">Ditolak</button>
                </div>
            </div>
        </div>

        <div class="mt-5 overflow-x-auto">
            <table class="min-w-full text-left">
                <thead>
                    <tr class="border-b border-slate-200 text-xs font-bold text-slate-900">
                        <th class="whitespace-nowrap px-2 py-3">Tanggal</th>
                        <th class="whitespace-nowrap px-2 py-3">Siswa</th>
                        <th class="whitespace-nowrap px-2 py-3">Kursus</th>
                        <th class="whitespace-nowrap px-2 py-3">Metode</th>
                        <th class="whitespace-nowrap px-2 py-3">Jumlah</th>
                        <th class="whitespace-nowrap px-2 py-3">Status</th>
                        <th class="whitespace-nowrap px-2 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="payments-table-body" class="divide-y divide-slate-100">
                    <!-- Dynamic rendering via JS -->
                </tbody>
            </table>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        const DEFAULT_CONFIRMED_PAYMENTS = [
            { id: 1, date: '15/5/2026', name: 'Andi Wijaya', course: 'English Intermediate', method: 'Transfer Bank', amount: 1800000, status: 'Terbayar' },
            { id: 2, date: '18/5/2026', name: 'Siti Rahmawati', course: 'Japanese for Beginners', method: 'Kartu Kredit', amount: 2000000, status: 'Terbayar' },
            { id: 3, date: '20/5/2026', name: 'Nadia Putri', course: 'Korean for Beginners', method: 'Transfer Bank', amount: 2000000, status: 'Terbayar' },
            { id: 4, date: '21/5/2026', name: 'Rafi Hidayat', course: 'English Advanced', method: 'E-Wallet', amount: 2100000, status: 'Terbayar' }
        ];

        let currentStatusFilter = 'All';
        let currentSearchQuery = '';

        function formatRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(value).replace('IDR', 'Rp');
        }

        function normalizePendingPayments() {
            const pendingPayments = JSON.parse(localStorage.getItem('brainy_pending_payments') || '[]');
            return pendingPayments.map(payment => ({
                id: payment.id,
                date: payment.date || '22/5/2026',
                name: payment.name,
                course: payment.course,
                method: payment.method || 'Transfer Bank',
                amount: payment.rawAmount || parseInt(String(payment.amount).replace(/\D/g, '')) || 0,
                status: 'Pending'
            }));
        }

        function ensurePaymentData() {
            if (!localStorage.getItem('brainy_payments')) {
                localStorage.setItem('brainy_payments', JSON.stringify(DEFAULT_CONFIRMED_PAYMENTS));
            }
        }

        function getAllPayments() {
            ensurePaymentData();
            const saved = JSON.parse(localStorage.getItem('brainy_payments') || '[]');
            const pending = normalizePendingPayments();
            const pendingIds = pending.map(payment => payment.id);
            return [...saved.filter(payment => !pendingIds.includes(payment.id)), ...pending]
                .sort((a, b) => b.id - a.id);
        }

        function statusBadgeClass(status) {
            if (status === 'Terbayar') return 'bg-emerald-50 text-emerald-700 border-emerald-200';
            if (status === 'Pending') return 'bg-orange-50 text-orange-700 border-orange-200';
            return 'bg-rose-50 text-rose-700 border-rose-200';
        }

        function renderPayments() {
            const payments = getAllPayments();
            const query = currentSearchQuery.toLowerCase();
            const filtered = payments.filter(payment => {
                const matchesSearch = payment.name.toLowerCase().includes(query) ||
                    payment.course.toLowerCase().includes(query) ||
                    payment.method.toLowerCase().includes(query);
                const matchesStatus = currentStatusFilter === 'All' || payment.status === currentStatusFilter;
                return matchesSearch && matchesStatus;
            });

            const total = payments.reduce((sum, payment) => sum + payment.amount, 0);
            const pending = payments.filter(payment => payment.status === 'Pending').reduce((sum, payment) => sum + payment.amount, 0);
            const confirmed = payments.filter(payment => payment.status === 'Terbayar').reduce((sum, payment) => sum + payment.amount, 0);

            document.getElementById('metric-total-payments').innerText = formatRupiah(total);
            document.getElementById('metric-pending-payments').innerText = formatRupiah(pending);
            document.getElementById('metric-confirmed-payments').innerText = formatRupiah(confirmed);

            const body = document.getElementById('payments-table-body');
            body.innerHTML = '';

            if (filtered.length === 0) {
                body.innerHTML = `
                    <tr>
                        <td colspan="7" class="px-2 py-14 text-center text-slate-400">
                            <i data-lucide="wallet-cards" class="mx-auto mb-3 h-9 w-9 text-slate-300"></i>
                            <p class="text-xs font-semibold">Tidak ada transaksi yang sesuai filter.</p>
                        </td>
                    </tr>
                `;
                lucide.createIcons();
                return;
            }

            filtered.forEach(payment => {
                const actionHtml = payment.status === 'Pending'
                    ? `
                        <div class="flex justify-end gap-2">
                            <button onclick="confirmAdminPayment(${payment.id})" class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-emerald-600 transition hover:bg-emerald-50 hover:border-emerald-100 active:scale-[0.97] cursor-pointer" title="Konfirmasi pembayaran">
                                <i data-lucide="check-circle-2" class="h-4 w-4"></i>
                            </button>
                            <button onclick="rejectAdminPayment(${payment.id})" class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-rose-600 transition hover:bg-rose-50 hover:border-rose-100 active:scale-[0.97] cursor-pointer" title="Tolak pembayaran">
                                <i data-lucide="x-circle" class="h-4 w-4"></i>
                            </button>
                        </div>
                    `
                    : '<span class="text-sm font-medium text-slate-500">Terkonfirmasi</span>';

                const row = document.createElement('tr');
                row.className = 'text-sm transition hover:bg-slate-50/60';
                row.innerHTML = `
                    <td class="whitespace-nowrap px-2 py-4 text-slate-900">${payment.date}</td>
                    <td class="whitespace-nowrap px-2 py-4 font-bold text-slate-900">${payment.name}</td>
                    <td class="min-w-56 px-2 py-4 text-slate-900">${payment.course}</td>
                    <td class="px-2 py-4">
                        <span class="inline-flex rounded-lg border border-slate-200 bg-white px-2.5 py-1 text-[11px] font-bold text-slate-900">${payment.method}</span>
                    </td>
                    <td class="whitespace-nowrap px-2 py-4 font-bold text-slate-900">${formatRupiah(payment.amount)}</td>
                    <td class="px-2 py-4">
                        <span class="inline-flex rounded-lg border px-2.5 py-1 text-[11px] font-bold ${statusBadgeClass(payment.status)}">${payment.status}</span>
                    </td>
                    <td class="px-2 py-4 text-right">${actionHtml}</td>
                `;
                body.appendChild(row);
            });

            lucide.createIcons();
            syncSidebarBadges();
        }

        function setStatusFilter(status) {
            currentStatusFilter = status;
            ['All', 'Terbayar', 'Pending', 'Ditolak'].forEach(item => {
                const btn = document.getElementById(`btn-status-${item}`);
                btn.className = item === status
                    ? 'rounded-lg bg-white px-3 py-1.5 text-xs font-bold text-blue-600 shadow-sm'
                    : 'rounded-lg px-3 py-1.5 text-xs font-bold text-slate-500 hover:text-slate-900';
            });
            renderPayments();
        }

        function handleSearch(query) {
            currentSearchQuery = query;
            renderPayments();
        }

        window.onLocalSearch = function(query) {
            document.getElementById('search-input').value = query;
            handleSearch(query);
        };

        function confirmAdminPayment(paymentId) {
            const pendingPayments = JSON.parse(localStorage.getItem('brainy_pending_payments') || '[]');
            const pending = pendingPayments.find(payment => payment.id === paymentId);
            if (!pending) return;

            const saved = JSON.parse(localStorage.getItem('brainy_payments') || '[]');
            saved.unshift({
                id: pending.id,
                date: new Date().toLocaleDateString('id-ID'),
                name: pending.name,
                course: pending.course,
                method: pending.method || 'Transfer Bank',
                amount: pending.rawAmount || parseInt(String(pending.amount).replace(/\D/g, '')) || 0,
                status: 'Terbayar'
            });

            localStorage.setItem('brainy_payments', JSON.stringify(saved));
            localStorage.setItem('brainy_pending_payments', JSON.stringify(pendingPayments.filter(payment => payment.id !== paymentId)));
            showToast(`Pembayaran ${pending.name} berhasil dikonfirmasi.`, 'success');
            renderPayments();
        }

        function rejectAdminPayment(paymentId) {
            const pendingPayments = JSON.parse(localStorage.getItem('brainy_pending_payments') || '[]');
            const pending = pendingPayments.find(payment => payment.id === paymentId);
            if (!pending) return;

            const saved = JSON.parse(localStorage.getItem('brainy_payments') || '[]');
            saved.unshift({
                id: Date.now(),
                date: new Date().toLocaleDateString('id-ID'),
                name: pending.name,
                course: pending.course,
                method: pending.method || 'Transfer Bank',
                amount: pending.rawAmount || parseInt(String(pending.amount).replace(/\D/g, '')) || 0,
                status: 'Ditolak'
            });

            localStorage.setItem('brainy_payments', JSON.stringify(saved));
            localStorage.setItem('brainy_pending_payments', JSON.stringify(pendingPayments.filter(payment => payment.id !== paymentId)));
            showToast(`Pembayaran ${pending.name} ditandai ditolak.`, 'info');
            renderPayments();
        }

        document.addEventListener('DOMContentLoaded', () => {
            renderPayments();
        });
    </script>
@endsection
