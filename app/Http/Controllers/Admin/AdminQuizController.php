<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminQuizController extends Controller
{
    public function index(): View
    {
        $quizzes = Quiz::query()
            ->withCount('results')
            ->latest('published_at')
            ->latest()
            ->get();

        $answers = QuizResult::query()
            ->with(['quiz', 'user'])
            ->latest('answered_at')
            ->get();

        return view('admin.quiz', compact('quizzes', 'answers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'week_label' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
            'language' => ['required', 'in:Inggris,Jepang,Korea'],
            'level' => ['required', 'in:Beginner,Intermediate,Advance'],
            'quiz_image' => ['required', 'image', 'max:4096'],
        ]);

        $imagePath = $request->file('quiz_image')->store('quiz-images', 'public');

        Quiz::create([
            'title' => $validated['title'],
            'week_label' => $validated['week_label'] ?? null,
            'description' => $validated['description'] ?? null,
            'language' => $validated['language'],
            'level' => $validated['level'],
            'image_path' => $imagePath,
            'published_at' => now(),
            'duration_minutes' => 0,
            'total_questions' => 1,
        ]);

        return redirect()->route('admin.quiz.index')->with('success', 'Gambar quiz berhasil diupload.');
    }

    public function destroy(Quiz $quiz): RedirectResponse
    {
        if ($quiz->image_path) {
            Storage::disk('public')->delete($quiz->image_path);
        }

        $quiz->delete();

        return redirect()->route('admin.quiz.index')->with('success', 'Quiz berhasil dihapus.');
    }
}
