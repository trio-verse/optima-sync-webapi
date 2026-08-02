<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users to associate with organizations
        $users = User::all();

        if ($users->isEmpty()) {
            // If no users exist, create one first
            $user = User::factory()->create();
            $users = User::all();
        }

        // Create 15 organizations with random users
        Organization::factory(15)->create([
            'user_id' => function () use ($users) {
                return $users->random()->id;
            }
        ]);

        // Create a specific test organization
        $adminUser = User::where('email', 'admin@example.com')->first();

        if ($adminUser) {
            Organization::firstOrCreate(
                ['email' => 'test-org@example.com'],
                [
                    'name' => 'Test Organization',
                    'phone' => '+1234567890',
                    'description' => 'This is a test organization',
                    'address' => '123 Test Street, Test City',
                    'user_id' => $adminUser->id,
                ]
            );
        }
    }
}