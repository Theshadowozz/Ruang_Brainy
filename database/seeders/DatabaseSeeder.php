<?php

namespace Database\Seeders;

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
        // Seed Admin User
        

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '123456',
            'role' => User::ROLE_TUTOR,
        ]);

        User::factory()->create([
            'name' => 'Admin Brainy',
            'email' => 'admin@example.com',
            'password' => '123456',
            'role' => User::ROLE_ADMIN,
        ]);
    }
}
