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
            <a href="{{ url('/siswa/dashboard') }}" class="flex items-center gap-2 text-blue-700 hover:text-blue-800 transition font-bold text-2xl" aria-label="Brainy Logo">
                <span>📖</span>
                <span class="tracking-tight">Brainy</span>
            </a>

            <!-- Navigation Menu -->
            <nav class="flex items-center gap-6 text-sm font-medium text-gray-700">
                <a href="{{ url('/siswa/dashboard') }}" class="hover:text-blue-700 transition {{ request()->is('siswa/dashboard') ? 'text-blue-700 font-semibold' : '' }}">
                    Home
                </a>
                
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

</body>
</html>
