<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Tutor;
use Illuminate\Support\Facades\Auth;

class TutorDashboardController extends Controller
{
    public function index()
    {
        return view('tutor.dashboard', $this->data());
    }

    public function classes()
    {
        return view('tutor.classes', $this->data());
    }

    private function data(): array
    {
        $tutor = Tutor::query()
            ->where('user_id', Auth::id())
            ->orWhere('email', Auth::user()->email)
            ->first();

        $classes = $tutor
            ? $tutor->classes()
                ->with(['schedules' => fn ($query) => $query
                    ->withCount(['registrations as students_count' => fn ($registration) => $registration
                        ->where('status', 'accepted')])
                    ->orderBy('start_date')
                    ->orderBy('start_time')])
                ->orderBy('name')
                ->get()
            : collect();

        $schedules = $classes->flatMap->schedules->sortBy([
            ['start_date', 'asc'],
            ['start_time', 'asc'],
        ])->values();

        return [
            'tutor' => $tutor,
            'classes' => $classes,
            'schedules' => $schedules,
            'stats' => [
                'classes' => $classes->count(),
                'students' => $schedules->sum('students_count'),
                'schedules' => $schedules->count(),
                'capacity' => $schedules->sum('capacity'),
            ],
        ];
    }
}
