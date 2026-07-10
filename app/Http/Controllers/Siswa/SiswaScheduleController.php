<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class SiswaScheduleController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = in_array($request->query('tab'), ['aktif', 'selesai', 'jadwal'], true)
            ? $request->query('tab')
            : 'aktif';

        $registrations = Registration::query()
            ->where('user_id', $request->user()->id)
            ->whereIn('status', ['accepted', 'finished'])
            ->with(['schedule.courseClass.tutor'])
            ->latest()
            ->get();

        return view('siswa.jadwal.index', [
            'activeTab' => $activeTab,
            'activeRegistrations' => $registrations->where('status', 'accepted')->values(),
            'finishedRegistrations' => $registrations->where('status', 'finished')->values(),
        ]);
    }
}
