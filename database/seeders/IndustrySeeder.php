<?php

namespace Database\Seeders;

use App\Models\Industry;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create specific test industries (use firstOrCreate to avoid duplicates)
        Industry::firstOrCreate(['name' => 'Technology'], ['color' => '#FF5733', 'organization_id' => Organization::get(['id'])->random()->id]);
        Industry::firstOrCreate(['name' => 'Healthcare'], ['color' => '#33FF57', 'organization_id' => Organization::get(['id'])->random()->id]);
        Industry::firstOrCreate(['name' => 'Finance'], ['color' => '#3357FF', 'organization_id' => Organization::get(['id'])->random()->id]);
        Industry::firstOrCreate(['name' => 'Manufacturing'], ['color' => '#F033FF', 'organization_id' => Organization::get(['id'])->random()->id]);
        Industry::firstOrCreate(['name' => 'Education'], ['color' => '#FF33F0', 'organization_id' => Organization::get(['id'])->random()->id]);
        Industry::firstOrCreate(['name' => 'Retail'], ['color' => '#33FFF0', 'organization_id' => Organization::get(['id'])->random()->id]);
        Industry::firstOrCreate(['name' => 'Construction'], ['color' => '#F0FF33', 'organization_id' => Organization::get(['id'])->random()->id]);
        Industry::firstOrCreate(['name' => 'Transportation'], ['color' => '#FF33A0', 'organization_id' => Organization::get(['id'])->random()->id]);
    }
}