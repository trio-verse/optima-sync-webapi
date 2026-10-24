<?php

namespace App\Services\ProjectManagment;

use App\Enums\enProjectFeatureStatus;
use App\Models\Project;
use App\Models\ProjectFeature;
use Illuminate\Database\Eloquent\Collection;

class ProjectFeatureService
{
    /**
     * Get features belonging to a project.
     */
    public function getProjectFeatures(Project $project): Collection
    {
        if (! $project->current_version_id) {
            return new Collection;
        }

        return ProjectFeature::query()
            ->where('project_id', $project->id)
            ->where('project_version_id', $project->current_version_id)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Get a specific feature ensuring it belongs to the project.
     */
    public function getFeature(Project $project, ProjectFeature|int $feature): ProjectFeature
    {
        $featureModel = is_int($feature)
            ? ProjectFeature::find($feature)
            : $feature;

        if (! $featureModel || $featureModel->project_id !== $project->id) {
            throw new \DomainException('Feature does not belong to the specified project.');
        }

        return $featureModel;
    }

    /**
     * Create a feature for a project's active version.
     */
    public function createFeature(Project $project, array $data): ProjectFeature
    {
        if (!$project->current_version_id) {
            throw new \DomainException('Project does not have an active version.');
        }

        return app(ProjectVersionService::class)->withEditableVersion($project, function (Project $project) use ($data) {
            if (! $project->current_version_id) {
                throw new \DomainException('Project does not have an active version.');
            }

            $data['project_id'] = $project->id;
            $data['project_version_id'] = $project->current_version_id;
            $data['status'] = $data['status'] ?? enProjectFeatureStatus::NEW->value;

            return $project->features()->create($data);
        });
    }

    /**
     * Update an existing feature.
     */
    public function updateFeature(Project $project, ProjectFeature|int $feature, array $data): ProjectFeature
    {
        $featureModel = $this->getFeature($project, $feature);

        return app(ProjectVersionService::class)->withEditableVersion($project, function (Project $project) use ($featureModel, $data) {
            $featureModel = $this->getCurrentFeatureForUpdate($project, $featureModel->id);
            $featureModel->update($data);

            return $featureModel->fresh();
        });
    }

    /**
     * Delete a feature.
     */
    public function deleteFeature(Project $project, ProjectFeature|int $feature): bool
    {
        $featureModel = $this->getFeature($project, $feature);

        return app(ProjectVersionService::class)->withEditableVersion($project, function (Project $project) use ($featureModel) {
            $featureModel = $this->getCurrentFeatureForUpdate($project, $featureModel->id);

            return (bool) $featureModel->delete();
        });
    }

    /**
     * Change feature status.
     */
    public function changeStatus(Project $project, ProjectFeature|int $feature, string $status): ProjectFeature
    {
        $featureModel = $this->getFeature($project, $feature);

        return app(ProjectVersionService::class)->withEditableVersion($project, function (Project $project) use ($featureModel, $status) {
            $featureModel = $this->getCurrentFeatureForUpdate($project, $featureModel->id);
            $featureModel->update(['status' => $status]);

            return $featureModel->fresh();
        });
    }

    /**
     * Mutations may only target the editable project's current Feature set.
     * Frozen-version history is read from snapshots and is never mutable.
     */
    private function getCurrentFeatureForUpdate(Project $project, int $featureId): ProjectFeature
    {
        $feature = ProjectFeature::query()
            ->whereKey($featureId)
            ->where('project_id', $project->id)
            ->where('project_version_id', $project->current_version_id)
            ->lockForUpdate()
            ->first();

        if (! $feature) {
            throw new \DomainException('Feature is not part of the current editable version.');
        }

        return $feature;
    }
}
