<?php

namespace Database\Factories;

use App\Models\Campain;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Campain>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'status' => 'draft',
            'target' => fake()->word(),
        ];
    }
}
