<?php

namespace App\Http\Controllers;

class LandingController extends Controller
{
    public function __invoke()
    {
        return view('landing', [
            'courses' => [
                [
                    'title' => 'Bahasa Inggris',
                    'image' => 'englishpng.png',
                    'badge' => 'English Class',
                    'description' => 'Program bahasa Inggris untuk mengembangkan kemampuan speaking, listening, reading, dan writing secara bertahap.',
                    'details' => [
                        'Tersedia untuk berbagai tingkat kemampuan',
                        'Materi percakapan dan tata bahasa',
                        'Pembelajaran aktif dan interaktif',
                    ],
                ],
                [
                    'title' => 'Bahasa Korea',
                    'image' => 'korean.png',
                    'badge' => 'Korean Class',
                    'description' => 'Program bahasa Korea untuk mempelajari hangeul, kosakata, pelafalan, dan percakapan sehari-hari.',
                    'details' => [
                        'Belajar hangeul dari dasar',
                        'Latihan membaca dan berbicara',
                        'Pengenalan bahasa dan budaya Korea',
                    ],
                ],
                [
                    'title' => 'Bahasa Jepang',
                    'image' => 'jepang.png',
                    'badge' => 'Japanese Class',
                    'description' => 'Program bahasa Jepang yang membahas huruf, kosakata, tata bahasa, dan percakapan sehari-hari.',
                    'details' => [
                        'Belajar hiragana dan katakana',
                        'Latihan kosakata dan percakapan',
                        'Pengenalan bahasa dan budaya Jepang',
                    ],
                ],
            ],
            'tutors' => [
                [
                    'name' => 'Adelia Delarosa S,Pd., Gr',
                    'role' => 'English Tutor',
                    'nickname' => 'Ms Adel',
                    'image' => 'Adelia Delarosa S,Pd., Gr - English Tutor - Ms Adel.jpeg',
                ],
                [
                    'name' => 'Titin Hajri, M.Ed in Diglearn',
                    'role' => 'Owner Brainy Course',
                    'nickname' => 'Ms Titin',
                    'image' => 'Titin Hajri, M.Ed in Diglearn - Owner Brainy Course - Ms Titin.jpeg',
                ],
                [
                    'name' => 'Ihya Maghfirah S.Kep',
                    'role' => 'Korean Tutor',
                    'nickname' => 'Ira Ssaem',
                    'image' => 'Ihya Maghfirah S.Kep - Korean Tutor - Ira Ssaem.jpeg',
                ],
                [
                    'name' => 'Nadia Indah Sari, S.Pd',
                    'role' => 'Japanese Tutor',
                    'nickname' => 'Nadia Sensei',
                    'image' => 'Nadia Indah Sari, S.Pd - Japanese Tutor - Nadia Sensei.jpeg',
                ],
                [
                    'name' => 'Retno Suhermen, S.s',
                    'role' => 'English Tutor',
                    'nickname' => 'Ms Retno',
                    'image' => 'Retno Suhermen, S.s - English Tutor - Ms Retno.jpeg',
                ],
                [
                    'name' => 'Annisa Nur Umatil Iqbal, S.Pd., Gr',
                    'role' => 'English Tutor',
                    'nickname' => 'Ms Nisa',
                    'image' => 'Annisa Nur Umatil Iqbal, S.Pd., Gr - English Tutor - Ms Nisa.jpeg',
                ],
            ],
        ]);
    }
}
