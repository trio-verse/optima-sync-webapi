<?php

namespace Database\Factories;

use App\Enums\enProjectSource;
use App\Enums\enProjectStatus;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $subTotal = fake()->randomFloat(2, 5000, 50000);
        $profit = fake()->numberBetween(10, 30);

        return [
            'reference_id' => 'PRJ-' . fake()->unique()->numerify('2026-###'),
            'organization_id' => 1,
            'client_id' => 1,
            'current_version_id' => 1,
            'status' => enProjectStatus::NEW->value,
            'created_by' => 1,
            'source' => enProjectSource::INTERNAL->value,
            'sub_total' => number_format($subTotal, 2, '.', ''),
            'profit_percentage' => $profit,
            'total_amount' => number_format($subTotal * (1 + $profit / 100), 2, '.', ''),
        ];
    }

    /**
     * Build a fake-persistence DTO array (no database).
     */
    public static function dto(int $id, array $overrides = []): array
    {
        $base = (new static)->definition();

        return array_merge($base, [
            'id' => $id,
            'reference_id' => $overrides['reference_id'] ?? sprintf('PRJ-2026-%03d', $id),
            'client' => [
                'id' => $overrides['client_id'] ?? 1,
                'name' => 'Acme Ltd',
                'email' => 'hello@acme.test',
            ],
            'current_version' => [
                'id' => $overrides['current_version_id'] ?? 1,
                'version_number' => 1,
                'title' => 'Initial Version',
                'freeze' => false,
            ],
            'created_by_user' => [
                'id' => 1,
                'name' => 'Admin User',
                'email' => 'admin@optima.test',
            ],
            'created_at' => '2026-09-01T10:00:00.000000Z',
            'updated_at' => '2026-09-01T10:00:00.000000Z',
        ], $overrides);
    }
}
