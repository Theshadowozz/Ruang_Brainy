<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\AudioListen;
use App\Models\QuizResult;
use App\Models\Registration;
use App\Models\Schedule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SiswaDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $kelasAktif = Registration::query()->where('user_id', $userId)->where('status', 'accepted')->count();
        $kelasSelesai = Registration::query()->where('user_id', $userId)->where('status', 'finished')->count();
        $audioDidengar = AudioListen::query()->where('user_id', $userId)->distinct('audio_lesson_id')->count('audio_lesson_id');
        $quizSelesai = QuizResult::query()->where('user_id', $userId)->whereNotNull('completed_at')->count();

        $kelasAktifList = Registration::query()
            ->where('user_id', $userId)
            ->where('status', 'accepted')
            ->with(['schedule.courseClass.tutor'])
            ->get()
            ->each(function (Registration $registration) {
                $schedule = $registration->schedule;
                $startDate = $schedule->start_date;
                $endDate = $schedule->end_date;
                $today = Carbon::today();

                if ($today->lessThan($startDate)) {
                    $progress = 0;
                } elseif ($today->greaterThanOrEqualTo($endDate) || $startDate->equalTo($endDate)) {
                    $progress = 100;
                } else {
                    $progress = (int) round($startDate->diffInDays($today) / max($startDate->diffInDays($endDate), 1) * 100);
                }

                $registration->setAttribute('progress', min(max($progress, 0), 100));
            });

        $jadwalMendatang = Schedule::query()
            ->whereHas('registrations', fn ($query) => $query
                ->where('user_id', $userId)
                ->where('status', 'accepted'))
            ->whereDate('end_date', '>=', today())
            ->with(['courseClass.tutor'])
            ->orderBy('start_date')
            ->limit(5)
            ->get();

        return view('siswa.dashboard', compact(
            'kelasAktif',
            'kelasSelesai',
            'audioDidengar',
            'quizSelesai',
            'kelasAktifList',
            'jadwalMendatang'
        ));
    }
}
