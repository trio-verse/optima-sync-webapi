<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 random users
        User::factory(10)->create();

        // Create a specific test user (use firstOrCreate to avoid duplicates)
        $user = User::firstOrCreate([
            'email' => 'admin@example.com'
        ], [
            'name' => 'Admin User',
            'phone' => '+1234567890',
            'email_verified_at' => now(),
        ]);

        Log::info("new User : " . $user . " one year token : " . $user->createToken('one-year', ['*'], now()->addYear())->plainTextToken);
    }
}