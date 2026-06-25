<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaQuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::query()
            ->latest('published_at')
            ->latest()
            ->get();

        $answers = QuizResult::where('user_id', Auth::id())
            ->with('quiz')
            ->latest('answered_at')
            ->get()
            ->keyBy('quiz_id');

        return view('siswa.quiz', compact('quizzes', 'answers'));
    }

    public function answer(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'answer_text' => ['required', 'string', 'max:5000'],
        ]);

        QuizResult::updateOrCreate([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
        ], [
            'answer_text' => $validated['answer_text'],
            'answered_at' => now(),
            'score' => 0,
            'completed_at' => now(),
        ]);

        return redirect()
            ->route('siswa.quiz.index')
            ->with('success', "Jawaban untuk \"{$quiz->title}\" berhasil dikirim ke admin.");
    }
}
