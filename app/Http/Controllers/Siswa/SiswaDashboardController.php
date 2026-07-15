<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\AudioListen;
use App\Models\QuizResult;
use App\Models\Registration;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;

class SiswaDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $registrations = Registration::query()
            ->where('user_id', $userId)
            ->whereIn('status', [Registration::STATUS_ACCEPTED, Registration::STATUS_FINISHED])
            ->with(['schedule.courseClass.tutor', 'latestPayment'])
            ->get();

        $kelasAktifList = $registrations
            ->where('status', Registration::STATUS_ACCEPTED)
            ->values()
            ->each(function (Registration $registration) {
                $start = $registration->access_starts_at;
                $end = $registration->access_ends_at;
                $now = now();

                if (! $start || ! $end || $now->lessThan($start)) {
                    $progress = 0;
                } elseif ($now->greaterThanOrEqualTo($end)) {
                    $progress = 100;
                } else {
                    $progress = (int) round($start->diffInSeconds($now) / max($start->diffInSeconds($end), 1) * 100);
                }

                $registration->setAttribute('progress', min(max($progress, 0), 100));
                $registration->setAttribute('access_active', $registration->hasActiveAccess());
            });

        $jadwalMendatang = Schedule::query()
            ->whereHas('registrations', fn ($query) => $query
                ->where('user_id', $userId)
                ->where('status', Registration::STATUS_ACCEPTED)
                ->where('access_starts_at', '<=', now())
                ->where('access_ends_at', '>=', now()))
            ->whereDate('end_date', '>=', today())
            ->with(['courseClass.tutor'])
            ->orderBy('start_date')
            ->limit(5)
            ->get();

        return view('siswa.dashboard', [
            'kelasAktif' => $kelasAktifList->filter->hasActiveAccess()->count(),
            'kelasSelesai' => $registrations->where('status', Registration::STATUS_FINISHED)->count(),
            'audioDidengar' => AudioListen::query()->where('user_id', $userId)->distinct('audio_lesson_id')->count('audio_lesson_id'),
            'quizSelesai' => QuizResult::query()->where('user_id', $userId)->whereNotNull('completed_at')->count(),
            'kelasAktifList' => $kelasAktifList,
            'jadwalMendatang' => $jadwalMendatang,
            'hasActiveAccess' => $kelasAktifList->contains(fn (Registration $registration) => $registration->hasActiveAccess()),
        ]);
    }
}
