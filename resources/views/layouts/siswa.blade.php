<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Siswa - Brainy')</title>
    @include('layouts.vite')
</head>
<body class="bg-gray-50 font-sans text-gray-950 flex flex-col min-h-screen">

    <!-- Navbar -->
    <header class="w-full border-b border-gray-100 bg-white sticky top-0 z-50 shadow-sm">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-6 sm:px-10 lg:px-28">
            <!-- Logo -->
            <a href="{{ url('/siswa/dashboard') }}" class="flex items-center gap-3 transition" aria-label="Brainy Logo">
                <img src="{{ asset('images/logo_brainy.png') }}" alt="Brainy" class="h-12 w-auto">
                <span class="text-2xl font-extrabold leading-none tracking-normal" style="color: #1D4ED8;">Brainy</span>
            </a>

            <!-- Navigation Menu -->
            <nav class="flex items-center gap-6 text-sm font-medium text-gray-700">
                @if(request()->routeIs('siswa.dashboard') || request()->is('siswa/dashboard'))
                    <a href="{{ url('/') }}" class="flex items-center gap-1.5 text-blue-700 font-semibold hover:text-blue-800 transition">
                        <img src="{{ asset('asset/home.svg') }}" alt="" class="h-4 w-4 object-contain">
                        <span>Home</span>
                    </a>
                @endif
                
                <!-- Logout Trigger -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-1.5 text-gray-500 hover:text-red-600 transition">
                    <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                    <span>Logout</span>
                </a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <script>
        document.querySelectorAll('[data-back-button]').forEach((button) => {
            button.addEventListener('click', () => {
                const fallbackUrl = button.dataset.fallbackUrl || '{{ route('siswa.dashboard') }}';
                const referrer = document.referrer;
                const currentUrl = window.location.href;

                if (window.history.length > 1 && referrer && referrer.startsWith(window.location.origin) && referrer !== currentUrl) {
                    window.history.back();
                    return;
                }

                window.location.href = fallbackUrl;
            });
        });
    </script>
</body>
</html>
