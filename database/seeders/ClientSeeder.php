<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\City;
use App\Models\Industry;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing records to associate with clients
        $organizations = Organization::all();
        $cities = City::all();
        $industries = Industry::all();

        // If no records exist, create some first
        if ($organizations->isEmpty()) {
            $organizations = Organization::factory(5)->create();
        }
        if ($cities->isEmpty()) {
            $cities = City::factory(5)->create();
        }
        if ($industries->isEmpty()) {
            $industries = Industry::factory(5)->create();
        }

        // Create 20 random clients
        Client::factory(20)->create([
            'organization_id' => function () use ($organizations) {
                return $organizations->random()->id;
            },
            'city_id' => function () use ($cities) {
                return $cities->random()->id;
            },
            'industry_id' => function () use ($industries) {
                return $industries->random()->id;
            }
        ]);

        // Create specific test clients (use firstOrCreate to avoid duplicates)
        $firstOrg = $organizations->first();
        $firstCity = $cities->first();
        $firstIndustry = $industries->first();

        if ($firstOrg && $firstCity && $firstIndustry) {
            Client::firstOrCreate(
                ['email' => 'test-client@example.com'],
                [
                    'organization_id' => $firstOrg->id,
                    'name' => 'Test Client Company',
                    'phone' => '+1234567890',
                    'whatsapp' => '+1234567890',
                    'website' => 'https://test-client.example.com',
                    'address' => '123 Test Street, Test City',
                    'city_id' => $firstCity->id,
                    'industry_id' => $firstIndustry->id,
                    'client_type' => 'company',
                    'notes' => 'This is a test client for development purposes',
                ]
            );

            Client::firstOrCreate(
                ['email' => 'individual-client@example.com'],
                [
                    'organization_id' => $firstOrg->id,
                    'name' => 'John Doe',
                    'phone' => '+1987654321',
                    'whatsapp' => '+1987654321',
                    'website' => null,
                    'address' => '456 Main Street, Test Town',
                    'city_id' => $firstCity->id,
                    'industry_id' => $firstIndustry->id,
                    'client_type' => 'individual',
                    'notes' => 'Individual test client',
                ]
            );
        }
    }
}
