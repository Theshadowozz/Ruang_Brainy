<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\Siswa\SiswaAudioController;
use App\Http\Controllers\Siswa\SiswaDashboardController;
use App\Models\ForumTopic;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

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
    $forumData = function (): array {
        $topics = collect();

        if (Schema::hasTable('forum_topics') && Schema::hasTable('forum_replies')) {
            $topics = ForumTopic::query()
                ->with(['user', 'replies.user'])
                ->withCount('replies')
                ->latest()
                ->take(6)
                ->get();
        }

        return [
            'forumCategories' => ForumTopic::categories(),
            'forumTopics' => $topics,
        ];
    };

    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/forum/topics', [ForumController::class, 'storeTopic'])->name('forum.topics.store');
    Route::post('/forum/topics/{forumTopic}/replies', [ForumController::class, 'storeReply'])->name('forum.replies.store');

    Route::get('/admin/dashboard', function () use ($forumData) {
        abort_unless(Auth::user()->isAdmin(), 403);

        return view('admin.dashboard', $forumData());
    })->name('admin.dashboard');

    Route::get('/admin/waitinglist', function () {
        abort_unless(Auth::user()->isAdmin(), 403);

        return view('admin.waitinglist');
    })->name('admin.waitinglist');

    Route::get('/admin/tutors', function () {
        abort_unless(Auth::user()->isAdmin(), 403);

        return view('admin.tutors');
    })->name('admin.tutors');

    Route::get('/admin/students', function () {
        abort_unless(Auth::user()->isAdmin(), 403);

        return view('admin.students');
    })->name('admin.students');

    Route::get('/tutor/dashboard', function () use ($forumData) {
        abort_unless(Auth::user()->isTutor(), 403);

        return view('tutor.dashboard', $forumData());
    })->name('tutor.dashboard');

    Route::middleware('role:' . User::ROLE_SISWA)->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
        Route::get('/audio', [SiswaAudioController::class, 'index'])->name('audio.index');
        Route::get('/audio/{id}/download', [SiswaAudioController::class, 'download'])->name('audio.download');
        Route::post('/audio/{id}/listen', [SiswaAudioController::class, 'markListened'])->name('audio.listen');
    });
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

Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
});
