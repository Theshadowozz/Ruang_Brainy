<?php

use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminQuizController;
use App\Http\Controllers\Admin\AdminScheduleController;
use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\Admin\AdminTutorController;
use App\Http\Controllers\Admin\AdminWaitingListController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassRegistrationController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Siswa\SiswaAudioController;
use App\Http\Controllers\Siswa\SiswaCourseController;
use App\Http\Controllers\Siswa\SiswaDashboardController;
use App\Http\Controllers\Siswa\SiswaQuizController;
use App\Http\Controllers\Siswa\SiswaScheduleController;
use App\Http\Controllers\Siswa\SiswaTranslateController;
use App\Http\Controllers\TrialRegistrationController;
use App\Http\Controllers\Tutor\TutorDashboardController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingController::class)->name('landing');

Route::get('/kelas', [ClassRegistrationController::class, 'index'])->name('classes.index');
Route::get('/kelas/jadwal/{schedule}/daftar', [ClassRegistrationController::class, 'create'])->name('registration.create');
Route::post('/kelas/jadwal/{schedule}/daftar', [ClassRegistrationController::class, 'store'])->name('registration.store');
Route::get('/pendaftaran/{registration}/pembayaran', [ClassRegistrationController::class, 'showPayment'])->name('registration.payment.show');
Route::post('/pendaftaran/{registration}/pembayaran', [ClassRegistrationController::class, 'pay'])->name('registration.payment.pay');

Route::get('/trial/daftar', [TrialRegistrationController::class, 'create'])->name('trial.create');
Route::post('/trial/daftar', [TrialRegistrationController::class, 'store'])->name('trial.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/forum/topics', [ForumController::class, 'storeTopic'])->name('forum.topics.store');
    Route::post('/forum/topics/{forumTopic}/replies', [ForumController::class, 'storeReply'])->name('forum.replies.store');

    Route::middleware('role:'.User::ROLE_ADMIN)->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
        Route::get('/waitinglist', AdminWaitingListController::class)->name('waitinglist');
        Route::get('/students', [AdminStudentController::class, 'index'])->name('students');

        Route::get('/tutors', [AdminTutorController::class, 'index'])->name('tutors.index');
        Route::post('/tutors', [AdminTutorController::class, 'store'])->name('tutors.store');
        Route::put('/tutors/{tutor}', [AdminTutorController::class, 'update'])->name('tutors.update');
        Route::delete('/tutors/{tutor}', [AdminTutorController::class, 'destroy'])->name('tutors.destroy');

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

        Route::get('/quiz', [AdminQuizController::class, 'index'])->name('quiz.index');
        Route::post('/quiz', [AdminQuizController::class, 'store'])->name('quiz.store');
        Route::delete('/quiz/{quiz}', [AdminQuizController::class, 'destroy'])->name('quiz.destroy');

        Route::get('/diskusi', [DiscussionController::class, 'index'])->name('diskusi.index');
        Route::get('/diskusi/live', [DiscussionController::class, 'live'])->name('diskusi.live');
        Route::post('/diskusi', [DiscussionController::class, 'storeTopic'])->name('diskusi.store');
        Route::post('/diskusi/{topic}/messages', [DiscussionController::class, 'storeMessage'])->name('diskusi.messages.store');
    });

    Route::middleware('role:'.User::ROLE_TUTOR)->prefix('tutor')->name('tutor.')->group(function () {
        Route::get('/dashboard', [TutorDashboardController::class, 'index'])->name('dashboard');
        Route::get('/classes', [TutorDashboardController::class, 'classes'])->name('classes');

        Route::get('/diskusi', [DiscussionController::class, 'index'])->name('diskusi.index');
        Route::get('/diskusi/live', [DiscussionController::class, 'live'])->name('diskusi.live');
        Route::post('/diskusi', [DiscussionController::class, 'storeTopic'])->name('diskusi.store');
        Route::post('/diskusi/{topic}/messages', [DiscussionController::class, 'storeMessage'])->name('diskusi.messages.store');
    });

    Route::middleware('role:'.User::ROLE_SISWA)->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
        Route::get('/audio', [SiswaAudioController::class, 'index'])->name('audio.index');
        Route::get('/audio/{id}/download', [SiswaAudioController::class, 'download'])->name('audio.download');
        Route::post('/audio/{id}/listen', [SiswaAudioController::class, 'markListened'])->name('audio.listen');

        Route::get('/kelas-kursus', [SiswaCourseController::class, 'index'])->name('kelas-kursus.index');
        Route::get('/kelas-kursus/{course}', [SiswaCourseController::class, 'show'])->name('kelas-kursus.show');
        Route::get('/jadwal', [SiswaScheduleController::class, 'index'])->name('jadwal.index');

        Route::get('/quiz', [SiswaQuizController::class, 'index'])->name('quiz.index');
        Route::post('/quiz/{quiz}/answer', [SiswaQuizController::class, 'answer'])->name('quiz.answer');
        Route::get('/translate', [SiswaTranslateController::class, 'index'])->name('translate.index');
        Route::post('/translate', [SiswaTranslateController::class, 'translate'])->name('translate.store');

        Route::get('/diskusi', [DiscussionController::class, 'index'])->name('diskusi.index');
        Route::get('/diskusi/live', [DiscussionController::class, 'live'])->name('diskusi.live');
        Route::post('/diskusi', [DiscussionController::class, 'storeTopic'])->name('diskusi.store');
        Route::post('/diskusi/{topic}/messages', [DiscussionController::class, 'storeMessage'])->name('diskusi.messages.store');
    });
});

Route::redirect('/admin/waitlist', '/admin/waitinglist');
Route::redirect('/admin/tutor', '/admin/tutors');
Route::redirect('/admin/siswa', '/admin/students');
Route::redirect('/admin', '/admin/dashboard');
