<?php

namespace Database\Factories;

use App\Models\OtpAuthentication;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OtpAuthentication>
 */
class OtpAuthenticationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'otp' => rand(100000, 999999),
            'expires_at' => now()->addMinutes(5),
        ];
    }
}
