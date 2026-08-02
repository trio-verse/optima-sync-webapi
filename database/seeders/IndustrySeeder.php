<?php

namespace Database\Seeders;

use App\Models\Industry;
use Illuminate\Database\Seeder;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create specific test industries (use firstOrCreate to avoid duplicates)
        Industry::firstOrCreate(['name' => 'Technology'], ['color' => '#FF5733']);
        Industry::firstOrCreate(['name' => 'Healthcare'], ['color' => '#33FF57']);
        Industry::firstOrCreate(['name' => 'Finance'], ['color' => '#3357FF']);
        Industry::firstOrCreate(['name' => 'Manufacturing'], ['color' => '#F033FF']);
        Industry::firstOrCreate(['name' => 'Education'], ['color' => '#FF33F0']);
        Industry::firstOrCreate(['name' => 'Retail'], ['color' => '#33FFF0']);
        Industry::firstOrCreate(['name' => 'Construction'], ['color' => '#F0FF33']);
        Industry::firstOrCreate(['name' => 'Transportation'], ['color' => '#FF33A0']);
    }
}