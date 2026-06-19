<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaQuizController extends Controller
{
    /**
     * Display a listing of quizzes and recent quiz results.
     */
    public function index()
    {
        $quizzes = Quiz::all();
        
        $quizResults = QuizResult::where('user_id', Auth::id())
            ->with('quiz')
            ->orderBy('completed_at', 'desc')
            ->get();

        return view('siswa.quiz', compact('quizzes', 'quizResults'));
    }

    /**
     * Start a specific quiz.
     */
    public function start($id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        $questions = $quiz->questions;

        return view('siswa.quiz-start', compact('quiz', 'questions'));
    }

    /**
     * Submit and score the quiz.
     */
    public function submit(Request $request, $id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        $questions = $quiz->questions;
        $submittedAnswers = $request->input('answers', []);

        $correctCount = 0;
        foreach ($questions as $question) {
            $submitted = $submittedAnswers[$question->id] ?? null;
            if ($submitted === $question->correct_answer) {
                $correctCount++;
            }
        }

        $totalQuestions = count($questions);
        $score = $totalQuestions > 0 ? (int) round(($correctCount / $totalQuestions) * 100) : 0;

        QuizResult::updateOrCreate([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
        ], [
            'score' => $score,
            'completed_at' => now(),
        ]);

        return redirect()->route('siswa.quiz.index')->with('success', "Quiz \"{$quiz->title}\" selesai dikerjakan! Skor Anda: {$score}.");
    }
}
