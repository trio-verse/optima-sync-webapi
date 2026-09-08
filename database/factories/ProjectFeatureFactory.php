<?php

namespace Database\Factories;

use App\Enums\enProjectFeatureStatus;
use App\Models\ProjectFeature;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProjectFeature>
 */
class ProjectFeatureFactory extends Factory
{
    protected $model = ProjectFeature::class;

    public function definition(): array
    {
        return [
            'project_id' => 1,
            'project_version_id' => 1,
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'status' => enProjectFeatureStatus::NEW->value,
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
            'name' => $overrides['name'] ?? 'User Authentication',
            'description' => $overrides['description'] ?? 'Login, register, and password reset flows',
            'status' => $overrides['status'] ?? enProjectFeatureStatus::NEW->value,
            'created_at' => '2026-09-01T10:00:00.000000Z',
            'updated_at' => '2026-09-01T10:00:00.000000Z',
        ], $overrides);
    }
}
