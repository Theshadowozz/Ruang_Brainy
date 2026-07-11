<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\TrialRegistration;

class AdminStudentController extends Controller
{
    public function index()
    {
        return view('admin.students', [
            'registrations' => Registration::query()
                ->with(['user', 'payment', 'schedule.courseClass'])
                ->latest()
                ->get(),
            'trialRegistrations' => TrialRegistration::query()
                ->with('user')
                ->latest()
                ->get(),
        ]);
    }
}
