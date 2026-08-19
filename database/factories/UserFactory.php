<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            // 'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user is an admin.
     */
    public function admin(): static
    {
        return $this->afterCreating(function (User $user) {
            // Create an organization for this admin
            $organization = \App\Models\Organization::factory()->create(['user_id' => $user->id]);
            
            // Attach user to organization as admin
            $user->organizations()->attach($organization->id, ['role' => 'admin']);
        });
    }

    /**
     * Indicate that the user is a member.
     */
    public function member(): static
    {
        return $this->afterCreating(function (User $user) {
            // Attach user to an existing organization as member
            $organization = \App\Models\Organization::factory()->create();
            $user->organizations()->attach($organization->id, ['role' => 'member']);
        });
    }
}
