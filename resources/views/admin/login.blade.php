<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brainy Admin Login</title>
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
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-4px); }
            20%, 40%, 60%, 80% { transform: translateX(4px); }
        }
        .animate-shake {
            animation: shake 0.5s ease-in-out;
        }
    </style>
</head>
<body class="bg-white text-slate-900 antialiased min-h-screen">
    
    <!-- Redirect to dashboard if already authenticated -->
    <script>
        const AUTH_KEY = 'brainy_admin_auth';
        if (localStorage.getItem(AUTH_KEY) === 'true') {
            window.location.href = '/admin/dashboard';
        }
    </script>

    <div class="flex min-h-screen">
        <!-- Left Side: Form -->
        <div class="flex w-full flex-col justify-between px-6 py-10 lg:w-[45%] lg:px-16 xl:px-24">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600 text-white shadow-md shadow-blue-500/20">
                    <i data-lucide="book-open" class="h-6 w-6" stroke-width="2.2"></i>
                </div>
                <span class="text-xl font-bold tracking-tight text-slate-900">Brainy <span class="text-blue-600">Admin</span></span>
            </div>

            <div class="my-auto py-12">
                <div class="mb-8">
                    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Masuk Dasbor</h1>
                    <p class="mt-2 text-sm text-slate-500">Kelola pendaftaran, pembayaran, dan aktivitas belajar bahasa asing.</p>
                </div>

                <!-- Error Message Panel -->
                <div id="error-panel" class="mb-6 flex gap-3 rounded-xl border border-red-100 bg-red-50 p-4 text-sm font-medium text-red-700 hidden animate-shake">
                    <i data-lucide="shield-alert" class="h-5 w-5 shrink-0 text-red-500"></i>
                    <span id="error-message"></span>
                </div>

                <form class="space-y-6" onsubmit="handleLoginSubmit(event)">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email Admin</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <i data-lucide="mail" class="h-5 w-5"></i>
                            </span>
                            <input
                                id="email"
                                type="email"
                                placeholder="admin@brainy.com"
                                class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50/50 pl-11 pr-4 text-sm font-medium outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100/50"
                                required
                            />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <i data-lucide="lock" class="h-5 w-5"></i>
                            </span>
                            <input
                                id="password"
                                type="password"
                                placeholder="••••••••"
                                class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50/50 pl-11 pr-4 text-sm font-medium outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100/50"
                                required
                            />
                        </div>
                    </div>

                    <button
                        id="btn-submit"
                        type="submit"
                        class="flex h-12 w-full items-center justify-center rounded-xl bg-blue-600 text-sm font-bold text-white shadow-lg shadow-blue-600/20 transition-all hover:bg-blue-700 hover:shadow-blue-600/30 active:scale-[0.98] cursor-pointer"
                    >
                        <span id="btn-text">Masuk sebagai Admin</span>
                        <div id="btn-spinner" class="h-5 w-5 animate-spin rounded-full border-2 border-white border-t-transparent hidden"></div>
                    </button>
                </form>
            </div>

            <div class="text-xs text-slate-400">
                &copy; 2026 Brainy Language Platform. Hak cipta dilindungi.
            </div>
        </div>

        <!-- Right Side: Graphic Panel -->
        <div class="hidden lg:flex w-[55%] flex-col justify-between bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-950 p-16 text-white relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none"></div>
            <div class="absolute -top-40 -right-40 h-[600px] w-[600px] rounded-full bg-blue-500/20 blur-3xl"></div>
            <div class="absolute -bottom-45 -left-40 h-[600px] w-[600px] rounded-full bg-indigo-500/25 blur-3xl"></div>

            <div class="z-10 flex items-center justify-end">
                <span class="rounded-full bg-white/10 px-4 py-1.5 text-xs font-semibold backdrop-blur-md border border-white/10">v1.2.0 Stable</span>
            </div>

            <div class="z-10 my-auto max-w-lg space-y-6">
                <h2 class="text-4xl font-extrabold leading-tight tracking-tight">Satu Dasbor untuk Mengelola Seluruh Kelas Bahasa.</h2>
                <p class="text-lg text-blue-100 font-light">Pantau aktivitas pendaftaran siswa secara real-time, validasi transaksi pembayaran secara aman, dan atur ketersediaan jadwal tutor dalam satu platform.</p>

                <div class="mt-8 rounded-2xl border border-white/10 bg-white/10 p-6 backdrop-blur-lg">
                    <div class="flex items-center justify-between border-b border-white/10 pb-4 mb-4">
                        <span class="text-xs font-semibold uppercase tracking-wider text-blue-200">Aktivitas Hari Ini</span>
                        <span class="flex h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-blue-200">Siswa Baru Terdaftar</p>
                            <p class="text-2xl font-bold mt-1">+12 Siswa</p>
                        </div>
                        <div>
                            <p class="text-xs text-blue-200">Menunggu Konfirmasi</p>
                            <p class="text-2xl font-bold mt-1 text-amber-300">3 Pembayaran</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="z-10 flex items-center justify-between text-sm text-blue-200">
                <span>Kemudahan Operasional Kursus</span>
                <a href="/" class="hover:underline hover:text-white transition">Halaman Utama &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Login JS Validation -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });

        const ADMIN_EMAIL = 'admin@brainy.com';
        const ADMIN_PASSWORD = 'admin123';

        function handleLoginSubmit(event) {
            event.preventDefault();
            
            const emailInput = document.getElementById('email').value.trim();
            const passwordInput = document.getElementById('password').value;
            const errorPanel = document.getElementById('error-panel');
            const errorMessage = document.getElementById('error-message');
            const btnText = document.getElementById('btn-text');
            const btnSpinner = document.getElementById('btn-spinner');
            const btnSubmit = document.getElementById('btn-submit');

            // Reset states
            errorPanel.classList.add('hidden');
            btnText.classList.add('hidden');
            btnSpinner.classList.remove('hidden');
            btnSubmit.disabled = true;

            setTimeout(() => {
                if (emailInput === ADMIN_EMAIL && passwordInput === ADMIN_PASSWORD) {
                    localStorage.setItem('brainy_admin_auth', 'true');
                    window.location.href = '/admin/dashboard';
                } else {
                    errorMessage.innerText = 'Email atau password admin tidak sesuai.';
                    errorPanel.classList.remove('hidden');
                    
                    // Re-trigger shake animation
                    errorPanel.classList.remove('animate-shake');
                    void errorPanel.offsetWidth; // Trigger reflow
                    errorPanel.classList.add('animate-shake');

                    btnText.classList.remove('hidden');
                    btnSpinner.classList.add('hidden');
                    btnSubmit.disabled = false;
                }
            }, 800);
        }
    </script>
</body>
</html>
