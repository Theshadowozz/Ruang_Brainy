<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizResult;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure user id=1 and id=2 exist to avoid foreign key violations
        if (!User::where('id', 1)->exists()) {
            User::insert([
                'id' => 1,
                'name' => 'Admin Brainy',
                'email' => 'admin@brainy.com',
                'password' => Hash::make('password'),
                'role' => 1, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        if (!User::where('id', 2)->exists()) {
            User::insert([
                'id' => 2,
                'name' => 'Siswa Brainy',
                'email' => 'siswa@brainy.com',
                'password' => Hash::make('password'),
                'role' => 2, // Siswa
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Seed Quizzes and their QuizQuestions
        // Quiz 1: Basic Grammar Quiz
        $quiz1 = Quiz::updateOrCreate(
            ['title' => 'Basic Grammar Quiz'],
            [
                'language' => 'Inggris',
                'level' => 'Beginner',
                'duration_minutes' => 15,
                'total_questions' => 10,
            ]
        );

        $q1 = [
            [
                'question' => 'She ___ to school every day.',
                'option_a' => 'go', 'option_b' => 'goes', 'option_c' => 'going', 'option_d' => 'gone',
                'correct_answer' => 'b'
            ],
            [
                'question' => 'They ___ playing football now.',
                'option_a' => 'is', 'option_b' => 'am', 'option_c' => 'are', 'option_d' => 'was',
                'correct_answer' => 'c'
            ],
            [
                'question' => 'I ___ a book yesterday.',
                'option_a' => 'read', 'option_b' => 'reads', 'option_c' => 'reading', 'option_d' => 'will read',
                'correct_answer' => 'a'
            ],
            [
                'question' => '___ you like coffee?',
                'option_a' => 'Does', 'option_b' => 'Do', 'option_c' => 'Is', 'option_d' => 'Are',
                'correct_answer' => 'b'
            ],
            [
                'question' => 'He doesn\'t ___ any money.',
                'option_a' => 'has', 'option_b' => 'have', 'option_c' => 'had', 'option_d' => 'having',
                'correct_answer' => 'b'
            ],
            [
                'question' => 'We ___ French last year.',
                'option_a' => 'study', 'option_b' => 'studies', 'option_c' => 'studied', 'option_d' => 'studying',
                'correct_answer' => 'c'
            ],
            [
                'question' => 'Look! The bird ___ now.',
                'option_a' => 'fly', 'option_b' => 'flies', 'option_c' => 'is flying', 'option_d' => 'flew',
                'correct_answer' => 'c'
            ],
            [
                'question' => 'This is the ___ book I have ever read.',
                'option_a' => 'good', 'option_b' => 'better', 'option_c' => 'best', 'option_d' => 'well',
                'correct_answer' => 'c'
            ],
            [
                'question' => 'She is ___ than her sister.',
                'option_a' => 'tall', 'option_b' => 'taller', 'option_c' => 'tallest', 'option_d' => 'more tall',
                'correct_answer' => 'b'
            ],
            [
                'question' => 'Where ___ you live?',
                'option_a' => 'do', 'option_b' => 'does', 'option_c' => 'are', 'option_d' => 'is',
                'correct_answer' => 'a'
            ]
        ];

        // Delete existing questions for this quiz and recreate
        $quiz1->questions()->delete();
        foreach ($q1 as $q) {
            $quiz1->questions()->create($q);
        }

        // Quiz 2: Intermediate Vocabulary
        $quiz2 = Quiz::updateOrCreate(
            ['title' => 'Intermediate Vocabulary'],
            [
                'language' => 'Inggris',
                'level' => 'Intermediate',
                'duration_minutes' => 20,
                'total_questions' => 15,
            ]
        );

        $q2 = [
            ['question' => 'To "abandon" something means to...', 'option_a' => 'keep it', 'option_b' => 'leave it behind', 'option_c' => 'build it', 'option_d' => 'fix it', 'correct_answer' => 'b'],
            ['question' => 'What is a synonym for "accurate"?', 'option_a' => 'wrong', 'option_b' => 'precise', 'option_c' => 'vague', 'option_d' => 'slow', 'correct_answer' => 'b'],
            ['question' => 'If you are "benevolent", you are...', 'option_a' => 'cruel', 'option_b' => 'rich', 'option_c' => 'kind', 'option_d' => 'angry', 'correct_answer' => 'c'],
            ['question' => 'What does "conclude" mean?', 'option_a' => 'start', 'option_b' => 'finish', 'option_c' => 'delay', 'option_d' => 'skip', 'correct_answer' => 'b'],
            ['question' => 'Select the word that means "to make something better":', 'option_a' => 'damage', 'option_b' => 'improve', 'option_c' => 'ignore', 'option_d' => 'waste', 'correct_answer' => 'b'],
            ['question' => 'A "durable" phone is one that is...', 'option_a' => 'fragile', 'option_b' => 'long-lasting', 'option_c' => 'expensive', 'option_d' => 'small', 'correct_answer' => 'b'],
            ['question' => 'What is the opposite of "expand"?', 'option_a' => 'grow', 'option_b' => 'shrink', 'option_c' => 'stretch', 'option_d' => 'open', 'correct_answer' => 'b'],
            ['question' => 'If you are "fatigued", you feel...', 'option_a' => 'excited', 'option_b' => 'tired', 'option_c' => 'hungry', 'option_d' => 'happy', 'correct_answer' => 'b'],
            ['question' => 'To "imitate" someone is to...', 'option_a' => 'hate them', 'option_b' => 'copy them', 'option_c' => 'help them', 'option_d' => 'teach them', 'correct_answer' => 'b'],
            ['question' => 'What is a synonym for "jealous"?', 'option_a' => 'proud', 'option_b' => 'envious', 'option_c' => 'kind', 'option_d' => 'lazy', 'correct_answer' => 'b'],
            ['question' => 'An "obstacle" is a...', 'option_a' => 'path', 'option_b' => 'barrier', 'option_c' => 'tool', 'option_d' => 'target', 'correct_answer' => 'b'],
            ['question' => 'What does "predict" mean?', 'option_a' => 'remember', 'option_b' => 'guess the future', 'option_c' => 'explain the past', 'option_d' => 'verify', 'correct_answer' => 'b'],
            ['question' => 'If something is "scarce", it is...', 'option_a' => 'common', 'option_b' => 'rare', 'option_c' => 'scary', 'option_d' => 'heavy', 'correct_answer' => 'b'],
            ['question' => 'What is a synonym for "timid"?', 'option_a' => 'brave', 'option_b' => 'shy', 'option_c' => 'loud', 'option_d' => 'strong', 'correct_answer' => 'b'],
            ['question' => 'To "verify" means to...', 'option_a' => 'change', 'option_b' => 'confirm', 'option_c' => 'delete', 'option_d' => 'hide', 'correct_answer' => 'b']
        ];

        $quiz2->questions()->delete();
        foreach ($q2 as $q) {
            $quiz2->questions()->create($q);
        }

        // Quiz 3: Hiragana & Katakana Test
        $quiz3 = Quiz::updateOrCreate(
            ['title' => 'Hiragana & Katakana Test'],
            [
                'language' => 'Jepang',
                'level' => 'Beginner',
                'duration_minutes' => 25,
                'total_questions' => 20,
            ]
        );

        $q3 = [
            ['question' => 'What is the Hiragana for "a"?', 'option_a' => 'あ', 'option_b' => 'い', 'option_c' => 'う', 'option_d' => 'え', 'correct_answer' => 'a'],
            ['question' => 'What is the Hiragana for "i"?', 'option_a' => 'か', 'option_b' => 'い', 'option_c' => 'し', 'option_d' => 'て', 'correct_answer' => 'b'],
            ['question' => 'What is the Hiragana for "u"?', 'option_a' => 'う', 'option_b' => 'お', 'option_c' => 'つ', 'option_d' => 'ん', 'correct_answer' => 'a'],
            ['question' => 'What is the Hiragana for "e"?', 'option_a' => 'え', 'option_b' => 'ぬ', 'option_c' => 'ne', 'option_d' => 'れ', 'correct_answer' => 'a'],
            ['question' => 'What is the Hiragana for "o"?', 'option_a' => 'お', 'option_b' => 'は', 'option_c' => 'ほ', 'option_d' => 'ま', 'correct_answer' => 'a'],
            ['question' => 'What is the Hiragana for "ka"?', 'option_a' => 'か', 'option_b' => 'が', 'option_c' => 'き', 'option_d' => 'く', 'correct_answer' => 'a'],
            ['question' => 'What is the Hiragana for "ki"?', 'option_a' => 'き', 'option_b' => 'ぎ', 'option_c' => 'さ', 'option_d' => 'ち', 'correct_answer' => 'a'],
            ['question' => 'What is the Hiragana for "ku"?', 'option_a' => 'く', 'option_b' => 'け', 'option_c' => 'こ', 'option_d' => 'て', 'correct_answer' => 'a'],
            ['question' => 'What is the Hiragana for "ke"?', 'option_a' => 'け', 'option_b' => 'は', 'option_c' => 'ほ', 'option_d' => 'に', 'correct_answer' => 'a'],
            ['question' => 'What is the Hiragana for "ko"?', 'option_a' => 'こ', 'option_b' => 'た', 'option_c' => 'な', 'option_d' => 'に', 'correct_answer' => 'a'],
            ['question' => 'What is the Katakana for "a"?', 'option_a' => 'ア', 'option_b' => 'イ', 'option_c' => 'ウ', 'option_d' => 'エ', 'correct_answer' => 'a'],
            ['question' => 'What is the Katakana for "i"?', 'option_a' => 'イ', 'option_b' => 'ハ', 'option_c' => 'ト', 'option_d' => 'ニ', 'correct_answer' => 'a'],
            ['question' => 'What is the Katakana for "u"?', 'option_a' => 'ウ', 'option_b' => 'ワ', 'option_c' => 'ヲ', 'option_d' => 'フ', 'correct_answer' => 'a'],
            ['question' => 'What is the Katakana for "e"?', 'option_a' => 'エ', 'option_b' => 'コ', 'option_c' => 'ヨ', 'option_d' => 'ユ', 'correct_answer' => 'a'],
            ['question' => 'What is the Katakana for "o"?', 'option_a' => 'オ', 'option_b' => 'ス', 'option_c' => 'ヌ', 'option_d' => 'ヲ', 'correct_answer' => 'a'],
            ['question' => 'What is the Katakana for "ka"?', 'option_a' => 'カ', 'option_b' => '力', 'option_c' => 'ク', 'option_d' => 'ケ', 'correct_answer' => 'a'],
            ['question' => 'What is the Katakana for "ki"?', 'option_a' => 'キ', 'option_b' => 'ギ', 'option_c' => 'チ', 'option_d' => 'サ', 'correct_answer' => 'a'],
            ['question' => 'What is the Katakana for "ku"?', 'option_a' => 'ク', 'option_b' => 'タ', 'option_c' => 'ヌ', 'option_d' => 'フ', 'correct_answer' => 'a'],
            ['question' => 'What is the Katakana for "ke"?', 'option_a' => 'ケ', 'option_b' => 'レ', 'option_c' => 'ヌ', 'option_d' => 'フ', 'correct_answer' => 'a'],
            ['question' => 'What is the Katakana for "ko"?', 'option_a' => 'コ', 'option_b' => 'ユ', 'option_c' => 'ヨ', 'option_d' => 'ゴ', 'correct_answer' => 'a']
        ];

        $quiz3->questions()->delete();
        foreach ($q3 as $q) {
            $quiz3->questions()->create($q);
        }

        // 3. Seed Quiz Results for user id=1 and id=2
        // - Basic Grammar Quiz -> score 92, completed_at 2026-05-20
        // - Intermediate Vocabulary -> score 85, completed_at 2026-05-18
        // - Hiragana & Katakana Test -> score 78, completed_at 2026-05-15

        $results = [
            // Results for User ID 1
            [
                'user_id' => 1,
                'quiz_id' => $quiz1->id,
                'score' => 92,
                'completed_at' => '2026-05-20 14:00:00'
            ],
            [
                'user_id' => 1,
                'quiz_id' => $quiz2->id,
                'score' => 85,
                'completed_at' => '2026-05-18 10:30:00'
            ],
            [
                'user_id' => 1,
                'quiz_id' => $quiz3->id,
                'score' => 78,
                'completed_at' => '2026-05-15 16:45:00'
            ],

            // Results for User ID 2
            [
                'user_id' => 2,
                'quiz_id' => $quiz1->id,
                'score' => 92,
                'completed_at' => '2026-05-20 14:00:00'
            ],
            [
                'user_id' => 2,
                'quiz_id' => $quiz2->id,
                'score' => 85,
                'completed_at' => '2026-05-18 10:30:00'
            ],
            [
                'user_id' => 2,
                'quiz_id' => $quiz3->id,
                'score' => 78,
                'completed_at' => '2026-05-15 16:45:00'
            ],
        ];

        foreach ($results as $res) {
            QuizResult::updateOrCreate(
                ['user_id' => $res['user_id'], 'quiz_id' => $res['quiz_id']],
                [
                    'score' => $res['score'],
                    'completed_at' => $res['completed_at']
                ]
            );
        }
    }
}
