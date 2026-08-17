<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\Connection;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Activity::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'connection_id' => Connection::factory(),
            'user_id' => User::factory(),
            'content' => $this->faker->paragraph(2),
            'metadata' => null,
        ];
    }

    /**
     * Set the connection for the activity.
     */
    public function forConnection(Connection $connection): static
    {
        return $this->state(fn(array $attributes) => [
            'connection_id' => $connection->id,
        ]);
    }

    /**
     * Set the user for the activity.
     */
    public function forUser(User $user): static
    {
        return $this->state(fn(array $attributes) => [
            'user_id' => $user->id,
        ]);
    }

    /**
     * Add metadata to the activity.
     */
    public function withMetadata(array $metadata): static
    {
        return $this->state(fn(array $attributes) => [
            'metadata' => $metadata,
        ]);
    }
}