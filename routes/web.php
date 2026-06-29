<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminScheduleController;
use App\Http\Controllers\ClassRegistrationController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\Siswa\SiswaAudioController;
use App\Http\Controllers\Siswa\SiswaDashboardController;
use App\Http\Controllers\TrialRegistrationController;
use App\Models\ForumTopic;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    return view('landing');
})->name('home');

Route::get('/kelas', [ClassRegistrationController::class, 'index'])->name('classes.index');
Route::get('/api/nik/check', [ClassRegistrationController::class, 'checkNik'])->name('api.nik.check');
Route::post('/trial', [TrialRegistrationController::class, 'store'])->name('trial.store');
Route::get('/kelas/jadwal/{schedule}/daftar', [ClassRegistrationController::class, 'create'])->name('registration.create');
Route::post('/kelas/jadwal/{schedule}/daftar', [ClassRegistrationController::class, 'store'])->name('registration.store');
Route::get('/pendaftaran/{registration}/pembayaran', [ClassRegistrationController::class, 'showPayment'])->name('registration.payment.show');
Route::post('/pendaftaran/{registration}/pembayaran', [ClassRegistrationController::class, 'pay'])->name('registration.payment.pay');

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

    Route::middleware('role:' . User::ROLE_ADMIN)->prefix('admin')->name('admin.')->group(function () {
        Route::get('/courses', [AdminCourseController::class, 'index'])->name('courses.index');
        Route::post('/courses', [AdminCourseController::class, 'store'])->name('courses.store');
        Route::put('/courses/{course}', [AdminCourseController::class, 'update'])->name('courses.update');
        Route::delete('/courses/{course}', [AdminCourseController::class, 'destroy'])->name('courses.destroy');

        Route::get('/schedules', [AdminScheduleController::class, 'index'])->name('schedules.index');
        Route::post('/schedules', [AdminScheduleController::class, 'store'])->name('schedules.store');
        Route::put('/schedules/{schedule}', [AdminScheduleController::class, 'update'])->name('schedules.update');
        Route::delete('/schedules/{schedule}', [AdminScheduleController::class, 'destroy'])->name('schedules.destroy');

        Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
        Route::patch('/payments/{payment}/confirm', [AdminPaymentController::class, 'confirm'])->name('payments.confirm');
        Route::patch('/payments/{payment}/reject', [AdminPaymentController::class, 'reject'])->name('payments.reject');
    });

    $tutorData = function (): array {
        $classes = collect([
            [
                'name' => 'English for Beginners',
                'language' => 'Inggris',
                'level' => 'Beginner',
                'summary' => 'Kelas dasar untuk siswa yang baru mulai belajar percakapan bahasa Inggris.',
                'students_current' => 12,
                'students_capacity' => 15,
                'sessions_total' => 24,
                'sessions_done' => 8,
                'duration' => '3 bulan',
                'next_session' => 'Rabu, 24 Mei 2026',
                'next_topic' => 'Daily Conversation',
                'price' => 'Rp 1.500.000',
                'status' => 'Tersedia',
                'schedules' => [
                    [
                        'day' => 'Senin',
                        'date' => '22 Mei 2026',
                        'date_short' => '22',
                        'time' => '19:00 - 20:30',
                        'room' => 'Online Room A',
                        'topic' => 'Basic Greetings',
                    ],
                    [
                        'day' => 'Rabu',
                        'date' => '24 Mei 2026',
                        'date_short' => '24',
                        'time' => '19:00 - 20:30',
                        'room' => 'Online Room A',
                        'topic' => 'Daily Conversation',
                    ],
                ],
            ],
            [
                'name' => 'English Intermediate',
                'language' => 'Inggris',
                'level' => 'Intermediate',
                'summary' => 'Kelas lanjutan untuk meningkatkan speaking, grammar, dan writing.',
                'students_current' => 15,
                'students_capacity' => 15,
                'sessions_total' => 24,
                'sessions_done' => 16,
                'duration' => '3 bulan',
                'next_session' => 'Selasa, 23 Mei 2026',
                'next_topic' => 'Business Communication',
                'price' => 'Rp 1.800.000',
                'status' => 'Penuh',
                'schedules' => [
                    [
                        'day' => 'Selasa',
                        'date' => '23 Mei 2026',
                        'date_short' => '23',
                        'time' => '19:00 - 20:30',
                        'room' => 'Online Room B',
                        'topic' => 'Business Communication',
                    ],
                    [
                        'day' => 'Kamis',
                        'date' => '25 Mei 2026',
                        'date_short' => '25',
                        'time' => '19:00 - 20:30',
                        'room' => 'Online Room B',
                        'topic' => 'Email Writing',
                    ],
                ],
            ],
        ])->map(function ($class) {
            $class['schedule'] = collect($class['schedules'])->pluck('day')->implode(' & ');
            $class['time'] = data_get($class, 'schedules.0.time');
            $class['room'] = data_get($class, 'schedules.0.room');

            return $class;
        });

        $nextSchedules = $classes
            ->flatMap(fn ($class) => collect($class['schedules'])->map(fn ($schedule) => array_merge($schedule, [
                'class_name' => $class['name'],
                'level' => $class['level'],
                'students' => $class['students_current'],
            ])))
            ->values();

        $availableDays = collect(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);

        return [
            'tutor' => [
                'name' => Auth::user()->name ?? 'Tutor Brainy',
                'description' => 'Native speaker dengan sertifikasi TESOL',
                'avatar_url' => null,
            ],
            'classes' => $classes,
            'availableDays' => $availableDays,
            'nextSchedules' => $nextSchedules,
            'stats' => [
                'classes' => $classes->count(),
                'students' => $classes->sum('students_current'),
                'weekly_sessions' => $nextSchedules->count(),
                'teaching_hours' => 36,
                'attendance' => '95%',
                'rating' => '4.9',
            ],
        ];
    };

    Route::middleware('role:' . User::ROLE_TUTOR)->prefix('tutor')->name('tutor.')->group(function () use ($forumData, $tutorData) {
        Route::get('/dashboard', function () use ($forumData, $tutorData) {
            return view('tutor.dashboard', array_merge($forumData(), $tutorData()));
        })->name('dashboard');

        Route::get('/classes', function () use ($tutorData) {
            return view('tutor.classes', $tutorData());
        })->name('classes');
    });

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
