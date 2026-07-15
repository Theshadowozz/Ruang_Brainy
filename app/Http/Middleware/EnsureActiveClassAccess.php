<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveClassAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->hasActiveClassAccess()) {
            return redirect()
                ->route('siswa.dashboard')
                ->with('access_error', 'Masa akses kelas sudah habis. Perpanjang kelas untuk membuka fitur pembelajaran.');
        }

        return $next($request);
    }
}
