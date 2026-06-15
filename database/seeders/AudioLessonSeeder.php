<?php

namespace Database\Seeders;

use App\Models\AudioLesson;
use Illuminate\Database\Seeder;

class AudioLessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $samples = [
            [
                'title' => 'Introduction & Greetings',
                'language' => 'Inggris',
                'level' => 'Beginner',
                'duration' => '5:30',
                'audio_file' => 'audio/introduction_greetings.mp3',
                'transcript' => "Hello and welcome! In this lesson, we will learn basic greetings in English, such as hello, good morning, how are you, and nice to meet you. Remember to practice speaking them out loud!",
            ],
            [
                'title' => 'Daily Conversations',
                'language' => 'Inggris',
                'level' => 'Beginner',
                'duration' => '7:45',
                'audio_file' => 'audio/daily_conversations.mp3',
                'transcript' => "Hi! How was your day? It was great, thank you. Let's talk about daily routines and simple English conversation practices for everyday life, focusing on habits and standard responses.",
            ],
            [
                'title' => 'Hiragana Pronunciation',
                'language' => 'Jepang',
                'level' => 'Beginner',
                'duration' => '10:20',
                'audio_file' => 'audio/hiragana_pronunciation.mp3',
                'transcript' => "Konnichiwa! Welcome to Japanese Hiragana Pronunciation class. Today, we will practice pronouncing A, I, U, E, O, and other Hiragana characters clearly. Pay attention to vowel length!",
            ],
            [
                'title' => 'Korean Basic Phrases',
                'language' => 'Korea',
                'level' => 'Beginner',
                'duration' => '6:15',
                'audio_file' => 'audio/korean_basic_phrases.mp3',
                'transcript' => "Annyeonghaseyo! Today we will cover essential Korean phrases for beginners: Hello, Thank you, Excuse me, and Goodbye. Let's practice together with native pronunciation.",
            ],
        ];

        foreach ($samples as $sample) {
            AudioLesson::updateOrCreate(
                ['title' => $sample['title'], 'language' => $sample['language']],
                $sample
            );
        }
    }
}
