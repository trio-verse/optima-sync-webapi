<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create specific test cities (use firstOrCreate to avoid duplicates)
        City::firstOrCreate(['name' => 'New York'], ['color' => '#FF0000']);
        City::firstOrCreate(['name' => 'Los Angeles'], ['color' => '#00FF00']);
        City::firstOrCreate(['name' => 'Chicago'], ['color' => '#0000FF']);
        City::firstOrCreate(['name' => 'Houston'], ['color' => '#FFFF00']);
        City::firstOrCreate(['name' => 'Phoenix'], ['color' => '#FF00FF']);
        City::firstOrCreate(['name' => 'Philadelphia'], ['color' => '#00FFFF']);
        City::firstOrCreate(['name' => 'San Antonio'], ['color' => '#800000']);
        City::firstOrCreate(['name' => 'San Diego'], ['color' => '#008000']);
        City::firstOrCreate(['name' => 'Dallas'], ['color' => '#000080']);
        City::firstOrCreate(['name' => 'San Jose'], ['color' => '#808000']);
    }
}