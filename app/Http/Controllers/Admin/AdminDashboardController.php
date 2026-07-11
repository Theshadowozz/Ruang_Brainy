<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseClass;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\TrialRegistration;
use App\Models\Tutor;
use App\Models\User;
use App\Models\WaitingList;

class AdminDashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'stats' => [
                'students' => User::query()->where('role', User::ROLE_SISWA)->count(),
                'classes' => CourseClass::query()->whereHas('schedules')->count(),
                'tutors' => Tutor::query()->count(),
                'revenue' => Payment::query()->where('status', 'paid')->sum('amount'),
                'waiting' => WaitingList::query()->where('status', 'waiting')->count(),
                'trials' => TrialRegistration::query()->count(),
            ],
            'confirmedRegistrations' => Registration::query()
                ->with(['user', 'schedule.courseClass'])
                ->where('status', 'accepted')
                ->latest('updated_at')
                ->take(10)
                ->get(),
            'pendingPayments' => Payment::query()
                ->with(['registration.user', 'registration.schedule.courseClass'])
                ->where('status', 'pending')
                ->whereNotNull('transaction_code')
                ->latest()
                ->take(10)
                ->get(),
            'trialRegistrations' => TrialRegistration::query()
                ->with('user')
                ->latest()
                ->take(10)
                ->get(),
        ]);
    }
}
