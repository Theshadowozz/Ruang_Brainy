<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiswaCourseController extends Controller
{
    public function index(Request $request)
    {
        $filterBahasa = $request->query('bahasa', '');
        $filterLevel = $request->query('level', '');

        $courses = collect($this->dummyCourses());

        if (in_array($filterBahasa, ['Inggris', 'Jepang', 'Korea'], true)) {
            $courses = $courses->where('language', $filterBahasa);
        } else {
            $filterBahasa = '';
        }

        if (in_array($filterLevel, ['Beginner', 'Intermediate', 'Advance'], true)) {
            $courses = $courses->where('level', $filterLevel);
        } else {
            $filterLevel = '';
        }

        $languageOrder = ['Inggris' => 1, 'Jepang' => 2, 'Korea' => 3];
        $levelOrder = ['Beginner' => 1, 'Intermediate' => 2, 'Advance' => 3];

        $courses = $courses
            ->sortBy(fn ($course) => ($languageOrder[$course['language']] * 10) + $levelOrder[$course['level']])
            ->values();

        return view('siswa.kelas-kursus.index', compact('courses', 'filterBahasa', 'filterLevel'));
    }

    public function show(string $slug)
    {
        $course = collect($this->dummyCourses())->firstWhere('slug', $slug);

        abort_unless($course, 404);

        return view('siswa.kelas-kursus.show', compact('course'));
    }

    private function dummyCourses(): array
    {
        return [
            [
                'slug' => 'english-beginner',
                'language' => 'Inggris',
                'level' => 'Beginner',
                'title' => 'English for Beginners',
                'description' => 'Mulai perjalanan belajar bahasa Inggris dari dasar.',
                'capacity' => '12/15 siswa',
                'schedule' => 'Senin & Rabu, 19:00 - 20:30',
                'duration' => '3 bulan',
                'sessions' => '24 pertemuan',
                'start_date' => '1/7/2026',
                'price' => 125000,
                'status' => 'Trial Tersedia',
                'tutor' => [
                    'name' => 'Retno Suhermen, S.s',
                    'display_name' => 'Ms Retno',
                    'experience' => '8 tahun pengalaman',
                    'bio' => 'Tutor bahasa Inggris dengan fokus percakapan dasar dan grammar praktis.',
                    'email' => 'retno@brainy.com',
                    'photo' => 'images/Retno Suhermen, S.s - English Tutor - Ms Retno.jpeg',
                ],
            ],
            [
                'slug' => 'english-intermediate',
                'language' => 'Inggris',
                'level' => 'Intermediate',
                'title' => 'English Intermediate',
                'description' => 'Tingkatkan kemampuan berbicara, membaca, dan menulis.',
                'capacity' => '10/15 siswa',
                'schedule' => 'Selasa & Kamis, 19:00 - 20:30',
                'duration' => '3 bulan',
                'sessions' => '24 pertemuan',
                'start_date' => '3/7/2026',
                'price' => 155000,
                'status' => 'Trial Tersedia',
                'tutor' => [
                    'name' => 'Annisa Nur Umatil Iqbal, S.Pd., Gr',
                    'display_name' => 'Ms Nisa',
                    'experience' => '7 tahun pengalaman',
                    'bio' => 'Tutor bahasa Inggris untuk penguatan speaking, reading, dan writing.',
                    'email' => 'nisa@brainy.com',
                    'photo' => 'images/Annisa Nur Umatil Iqbal, S.Pd., Gr - English Tutor - Ms Nisa.jpeg',
                ],
            ],
            [
                'slug' => 'english-advance',
                'language' => 'Inggris',
                'level' => 'Advance',
                'title' => 'English Advance',
                'description' => 'Kuasai bahasa Inggris untuk kebutuhan akademik dan profesional.',
                'capacity' => '8/12 siswa',
                'schedule' => 'Rabu & Jumat, 19:00 - 20:30',
                'duration' => '3 bulan',
                'sessions' => '24 pertemuan',
                'start_date' => '8/7/2026',
                'price' => 195000,
                'status' => 'Trial Tersedia',
                'tutor' => [
                    'name' => 'Adelia Delarosa S,Pd., Gr',
                    'display_name' => 'Ms Adel',
                    'experience' => '6 tahun pengalaman',
                    'bio' => 'Tutor bahasa Inggris untuk diskusi lanjutan dan komunikasi profesional.',
                    'email' => 'adel@brainy.com',
                    'photo' => 'images/Adelia Delarosa S,Pd., Gr - English Tutor - Ms Adel.jpeg',
                ],
            ],
            [
                'slug' => 'japanese-beginner',
                'language' => 'Jepang',
                'level' => 'Beginner',
                'title' => 'Japanese for Beginners',
                'description' => 'Belajar Hiragana, Katakana, dan percakapan dasar.',
                'capacity' => '11/15 siswa',
                'schedule' => 'Senin & Rabu, 18:00 - 19:30',
                'duration' => '4 bulan',
                'sessions' => '32 pertemuan',
                'start_date' => '2/7/2026',
                'price' => 135000,
                'status' => 'Trial Tersedia',
                'tutor' => [
                    'name' => 'Nadia Indah Sari, S.Pd',
                    'display_name' => 'Nadia Sensei',
                    'experience' => '10 tahun pengalaman',
                    'bio' => 'Tutor bahasa Jepang untuk dasar tulisan, kosakata, dan percakapan.',
                    'email' => 'nadia@brainy.com',
                    'photo' => 'images/Nadia Indah Sari, S.Pd - Japanese Tutor - Nadia Sensei.jpeg',
                ],
            ],
            [
                'slug' => 'japanese-intermediate',
                'language' => 'Jepang',
                'level' => 'Intermediate',
                'title' => 'Japanese Intermediate',
                'description' => 'Pelajari Kanji, tata bahasa menengah, dan percakapan aktif.',
                'capacity' => '7/12 siswa',
                'schedule' => 'Selasa & Kamis, 18:00 - 19:30',
                'duration' => '4 bulan',
                'sessions' => '32 pertemuan',
                'start_date' => '3/7/2026',
                'price' => 165000,
                'status' => 'Trial Tersedia',
                'tutor' => [
                    'name' => 'Nadia Indah Sari, S.Pd',
                    'display_name' => 'Nadia Sensei',
                    'experience' => '10 tahun pengalaman',
                    'bio' => 'Tutor bahasa Jepang untuk struktur kalimat dan latihan komunikasi.',
                    'email' => 'nadia@brainy.com',
                    'photo' => 'images/Nadia Indah Sari, S.Pd - Japanese Tutor - Nadia Sensei.jpeg',
                ],
            ],
            [
                'slug' => 'japanese-advance',
                'language' => 'Jepang',
                'level' => 'Advance',
                'title' => 'Japanese Advance',
                'description' => 'Latihan diskusi, membaca artikel, dan persiapan level lanjutan.',
                'capacity' => '6/10 siswa',
                'schedule' => 'Rabu & Jumat, 18:00 - 19:30',
                'duration' => '4 bulan',
                'sessions' => '32 pertemuan',
                'start_date' => '6/7/2026',
                'price' => 190000,
                'status' => 'Trial Tersedia',
                'tutor' => [
                    'name' => 'Nadia Indah Sari, S.Pd',
                    'display_name' => 'Nadia Sensei',
                    'experience' => '10 tahun pengalaman',
                    'bio' => 'Tutor bahasa Jepang untuk percakapan lanjutan dan pemahaman teks.',
                    'email' => 'nadia@brainy.com',
                    'photo' => 'images/Nadia Indah Sari, S.Pd - Japanese Tutor - Nadia Sensei.jpeg',
                ],
            ],
            [
                'slug' => 'korean-beginner',
                'language' => 'Korea',
                'level' => 'Beginner',
                'title' => 'Korean for Beginners',
                'description' => 'Mulai dengan Hangul, pelafalan, dan percakapan sehari-hari.',
                'capacity' => '14/15 siswa',
                'schedule' => 'Senin & Kamis, 19:00 - 20:30',
                'duration' => '4 bulan',
                'sessions' => '32 pertemuan',
                'start_date' => '1/7/2026',
                'price' => 145000,
                'status' => 'Trial Tersedia',
                'tutor' => [
                    'name' => 'Ihya Maghfirah S.Kep',
                    'display_name' => 'Ira Ssaem',
                    'experience' => '7 tahun pengalaman',
                    'bio' => 'Tutor bahasa Korea untuk Hangul, listening dasar, dan percakapan ringan.',
                    'email' => 'ira@brainy.com',
                    'photo' => 'images/Ihya Maghfirah S.Kep - Korean Tutor - Ira Ssaem.jpeg',
                ],
            ],
            [
                'slug' => 'korean-intermediate',
                'language' => 'Korea',
                'level' => 'Intermediate',
                'title' => 'Korean Intermediate',
                'description' => 'Tingkatkan kemampuan membaca, menulis, dan percakapan.',
                'capacity' => '9/12 siswa',
                'schedule' => 'Rabu & Jumat, 19:00 - 20:30',
                'duration' => '4 bulan',
                'sessions' => '32 pertemuan',
                'start_date' => '4/7/2026',
                'price' => 170000,
                'status' => 'Trial Tersedia',
                'tutor' => [
                    'name' => 'Ihya Maghfirah S.Kep',
                    'display_name' => 'Ira Ssaem',
                    'experience' => '7 tahun pengalaman',
                    'bio' => 'Tutor bahasa Korea untuk grammar menengah dan percakapan terarah.',
                    'email' => 'ira@brainy.com',
                    'photo' => 'images/Ihya Maghfirah S.Kep - Korean Tutor - Ira Ssaem.jpeg',
                ],
            ],
            [
                'slug' => 'korean-advance',
                'language' => 'Korea',
                'level' => 'Advance',
                'title' => 'Korean Advance',
                'description' => 'Pendalaman diskusi, ekspresi formal, dan pemahaman budaya.',
                'capacity' => '5/10 siswa',
                'schedule' => 'Selasa & Jumat, 19:00 - 20:30',
                'duration' => '4 bulan',
                'sessions' => '32 pertemuan',
                'start_date' => '7/7/2026',
                'price' => 185000,
                'status' => 'Trial Tersedia',
                'tutor' => [
                    'name' => 'Ihya Maghfirah S.Kep',
                    'display_name' => 'Ira Ssaem',
                    'experience' => '7 tahun pengalaman',
                    'bio' => 'Tutor bahasa Korea untuk percakapan lanjutan dan pemahaman konteks.',
                    'email' => 'ira@brainy.com',
                    'photo' => 'images/Ihya Maghfirah S.Kep - Korean Tutor - Ira Ssaem.jpeg',
                ],
            ],
        ];
    }
}
