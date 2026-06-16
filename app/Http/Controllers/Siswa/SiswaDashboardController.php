<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SiswaDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. $kelasAktif: jumlah registrations dengan status='accepted' milik user ini
        $kelasAktif = Registration::where('user_id', $userId)
            ->where('status', 'accepted')
            ->count();

        // 2. $kelasSelesai: jumlah registrations dengan status='finished' milik user ini
        $kelasSelesai = Registration::where('user_id', $userId)
            ->where('status', 'finished')
            ->count();

        // 3. $audioDidengar: hardcode 15 untuk sementara
        $audioDidengar = 15;

        // 4. $quizSelesai: hardcode 8 untuk sementara
        $quizSelesai = 8;

        // 5. $kelasAktifList: registrations status='accepted' milik user ini,
        //    eager load: schedule.class.tutor, hitung progress, clamp 0-100
        $kelasAktifList = Registration::where('user_id', $userId)
            ->where('status', 'accepted')
            ->with(['schedule.class.tutor'])
            ->get()
            ->map(function ($registration) {
                $progress = 0;
                if ($registration->schedule) {
                    $startDate = Carbon::parse($registration->schedule->start_date);
                    $endDate = Carbon::parse($registration->schedule->end_date);
                    $today = Carbon::today();

                    if ($endDate->equalTo($startDate)) {
                        $progress = $today->greaterThanOrEqualTo($startDate) ? 100 : 0;
                    } else {
                        $totalDays = $startDate->diffInDays($endDate);
                        if ($today->lessThan($startDate)) {
                            $progress = 0;
                        } elseif ($today->greaterThan($endDate)) {
                            $progress = 100;
                        } else {
                            $elapsedDays = $startDate->diffInDays($today);
                            $progress = (int) round(($elapsedDays / $totalDays) * 100);
                        }
                    }
                }
                $registration->progress = min(max($progress, 0), 100);
                return $registration;
            });

        // 6. $jadwalMendatang: schedules dari registrations status='accepted' user ini
        //    yang tanggalnya >= hari ini, urutkan by start_date ASC, limit 5
        $jadwalMendatang = Schedule::whereHas('registrations', function ($query) use ($userId) {
            $query->where('user_id', $userId)->where('status', 'accepted');
        })
        ->where('start_date', '>=', Carbon::today()->toDateString())
        ->with(['class.tutor'])
        ->orderBy('start_date', 'asc')
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

// =========================================================================
// Inline Eloquent Models to comply with strict folder modification limits
// =========================================================================

class Tutor extends Model
{
    protected $table = 'tutors';
}

class CourseClass extends Model
{
    protected $table = 'classes';

    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'tutor_id');
    }
}

class Schedule extends Model
{
    protected $table = 'schedules';

    public function class()
    {
        return $this->belongsTo(CourseClass::class, 'class_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'schedule_id');
    }
}

class Registration extends Model
{
    protected $table = 'registrations';

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }
}
