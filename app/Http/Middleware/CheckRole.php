<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! $request->user() || ! in_array((int) $request->user()->role, array_map('intval', $roles), true)) {
            return redirect('/login');
        }

        if ($request->user()->role === User::ROLE_SISWA && (
            ! $request->user()->is_active
            || ! $request->user()->registrations()->where('status', 'accepted')->exists()
        )) {
            return redirect()
                ->route('classes.index')
                ->with('success', 'Dashboard siswa hanya dapat diakses setelah pendaftaran dan pembayaran dikonfirmasi admin.');
        }

        return $next($request);
    }
}
