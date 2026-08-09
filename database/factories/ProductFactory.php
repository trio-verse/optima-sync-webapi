<?php

namespace Database\Factories;

use App\Models\Organization;
use App\Models\Product;
use App\Singleton\TenantManager;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);
        $organization
            = Organization::factory()->create();
        $tenantManager = app(TenantManager::class);
        $tenantManager->setOrganizationId($organization->id);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'description' => $this->faker->paragraph(),
            'organization_id' => $organization->id,
        ];
        // dd($organization->id);

    }
}