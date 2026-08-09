<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create specific test cities (use firstOrCreate to avoid duplicates)
        City::firstOrCreate(['name' => 'New York'], ['color' => '#FF0000', 'organization_id' =>     Organization::get(['id'])->random()->id]        );
        City::firstOrCreate(['name' => 'Los Angeles'], ['color' => '#00FF00', 'organization_id' =>  Organization::get(['id'])->random()->id]     );
        City::firstOrCreate(['name' => 'Chicago'], ['color' => '#0000FF', 'organization_id' =>      Organization::get(['id'])->random()->id]         );
        City::firstOrCreate(['name' => 'Houston'], ['color' => '#FFFF00', 'organization_id' =>      Organization::get(['id'])->random()->id]         );
        City::firstOrCreate(['name' => 'Phoenix'], ['color' => '#FF00FF', 'organization_id' =>      Organization::get(['id'])->random()->id]         );
        City::firstOrCreate(['name' => 'Philadelphia'], ['color' => '#00FFFF', 'organization_id' => Organization::get(['id'])->random()->id]    );
        City::firstOrCreate(['name' => 'San Antonio'], ['color' => '#800000', 'organization_id' =>  Organization::get(['id'])->random()->id]     );
        City::firstOrCreate(['name' => 'San Diego'], ['color' => '#008000', 'organization_id' =>    Organization::get(['id'])->random()->id]       );
        City::firstOrCreate(['name' => 'Dallas'], ['color' => '#000080', 'organization_id' =>       Organization::get(['id'])->random()->id]          );
        City::firstOrCreate(['name' => 'San Jose'], ['color' => '#808000', 'organization_id' =>     Organization::get(['id'])->random()->id]        );
    }
}