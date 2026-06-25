<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiswaScheduleController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'aktif');

        if (!in_array($activeTab, ['aktif', 'selesai', 'jadwal'], true)) {
            $activeTab = 'aktif';
        }

        return view('siswa.jadwal.index', [
            'activeTab' => $activeTab,
            'activeClasses' => $this->activeClasses(),
            'finishedClasses' => $this->finishedClasses(),
            'weeklySchedules' => $this->weeklySchedules(),
        ]);
    }

    private function activeClasses(): array
    {
        return [
            [
                'title' => 'English Intermediate',
                'level' => 'Intermediate',
                'tutor' => 'Ms Nisa',
                'schedule' => 'Selasa & Kamis, 19:00 - 20:30',
                'progress' => 65,
                'completed_sessions' => 16,
                'total_sessions' => 24,
                'attendance' => 94,
                'average_score' => 87,
                'tasks_done' => 12,
                'tasks_total' => 14,
                'materials' => [
                    ['title' => 'Chapter 1-8 Study Materials', 'meta' => 'PDF, 45 halaman'],
                    ['title' => 'Practice Worksheets', 'meta' => 'PDF, 20 halaman'],
                ],
            ],
            [
                'title' => 'Japanese Beginner',
                'level' => 'Beginner',
                'tutor' => 'Nadia Sensei',
                'schedule' => 'Senin & Rabu, 18:00 - 19:30',
                'progress' => 40,
                'completed_sessions' => 13,
                'total_sessions' => 32,
                'attendance' => 91,
                'average_score' => 82,
                'tasks_done' => 8,
                'tasks_total' => 12,
                'materials' => [
                    ['title' => 'Hiragana & Katakana Guide', 'meta' => 'PDF, 28 halaman'],
                    ['title' => 'Basic Conversation Notes', 'meta' => 'PDF, 16 halaman'],
                ],
            ],
        ];
    }

    private function finishedClasses(): array
    {
        return [
            [
                'title' => 'English Beginner',
                'level' => 'Beginner',
                'tutor' => 'Ms Retno',
                'finished_at' => '15 Maret 2026',
                'final_score' => 88,
                'attendance' => 96,
                'predicate' => 'A',
            ],
            [
                'title' => 'Korean Beginner',
                'level' => 'Beginner',
                'tutor' => 'Ira Ssaem',
                'finished_at' => '22 April 2026',
                'final_score' => 84,
                'attendance' => 93,
                'predicate' => 'A-',
            ],
        ];
    }

    private function weeklySchedules(): array
    {
        return [
            [
                'day' => 'Senin',
                'date' => '22',
                'course' => 'Japanese Beginner',
                'time' => '18:00 - 19:30',
                'tutor' => 'Nadia Sensei',
                'session' => 'Session 14: Kanji Introduction',
                'color' => 'blue',
            ],
            [
                'day' => 'Selasa',
                'date' => '23',
                'course' => 'English Intermediate',
                'time' => '19:00 - 20:30',
                'tutor' => 'Ms Nisa',
                'session' => 'Session 17: Business Communication',
                'color' => 'green',
            ],
            [
                'day' => 'Rabu',
                'date' => '24',
                'course' => 'Japanese Beginner',
                'time' => '18:00 - 19:30',
                'tutor' => 'Nadia Sensei',
                'session' => 'Session 15: Basic Kanji Writing',
                'color' => 'blue',
            ],
            [
                'day' => 'Kamis',
                'date' => '25',
                'course' => 'English Intermediate',
                'time' => '19:00 - 20:30',
                'tutor' => 'Ms Nisa',
                'session' => 'Session 18: Email Writing',
                'color' => 'green',
            ],
        ];
    }
}
