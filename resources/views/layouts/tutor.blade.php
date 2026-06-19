<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Tutor - Brainy')</title>
    @include('layouts.vite')
</head>
<body class="bg-gray-50 font-sans text-gray-950 flex min-h-screen flex-col">
    <header class="w-full border-b border-gray-100 bg-white sticky top-0 z-50 shadow-sm">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-6 sm:px-10 lg:px-28">
            <a href="{{ route('tutor.dashboard') }}" class="flex items-center gap-3 transition" aria-label="Brainy Logo">
                <img src="{{ asset('images/logo_brainy.png') }}" alt="Brainy" class="h-12 w-auto">
                <span class="text-2xl font-extrabold leading-none tracking-normal" style="color: #1D4ED8;">Brainy</span>
            </a>

            <nav class="flex items-center gap-6 text-sm font-medium text-gray-700">
                <a href="{{ route('tutor.dashboard') }}" class="flex items-center gap-1.5 transition hover:text-blue-700 {{ request()->routeIs('tutor.dashboard') ? 'text-blue-700 font-semibold' : '' }}">
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('tutor.diskusi.index') }}" class="flex items-center gap-1.5 transition hover:text-blue-700 {{ request()->routeIs('tutor.diskusi.*') ? 'text-blue-700 font-semibold' : '' }}">
                    <img src="{{ asset('asset/diskusi.svg') }}" alt="" class="h-4 w-4 object-contain">
                    <span>Diskusi</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-gray-500 transition hover:text-red-600">
                    Logout
                </a>
            </nav>
        </div>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>
</body>
</html>
