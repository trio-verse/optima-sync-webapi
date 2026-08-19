<?php

namespace Database\Factories;

use App\Models\Content;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Content>
 */
class ContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(5, true),
            'type' => fake()->randomElement(['article', 'video', 'image', 'audio']),
            'script' => fake()->paragraph(),
            'description' => fake()->paragraph(),
            'cost' => fake()->numberBetween(0, 1000),
            'status' => 'draft',
        ];
    }
}
