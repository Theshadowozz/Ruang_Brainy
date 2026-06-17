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
    Route::get('/admin/dashboard', function () {
        abort_unless(Auth::user()->isAdmin(), 403);
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/waitinglist', function () {
        abort_unless(Auth::user()->isAdmin(), 403);
        return view('admin.waitinglist');
    })->name('admin.waitinglist');


    Route::get('/admin/tutors', function () {
        abort_unless(Auth::user()->isAdmin(), 403);
        return view('admin.tutors');
    })->name('admin.tutors');

Route::get('/admin/courses', function () {
    return view('admin.courses');
})->name('admin.courses');

Route::get('/admin/payments', function () {
    return view('admin.payments');
})->name('admin.payments');

Route::get('/admin/schedules', function () {
    return view('admin.schedules');
})->name('admin.schedules');

Route::get('/admin/waitinglist', function () {
    return view('admin.waitinglist');
})->name('admin.waitinglist');


    Route::get('/admin/students', function () {
        abort_unless(Auth::user()->isAdmin(), 403);
        return view('admin.students');
    })->name('admin.students');
});

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
Route::get('/admin/kursus', function () {
    return redirect()->route('admin.courses');
});
Route::get('/admin/pembayaran', function () {
    return redirect()->route('admin.payments');
});
Route::get('/admin/jadwal', function () {
    return redirect()->route('admin.schedules');
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

Route::middleware(['auth', 'role:2'])->get('/siswa/dashboard', [\App\Http\Controllers\Siswa\SiswaDashboardController::class, 'index'])->name('siswa.dashboard');

Route::middleware(['auth', 'role:2'])->group(function () {
    Route::get('/siswa/audio', [\App\Http\Controllers\Siswa\SiswaAudioController::class, 'index'])->name('siswa.audio.index');
    Route::get('/siswa/audio/{id}/download', [\App\Http\Controllers\Siswa\SiswaAudioController::class, 'download'])->name('siswa.audio.download');
    Route::post('/siswa/audio/{id}/listen', [\App\Http\Controllers\Siswa\SiswaAudioController::class, 'markListened'])->name('siswa.audio.listen');
    Route::get('/siswa/translate', [\App\Http\Controllers\Siswa\SiswaTranslateController::class, 'index'])->name('siswa.translate.index');
    Route::post('/siswa/translate', [\App\Http\Controllers\Siswa\SiswaTranslateController::class, 'translate'])->name('siswa.translate.store');
});
