<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Connection;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing connections
        $connections = Connection::all();

        // Get existing users
        $users = User::all();

        if ($connections->isEmpty()) {
            $this->command->info('No connections found. Please run ClientSeeder and ConnectionSeeder first.');
            return;
        }

        if ($users->isEmpty()) {
            $this->command->info('No users found. Please run UserSeeder first.');
            return;
        }

        $activityTypes = [
            'Initial contact made with client',
            'Follow-up meeting scheduled',
            'Product demonstration completed',
            'Price quote sent to client',
            'Contract negotiation in progress',
            'Client requested more information',
            'Deal closed successfully',
            'Follow-up call scheduled',
            'Client expressed concerns',
            'Additional requirements discussed',
            'Competitor analysis shared',
            'Custom proposal created',
            'Client onboarding initiated',
            'Training session scheduled',
            'Support request handled',
        ];

        $this->command->info('Creating activities for connections...');

        // Create 3-5 activities for each connection
        foreach ($connections as $connection) {
            $numActivities = rand(3, 5);

            for ($i = 0; $i < $numActivities; $i++) {
                Activity::create([
                    'connection_id' => $connection->id,
                    'user_id' => $users->random()->id,
                    'organization_id' => $connection->client->organization_id,
                    'content' => $activityTypes[array_rand($activityTypes)] . ' on ' . now()->subDays(rand(0, 30))->format('Y-m-d'),
                    'metadata' => rand(0, 1) ? ['follow_up_required' => true, 'priority' => ['low', 'medium', 'high'][rand(0, 2)]] : null,
                    'created_at' => now()->subDays(rand(0, 30)),
                    'updated_at' => now()->subDays(rand(0, 30)),
                ]);
            }
        }

        $this->command->info('Created ' . Activity::count() . ' activities.');
    }
}