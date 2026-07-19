<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Midtrans - Brainy Course</title>
    @include('layouts.vite')
    <script src="{{ $snapUrl }}" data-client-key="{{ $clientKey }}"></script>
</head>
<body class="min-h-screen bg-[#eef4ff] text-slate-950">
    <div class="pointer-events-none fixed inset-0 overflow-hidden" aria-hidden="true">
        <div class="absolute -right-24 -top-24 h-96 w-96 rounded-full bg-blue-300/30 blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 h-80 w-80 rounded-full bg-amber-200/35 blur-3xl"></div>
    </div>

    <main class="relative mx-auto grid min-h-screen max-w-6xl items-center gap-8 px-5 py-10 lg:grid-cols-[1fr_0.82fr]">
        <section class="overflow-hidden rounded-[2rem] border border-blue-900/10 bg-[#092a67] text-white shadow-2xl shadow-blue-950/20">
            <div class="relative p-7 sm:p-10">
                <div class="absolute right-0 top-0 h-36 w-36 translate-x-10 -translate-y-10 rounded-full border-[28px] border-white/5"></div>
                <p class="text-xs font-black uppercase tracking-[0.28em] text-blue-200">Checkout aman · Midtrans</p>
                <h1 class="mt-4 max-w-xl text-3xl font-black tracking-tight sm:text-5xl">Satu langkah sebelum kelas dimulai.</h1>
                <p class="mt-4 max-w-xl leading-7 text-blue-100">Pembayaran diverifikasi otomatis dari server Midtrans. Akun aktif setelah pembayaran berhasil dan kursi tersedia.</p>

                <div class="mt-9 rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur">
                    <div class="flex flex-col justify-between gap-5 sm:flex-row">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-blue-200">Kelas pilihan</p>
                            <h2 class="mt-2 text-2xl font-black">{{ $registration->schedule->courseClass->name }}</h2>
                            <p class="mt-2 text-sm text-blue-100">{{ $registration->schedule->courseClass->language }} · {{ $registration->schedule->courseClass->level }}</p>
                            <p class="mt-1 text-sm text-blue-100">{{ $registration->schedule->day }}, {{ substr($registration->schedule->start_time, 0, 5) }}–{{ substr($registration->schedule->end_time, 0, 5) }} WIB</p>
                        </div>
                        <span class="h-fit rounded-full px-4 py-2 text-xs font-black uppercase tracking-wide {{ $registration->status === 'waiting_list' ? 'bg-amber-300 text-amber-950' : 'bg-emerald-300 text-emerald-950' }}">
                            {{ $registration->status === 'waiting_list' ? 'Waiting list' : 'Kursi direservasi' }}
                        </span>
                    </div>
                </div>

                @if ($registration->status === 'waiting_list')
                    <div class="mt-5 rounded-2xl border border-amber-300/40 bg-amber-300/10 p-5 text-sm leading-6 text-amber-50">
                        Jadwal penuh. Pembayaran tetap dapat dilakukan. Akun belum bisa login sampai admin mempromosikan antrean saat kursi tersedia.
                    </div>
                @endif
            </div>
        </section>

        <section class="rounded-[2rem] border border-slate-200 bg-white p-7 shadow-xl shadow-blue-950/10 sm:p-9">
            <div class="flex items-start justify-between gap-4">
                <div><p class="text-xs font-black uppercase tracking-[0.22em] text-blue-700">Ringkasan tagihan</p><h2 class="mt-2 text-2xl font-black">Pembayaran bulanan</h2></div>
                <span class="rounded-lg bg-slate-100 px-3 py-2 text-[11px] font-black text-slate-600">{{ $payment->type === 'renewal' ? 'PERPANJANGAN' : 'BULAN PERTAMA' }}</span>
            </div>

            <dl class="mt-8 space-y-4 text-sm">
                <div class="flex items-center justify-between"><dt class="text-slate-500">Subtotal {{ $registration->schedule->courseClass->level }}</dt><dd class="font-extrabold">Rp {{ number_format($payment->subtotal, 0, ',', '.') }}</dd></div>
                <div class="flex items-center justify-between"><dt class="text-slate-500">Biaya admin</dt><dd class="font-extrabold">Rp {{ number_format($payment->admin_fee, 0, ',', '.') }}</dd></div>
                <div class="border-t border-dashed border-slate-300 pt-5">
                    <div class="flex items-end justify-between gap-4"><dt class="font-bold text-slate-700">Total pembayaran</dt><dd class="text-3xl font-black tracking-tight text-blue-700">Rp {{ number_format($payment->amount, 0, ',', '.') }}</dd></div>
                </div>
            </dl>

            <div id="payment-message" class="mt-7 hidden rounded-xl px-4 py-3 text-sm font-bold" role="status"></div>

            @if ($payment->status === 'paid')
                <div class="mt-7 rounded-xl border border-emerald-200 bg-emerald-50 p-5 text-emerald-900">
                    <p class="font-black">Pembayaran berhasil</p>
                    <p class="mt-1 text-sm">Status Midtrans: {{ strtoupper($payment->midtrans_status ?? 'settlement') }}.</p>
                </div>
                @if ($registration->status === 'accepted')
                    <a href="{{ route('login') }}" class="mt-4 flex w-full justify-center rounded-xl bg-blue-700 px-6 py-4 font-black text-white hover:bg-blue-800">Masuk ke akun</a>
                @else
                    <p class="mt-4 rounded-xl bg-amber-50 p-4 text-sm font-bold text-amber-900">Pembayaran selesai. Posisi antrean menunggu promosi admin.</p>
                @endif
            @elseif (in_array($payment->status, ['failed', 'cancelled'], true) || $payment->isExpired())
                <div class="mt-7 rounded-xl border border-rose-200 bg-rose-50 p-5 text-rose-900"><p class="font-black">Transaksi tidak dapat dilanjutkan</p><p class="mt-1 text-sm">Buat order baru untuk mencoba pembayaran lagi.</p></div>
                <form action="{{ route('registration.payment.retry', [$registration, $payment]) }}" method="POST" class="mt-4">@csrf<button class="w-full rounded-xl bg-slate-950 px-6 py-4 font-black text-white">Buat transaksi baru</button></form>
            @else
                <button id="pay-button" type="button" class="mt-7 w-full rounded-xl bg-blue-700 px-6 py-4 font-black text-white shadow-lg shadow-blue-700/20 transition hover:-translate-y-0.5 hover:bg-blue-800 disabled:cursor-wait disabled:opacity-60">Bayar dengan Midtrans</button>
                <p class="mt-3 text-center text-xs leading-5 text-slate-500">Jangan tutup halaman sebelum jendela Midtrans terbuka. Status final berasal dari webhook, bukan browser.</p>
            @endif

            <div class="mt-7 border-t border-slate-100 pt-5 text-xs text-slate-500">
                <p class="font-bold text-slate-700">Order ID</p><p class="mt-1 break-all font-mono">{{ $payment->order_id }}</p>
            </div>
        </section>
    </main>

    @if ($payment->status === 'pending' && ! $payment->isExpired())
        <script>
            const payButton = document.getElementById('pay-button');
            const message = document.getElementById('payment-message');
            const showMessage = (text, type = 'info') => {
                message.textContent = text;
                message.className = `mt-7 rounded-xl px-4 py-3 text-sm font-bold ${type === 'error' ? 'bg-rose-50 text-rose-900' : 'bg-blue-50 text-blue-900'}`;
            };

            payButton?.addEventListener('click', async () => {
                payButton.disabled = true;
                payButton.textContent = 'Membuka Midtrans…';

                try {
                    const response = await fetch(@json(route('registration.payment.start', [$registration, $payment])), {
                        method: 'POST',
                        headers: {'X-CSRF-TOKEN': @json(csrf_token()), 'Accept': 'application/json'},
                    });
                    const data = await response.json();
                    if (!response.ok) throw new Error(data.message || 'Pembayaran gagal dibuka.');

                    window.snap.pay(data.token, {
                        onSuccess: () => showMessage('Pembayaran diterima. Menunggu sinkronisasi status Midtrans.'),
                        onPending: () => showMessage('Transaksi dibuat. Selesaikan pembayaran sesuai instruksi Midtrans.'),
                        onError: () => showMessage('Midtrans tidak dapat memproses transaksi.', 'error'),
                        onClose: () => showMessage('Jendela pembayaran ditutup. Anda dapat melanjutkannya kembali.'),
                    });
                } catch (error) {
                    showMessage(error.message, 'error');
                } finally {
                    payButton.disabled = false;
                    payButton.textContent = 'Bayar dengan Midtrans';
                }
            });
        </script>
    @endif
</body>
</html>
