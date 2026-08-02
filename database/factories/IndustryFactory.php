<?php

namespace Database\Factories;

use App\Models\Industry;
use Illuminate\Database\Eloquent\Factories\Factory;

class IndustryFactory extends Factory
{
    protected $model = Industry::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word() . ' Industry',
            'color' => $this->faker->hexColor(),
        ];
    }
}