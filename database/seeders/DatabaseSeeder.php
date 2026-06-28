<?php

namespace Database\Seeders;

use App\Models\CourseClass;
use App\Models\Schedule;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(['email' => 'test@example.com'], [
            'name' => 'Test User',
            'password' => '123456',
            'role' => User::ROLE_TUTOR,
        ]);

        User::updateOrCreate(['email' => 'admin@example.com'], [
            'name' => 'Admin Brainy',
            'password' => '123456',
            'role' => User::ROLE_ADMIN,
        ]);

        $tutors = collect([
            ['name' => 'Adelia Delarosa', 'email' => 'adelia@brainy.test', 'phone_number' => '081234567801', 'expertise' => 'Bahasa Inggris'],
            ['name' => 'Nadia Indah Sari', 'email' => 'nadia@brainy.test', 'phone_number' => '081234567802', 'expertise' => 'Bahasa Jepang'],
            ['name' => 'Ihya Maghfirah', 'email' => 'ihya@brainy.test', 'phone_number' => '081234567803', 'expertise' => 'Bahasa Korea'],
        ])->map(fn (array $data) => Tutor::updateOrCreate(['email' => $data['email']], $data));

        $classData = [
            [
                'name' => 'English for Beginners',
                'language' => 'Inggris',
                'level' => 'Beginner',
                'tutor_id' => $tutors[0]->id,
                'price' => 1500000,
                'description' => 'Kelas dasar bahasa Inggris dengan fokus pada percakapan, kosakata, dan tata bahasa sehari-hari.',
                'day' => 'Senin & Rabu',
                'start_time' => '19:00',
                'end_time' => '20:30',
                'room' => 'Ruang A',
                'capacity' => 15,
            ],
            [
                'name' => 'Japanese Beginner',
                'language' => 'Jepang',
                'level' => 'Beginner',
                'tutor_id' => $tutors[1]->id,
                'price' => 2000000,
                'description' => 'Belajar hiragana, katakana, kosakata, dan percakapan dasar bahasa Jepang.',
                'day' => 'Selasa & Kamis',
                'start_time' => '18:00',
                'end_time' => '19:30',
                'room' => 'Ruang B',
                'capacity' => 12,
            ],
            [
                'name' => 'Korean Beginner',
                'language' => 'Korea',
                'level' => 'Beginner',
                'tutor_id' => $tutors[2]->id,
                'price' => 2000000,
                'description' => 'Kelas pengenalan hangeul, pelafalan, dan percakapan dasar bahasa Korea.',
                'day' => 'Jumat & Sabtu',
                'start_time' => '16:00',
                'end_time' => '17:30',
                'room' => 'Ruang C',
                'capacity' => 12,
            ],
        ];

        foreach ($classData as $data) {
            $scheduleData = collect($data)->only([
                'day',
                'start_time',
                'end_time',
                'room',
                'capacity',
            ])->all();

            $course = CourseClass::updateOrCreate(
                ['name' => $data['name']],
                collect($data)->except(['day', 'start_time', 'end_time', 'room', 'capacity'])->all()
            );

            Schedule::updateOrCreate(
                ['class_id' => $course->id, 'day' => $data['day']],
                array_merge($scheduleData, [
                    'start_date' => '2026-07-01',
                    'end_date' => '2026-09-30',
                ])
            );
        }
    }
}
