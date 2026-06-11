<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brainy Admin</title>
    @include('layouts.vite')
</head>
<body class="bg-[#F8FAFC] font-sans text-[#1E293B]">
    <script>
        @if(Illuminate\Support\Facades\Auth::check() && Illuminate\Support\Facades\Auth::user()->isAdmin())
            localStorage.setItem('brainy_admin_auth', 'true');
        @else
            // Optional: if Laravel session is logged out, sync localStorage
            if (!document.cookie.includes('laravel_session')) {
                localStorage.removeItem('brainy_admin_auth');
            }
        @endif
    </script>
    <div id="admin-root"></div>
</body>
</html>
