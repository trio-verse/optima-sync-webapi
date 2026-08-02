<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\City;
use App\Models\Industry;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $clientTypes = ['company', 'individual', 'government', 'charity', 'agency'];

        return [
            'organization_id' => Organization::factory(),
            'name' => $this->faker->company(),
            'email' => $this->faker->unique()->companyEmail(),
            'phone' => $this->faker->phoneNumber(),
            'whatsapp' => $this->faker->phoneNumber(),
            'website' => $this->faker->domainName(),
            'address' => $this->faker->address(),
            'city_id' => City::factory(),
            'industry_id' => Industry::factory(),
            'client_type' => $this->faker->randomElement($clientTypes),
            'notes' => $this->faker->paragraph(),
        ];
    }
}
