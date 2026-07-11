<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Tutor - Brainy')</title>
    @include('layouts.vite')
</head>
<body class="flex min-h-screen flex-col bg-gray-50 font-sans text-gray-950">
    <header class="sticky top-0 z-50 w-full border-b border-gray-100 bg-white shadow-sm">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-6 sm:px-10 lg:px-28">
            <a href="{{ route('tutor.dashboard') }}" class="flex items-center gap-3 transition" aria-label="Brainy Logo">
                <img src="{{ asset('images/logo_brainy.png') }}" alt="Brainy" class="h-12 w-auto">
                <span class="text-2xl font-extrabold leading-none tracking-normal text-blue-700">Brainy</span>
            </a>

            <nav class="hidden items-center gap-6 text-sm font-medium text-gray-700 md:flex" aria-label="Navigasi tutor">
                <a href="{{ route('tutor.dashboard') }}" class="flex items-center gap-1.5 transition hover:text-blue-700 {{ request()->routeIs('tutor.dashboard') ? 'font-semibold text-blue-700' : '' }}">
                    <img src="{{ asset('asset/home.svg') }}" alt="" class="h-4 w-4 object-contain">
                    <span>Home</span>
                </a>
                <a href="{{ route('tutor.classes') }}" class="flex items-center gap-1.5 transition hover:text-blue-700 {{ request()->routeIs('tutor.classes') ? 'font-semibold text-blue-700' : '' }}">
                    <img src="{{ asset('asset/kelas_aktif_saya.svg') }}" alt="" class="h-4 w-4 object-contain">
                    <span>Kelas</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-1.5 text-gray-500 transition hover:text-red-600">
                    <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                    <span>Logout</span>
                </a>
            </nav>
        </div>

        <nav class="border-t border-gray-100 bg-white px-6 py-2 md:hidden" aria-label="Navigasi tutor mobile">
            <div class="mx-auto grid max-w-7xl grid-cols-2 gap-2 text-center text-xs font-semibold text-gray-600">
                <a href="{{ route('tutor.dashboard') }}" class="rounded-md px-2 py-2 {{ request()->routeIs('tutor.dashboard') ? 'bg-blue-50 text-blue-700' : 'hover:bg-gray-50' }}">Home</a>
                <a href="{{ route('tutor.classes') }}" class="rounded-md px-2 py-2 {{ request()->routeIs('tutor.classes') ? 'bg-blue-50 text-blue-700' : 'hover:bg-gray-50' }}">Kelas</a>
            </div>
        </nav>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('layouts.footer')
</body>
</html>
