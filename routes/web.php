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

Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/admin/waitinglist', function () {
    return view('admin.waitinglist');
})->name('admin.waitinglist');

Route::get('/admin/tutors', function () {
    return view('admin.tutors');
})->name('admin.tutors');

Route::get('/admin/students', function () {
    return view('admin.students');
})->name('admin.students');

// Redirects for compatibility
Route::get('/admin/waitlist', function () {
    return redirect()->route('admin.waitinglist');
});
Route::get('/admin/tutor', function () {
    return redirect()->route('admin.tutors');
});
Route::get('/admin/siswa', function () {
    return redirect()->route('admin.students');
});
Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/tutor/dashboard', function () {
        abort_unless(Auth::user()->role === User::ROLE_TUTOR, 403);

        return view('tutor.dashboard');
    })->name('tutor.dashboard');

    Route::get('/siswa/dashboard', function () {
        abort_unless(Auth::user()->role === User::ROLE_SISWA, 403);

        return view('siswa.dashboard');
    })->name('siswa.dashboard');
});
