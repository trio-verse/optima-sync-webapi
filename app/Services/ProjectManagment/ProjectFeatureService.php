<?php

namespace App\Services\ProjectManagment;

use App\Enums\enProjectFeatureStatus;
use App\Models\Project;
use App\Models\ProjectFeature;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ProjectFeatureService
{
    /**
     * Get features belonging to a project.
     */
    public function getProjectFeatures(Project $project): Collection
    {
        return $project->features()
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

        if (!$featureModel || $featureModel->project_id !== $project->id) {
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

        $activeVersion = $project->currentVersion;
        if ($activeVersion && $activeVersion->freeze) {
            throw new \DomainException('Cannot add features to a frozen version.');
        }

        return DB::transaction(function () use ($project, $data) {
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

        if ($featureModel->projectVersion && $featureModel->projectVersion->freeze) {
            throw new \DomainException('Cannot update features of a frozen version.');
        }

        return DB::transaction(function () use ($featureModel, $data) {
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

        if ($featureModel->projectVersion && $featureModel->projectVersion->freeze) {
            throw new \DomainException('Cannot delete features of a frozen version.');
        }

        return DB::transaction(function () use ($featureModel) {
            return (bool) $featureModel->delete();
        });
    }

    /**
     * Change feature status.
     */
    public function changeStatus(Project $project, ProjectFeature|int $feature, string $status): ProjectFeature
    {
        $featureModel = $this->getFeature($project, $feature);

        if ($featureModel->projectVersion && $featureModel->projectVersion->freeze) {
            throw new \DomainException('Cannot change status of features in a frozen version.');
        }

        return DB::transaction(function () use ($featureModel, $status) {
            $featureModel->update(['status' => $status]);
            return $featureModel->fresh();
        });
    }
}
