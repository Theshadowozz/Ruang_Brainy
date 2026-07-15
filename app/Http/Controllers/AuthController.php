<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return redirect()->route('classes.index');
    }

    public function register(Request $request)
    {
        return redirect()
            ->route('classes.index')
            ->with('success', 'Silakan pilih kelas dan jadwal terlebih dahulu.');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            if (Auth::user()->isSiswa() && (
                ! Auth::user()->is_active
                || ! Auth::user()->hasAcceptedRegistration()
            )) {
                Auth::logout();

                return back()
                    ->withErrors(['email' => 'Akun belum aktif. Selesaikan pembayaran Midtrans atau tunggu kursi kelas tersedia.'])
                    ->onlyInput('email');
            }

            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()
            ->withErrors(['email' => 'Email atau password tidak sesuai.'])
            ->onlyInput('email');
    }

    public function dashboard()
    {
        return match (Auth::user()->role) {
            User::ROLE_ADMIN => redirect()->route('admin.dashboard'),
            User::ROLE_TUTOR => redirect()->route('tutor.dashboard'),
            default => redirect()->route('siswa.dashboard'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }
}
