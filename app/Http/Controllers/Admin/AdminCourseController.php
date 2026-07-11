<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseClass;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminCourseController extends Controller
{
    public function index()
    {
        return view('admin.courses', [
            'classes' => CourseClass::with(['tutor', 'schedules'])->latest()->get(),
            'tutors' => Tutor::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        CourseClass::create($this->validated($request));

        return back()->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function update(Request $request, CourseClass $course)
    {
        $course->update($this->validated($request));

        return back()->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(CourseClass $course)
    {
        $course->delete();

        return back()->with('success', 'Kelas berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'language' => ['required', Rule::in(['Inggris', 'Jepang', 'Korea'])],
            'level' => ['required', Rule::in(['Beginner', 'Intermediate', 'Advance'])],
            'tutor_id' => ['required', 'exists:tutors,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string'],
        ]);
    }
}
