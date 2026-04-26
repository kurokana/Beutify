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
        User::updateOrCreate([
            'email' => 'admin@komers.local',
        ], [
            'name' => 'Admin Komers',
            'password' => 'Admin123!',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        User::updateOrCreate([
            'email' => 'user@komers.local',
        ], [
            'name' => 'User Komers',
            'password' => 'User123!',
            'role' => 'user',
            'email_verified_at' => now(),
        ]);
    }
}
