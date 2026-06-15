@php
    $metrics = [
        ['label' => 'Total Siswa', 'value' => '248', 'note' => '+12', 'tone' => 'text-blue-600 bg-blue-50', 'icon' => 'users'],
        ['label' => 'Kelas Aktif', 'value' => '12', 'note' => '7 bahasa', 'tone' => 'text-purple-600 bg-purple-50', 'icon' => 'mortar'],
        ['label' => 'Pendapatan', 'value' => 'Rp 45.2M', 'note' => '+18%', 'tone' => 'text-emerald-600 bg-emerald-50', 'icon' => 'money'],
        ['label' => 'Waiting List', 'value' => '5', 'note' => 'Tindak lanjut', 'tone' => 'text-orange-600 bg-orange-50', 'icon' => 'clipboard'],
    ];

    $quickMenus = [
        ['label' => 'Kelola Kursus', 'desc' => 'Tambah, edit, dan hapus kurikulum bahasa.', 'icon' => 'mortar'],
        ['label' => 'Pembayaran', 'desc' => 'Verifikasi dan pantau mutasi invoice pendaftaran.', 'icon' => 'money'],
        ['label' => 'Waiting List', 'desc' => 'Kelola alokasi kelas pendaftaran penuh.', 'icon' => 'clipboard'],
        ['label' => 'Kelola Tutor', 'desc' => 'Atur penugasan dan ketersediaan mengajar.', 'icon' => 'users'],
        ['label' => 'Jadwal Kelas', 'desc' => 'Atur pemetaan ruangan dan waktu belajar.', 'icon' => 'calendar'],
        ['label' => 'Forum Diskusi', 'desc' => 'Pantau topik Brainy, keluhan, dan pembelajaran.', 'icon' => 'chat', 'href' => '#forum-diskusi'],
    ];

    $registrations = [
        ['name' => 'Ahmad Fauzi', 'course' => 'English Beginner', 'date' => '22 Mei 2026', 'initial' => 'AF'],
        ['name' => 'Siti Nurhaliza', 'course' => 'Japanese Intermediate', 'date' => '21 Mei 2026', 'initial' => 'SN'],
        ['name' => 'Budi Hartono', 'course' => 'Korean Beginner', 'date' => '20 Mei 2026', 'initial' => 'BH'],
        ['name' => 'Dewi Putri', 'course' => 'English Advanced', 'date' => '19 Mei 2026', 'initial' => 'DP'],
    ];

    $payments = [
        ['name' => 'Budi Santoso', 'course' => 'Japanese Intermediate', 'amount' => 'Rp 2.300.000'],
        ['name' => 'Lisa Wijaya', 'course' => 'English Intermediate', 'amount' => 'Rp 1.800.000'],
        ['name' => 'Agus Susanto', 'course' => 'Korean Beginner', 'amount' => 'Rp 2.000.000'],
    ];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Brainy</title>
    @include('layouts.vite')
</head>
<body class="bg-gray-50 font-sans text-gray-950">
    @include('layouts.header')

    <main>
        <section class="mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8">
            <div class="rounded-lg border border-gray-200 bg-white p-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-blue-600">Laporan Lembaga</p>
                        <h1 class="mt-2 text-2xl font-bold">Selamat Datang Kembali, Admin!</h1>
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600">Kelola pendaftaran siswa, verifikasi pembayaran tertunda, dan pantau operasional kelas bahasa secara terpusat.</p>
                    </div>
                    <span class="inline-flex h-11 w-fit items-center gap-2 rounded-md border border-gray-200 bg-gray-50 px-4 text-sm font-semibold text-gray-700">
                        <x-dashboard-icon name="calendar" class="h-4 w-4 text-blue-600" />
                        Senin, 15 Juni 2026
                    </span>
                </div>
            </div>

            <div class="mt-5 grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($metrics as $metric)
                    <article class="rounded-lg border border-gray-200 bg-white p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-bold uppercase text-gray-500">{{ $metric['label'] }}</p>
                                <p class="mt-2 text-2xl font-bold">{{ $metric['value'] }}</p>
                            </div>
                            <span class="flex h-10 w-10 items-center justify-center rounded-lg {{ $metric['tone'] }}">
                                <x-dashboard-icon :name="$metric['icon']" class="h-5 w-5" />
                            </span>
                        </div>
                        <span class="mt-5 inline-flex rounded bg-gray-50 px-2 py-1 text-xs font-bold text-emerald-600">{{ $metric['note'] }}</span>
                    </article>
                @endforeach
            </div>

            <section class="mt-7">
                <h2 class="text-lg font-bold">Menu Administrasi Cepat</h2>
                <div class="mt-4 grid gap-4 lg:grid-cols-3">
                    @foreach ($quickMenus as $menu)
                        <a href="{{ $menu['href'] ?? '#' }}" class="flex min-h-28 items-center justify-between rounded-lg border border-gray-200 bg-white p-5 transition hover:border-blue-300 hover:shadow-sm">
                            <div class="flex items-start gap-4">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-50 text-gray-600">
                                    <x-dashboard-icon :name="$menu['icon']" class="h-5 w-5" />
                                </span>
                                <div>
                                    <h3 class="text-sm font-bold">{{ $menu['label'] }}</h3>
                                    <p class="mt-1 text-sm leading-5 text-gray-600">{{ $menu['desc'] }}</p>
                                </div>
                            </div>
                            <span class="text-gray-300">›</span>
                        </a>
                    @endforeach
                </div>
            </section>

            <div class="mt-7 grid gap-5 lg:grid-cols-[minmax(0,1.2fr)_minmax(320px,0.8fr)]">
                <section class="rounded-lg border border-gray-200 bg-white p-5">
                    <h2 class="font-bold">Pendaftaran Terbaru</h2>
                    <p class="mt-1 text-sm text-gray-600">Daftar pendaftaran siswa paling mutakhir.</p>
                    <div class="mt-5 divide-y divide-gray-100">
                        @foreach ($registrations as $student)
                            <article class="flex items-center justify-between gap-4 py-4 first:pt-0 last:pb-0">
                                <div class="flex items-center gap-4">
                                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-sm font-bold text-blue-600">{{ $student['initial'] }}</span>
                                    <div>
                                        <h3 class="text-sm font-bold">{{ $student['name'] }}</h3>
                                        <p class="text-sm text-gray-600">{{ $student['course'] }}</p>
                                    </div>
                                </div>
                                <div class="text-right text-xs">
                                    <p class="font-semibold text-gray-500">{{ $student['date'] }}</p>
                                    <span class="mt-1 inline-flex rounded bg-emerald-50 px-2 py-1 font-bold text-emerald-600">Aktif</span>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>

                <section class="rounded-lg border border-gray-200 bg-white p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="font-bold">Pembayaran Pending</h2>
                            <p class="mt-1 text-sm text-gray-600">Validasi struk transaksi pendaftaran.</p>
                        </div>
                        <span class="rounded bg-orange-50 px-2 py-1 text-xs font-bold text-orange-600">3 Pending</span>
                    </div>
                    <div class="mt-5 space-y-4">
                        @foreach ($payments as $payment)
                            <article class="flex items-center justify-between gap-4">
                                <div>
                                    <h3 class="text-sm font-bold">{{ $payment['name'] }}</h3>
                                    <p class="text-xs text-gray-600">{{ $payment['course'] }}</p>
                                    <p class="mt-1 text-sm font-bold text-blue-600">{{ $payment['amount'] }}</p>
                                </div>
                                <button type="button" class="h-9 rounded-md bg-blue-600 px-4 text-sm font-semibold text-white transition hover:bg-blue-700">Konfirmasi</button>
                            </article>
                        @endforeach
                    </div>
                </section>
            </div>
        </section>

        @include('components.forum-discussion')
    </main>
</body>
</html>
