<?php

namespace Database\Factories;

use App\Models\Connection;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Connection>
 */
class ConnectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'client_id' => \App\Models\Client::factory(),
            'product_id' => \App\Models\Product::factory(),
            'stage' => \App\Enums\enConnectionStages::LEAD->value,
            'channel_id' => null,
            'assignee_id' => null,
            'initiated_by' => null,
        ];
    }
}
