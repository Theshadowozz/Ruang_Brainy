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
            || ! $request->user()->hasAcceptedRegistration()
        )) {
            return redirect()
                ->route('classes.index')
                ->with('success', 'Dashboard siswa tersedia setelah pembayaran Midtrans berhasil dan kursi kelas diperoleh.');
        }

        return $next($request);
    }
}
