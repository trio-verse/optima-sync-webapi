<?php

namespace Database\Factories;

use App\Models\ProjectVersion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProjectVersion>
 */
class ProjectVersionFactory extends Factory
{
    protected $model = ProjectVersion::class;

    public function definition(): array
    {
        return [
            'project_id' => 1,
            'based_on_version_id' => null,
            'version_number' => 1,
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'change_description' => null,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addMonths(3)->toDateString(),
            'duration' => '3 months',
            'freeze' => false,
            'features_snapshot' => null,
            'costs_snapshot' => null,
            'members_snapshot' => null,
            'created_by' => 1,
        ];
    }

    /**
     * Build a fake-persistence DTO array (no database).
     */
    public static function dto(int $id, int $projectId, array $overrides = []): array
    {
        $base = (new static)->definition();

        return array_merge($base, [
            'id' => $id,
            'project_id' => $projectId,
            'version_number' => $overrides['version_number'] ?? $id,
            'title' => $overrides['title'] ?? 'Initial Version',
            'description' => $overrides['description'] ?? 'First draft of the project scope',
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
