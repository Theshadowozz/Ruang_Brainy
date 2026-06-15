<?php

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
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

Route::middleware(['auth', 'role:2'])->get('/siswa/dashboard', [\App\Http\Controllers\Siswa\SiswaDashboardController::class, 'index'])->name('siswa.dashboard');

Route::middleware(['auth', 'role:2'])->group(function () {
    Route::get('/siswa/audio', [\App\Http\Controllers\Siswa\SiswaAudioController::class, 'index'])->name('siswa.audio.index');
    Route::get('/siswa/audio/{id}/download', [\App\Http\Controllers\Siswa\SiswaAudioController::class, 'download'])->name('siswa.audio.download');
    Route::post('/siswa/audio/{id}/listen', [\App\Http\Controllers\Siswa\SiswaAudioController::class, 'markListened'])->name('siswa.audio.listen');
});

