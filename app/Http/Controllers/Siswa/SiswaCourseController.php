<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\CourseClass;
use Illuminate\Http\Request;

class SiswaCourseController extends Controller
{
    public function index(Request $request)
    {
        $filterBahasa = in_array($request->query('bahasa'), ['Inggris', 'Jepang', 'Korea'], true)
            ? $request->query('bahasa')
            : '';
        $filterLevel = in_array($request->query('level'), ['Beginner', 'Intermediate', 'Advance'], true)
            ? $request->query('level')
            : '';

        $courses = CourseClass::query()
            ->with(['tutor', 'schedules' => fn ($query) => $query
                ->withCount(['registrations as occupied_seats' => fn ($registration) => $registration
                    ->where(fn ($status) => $status
                        ->where('status', 'accepted')
                        ->orWhere(fn ($pending) => $pending
                            ->where('status', 'pending')
                            ->where('seat_reserved_until', '>', now())))])
                ->whereDate('end_date', '>=', today())
                ->orderBy('start_date')])
            ->whereHas('schedules', fn ($query) => $query->whereDate('end_date', '>=', today()))
            ->when($filterBahasa, fn ($query) => $query->where('language', $filterBahasa))
            ->when($filterLevel, fn ($query) => $query->where('level', $filterLevel))
            ->orderBy('language')
            ->orderBy('level')
            ->get();

        return view('siswa.kelas-kursus.index', compact('courses', 'filterBahasa', 'filterLevel'));
    }

    public function show(CourseClass $course)
    {
        $course->load([
            'tutor',
            'schedules' => fn ($query) => $query
                ->withCount(['registrations as occupied_seats' => fn ($registration) => $registration
                    ->where(fn ($status) => $status
                        ->where('status', 'accepted')
                        ->orWhere(fn ($pending) => $pending
                            ->where('status', 'pending')
                            ->where('seat_reserved_until', '>', now())))])
                ->whereDate('end_date', '>=', today())
                ->orderBy('start_date'),
        ]);

        return view('siswa.kelas-kursus.show', compact('course'));
    }
}
