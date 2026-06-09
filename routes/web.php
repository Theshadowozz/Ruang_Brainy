<?php

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return view('auth.login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/admin/dashboard', function () {
        abort_unless(Auth::user()->role === User::ROLE_ADMIN, 403);

        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/tutor/dashboard', function () {
        abort_unless(Auth::user()->role === User::ROLE_TUTOR, 403);

        return view('tutor.dashboard');
    })->name('tutor.dashboard');

    Route::get('/siswa/dashboard', function () {
        abort_unless(Auth::user()->role === User::ROLE_SISWA, 403);

        return view('siswa.dashboard');
    })->name('siswa.dashboard');
});
