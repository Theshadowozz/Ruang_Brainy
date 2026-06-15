<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForumController;
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
        abort_unless(Auth::user()->role === User::ROLE_ADMIN, 403);

        return view('admin.dashboard', $forumData());
    })->name('admin.dashboard');

    Route::get('/tutor/dashboard', function () use ($forumData) {
        abort_unless(Auth::user()->role === User::ROLE_TUTOR, 403);

        return view('tutor.dashboard', $forumData());
    })->name('tutor.dashboard');

    Route::get('/siswa/dashboard', function () use ($forumData) {
        abort_unless(Auth::user()->role === User::ROLE_SISWA, 403);

        return view('siswa.dashboard', $forumData());
    })->name('siswa.dashboard');
});
