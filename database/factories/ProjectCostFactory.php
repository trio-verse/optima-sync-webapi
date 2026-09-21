<?php

namespace Database\Factories;

use App\Models\ProjectCost;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProjectCost>
 */
class ProjectCostFactory extends Factory
{
    protected $model = ProjectCost::class;

    public function definition(): array
    {
        return [
            'project_id' => 1,
            'name' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'quantity' => fake()->numberBetween(1, 40),
            'amount' => number_format(fake()->randomFloat(2, 25, 200), 2, '.', ''),
        ];
    }

    /**
     * Build a fake-persistence DTO array (no database).
     */
    public static function dto(int $id, int $projectId, int $versionId, array $overrides = []): array
    {
        $base = (new static)->definition();

        return array_merge($base, [
            'id' => $id,
            'project_id' => $projectId,
            'project_version_id' => $versionId,
            'name' => $overrides['name'] ?? 'Development Hours',
            'description' => $overrides['description'] ?? 'Backend and frontend implementation',
            'quantity' => $overrides['quantity'] ?? 40,
            'amount' => $overrides['amount'] ?? '50.00',
            'created_at' => '2026-09-01T10:00:00.000000Z',
            'updated_at' => '2026-09-01T10:00:00.000000Z',
        ], $overrides);
    }
}
