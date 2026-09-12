<?php

namespace App\Services\ProjectManagment;

use App\Models\Project;
use App\Models\ProjectVersion;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProjectVersionService
{
    /**
     * Get paginated project versions with optional filters.
     */
    public function getProjectVersions(Project $project, array $filters = []): LengthAwarePaginator
    {
        $query = $project->versions()->with(['basedOnVersion', 'createdBy']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['freeze'])) {
            $query->where('freeze', filter_var($filters['freeze'], FILTER_VALIDATE_BOOLEAN));
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $sortBy = $filters['sort_by'] ?? 'version_number';
        $sortOrder = $filters['sort_order'] ?? 'desc';

        return $query->orderBy($sortBy, $sortOrder)
            ->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Create an initial or new project version.
     */
    public function createVersion(Project $project, array $data): ProjectVersion
    {
        $versionNumber = $data['version_number']
            ?? ($project->latest_version ? $project->latest_version->version_number + 1 : 1);

        $duration = $this->calculateDuration(
            $data['start_date'] ?? null,
            $data['end_date'] ?? null,
            $data['duration'] ?? null
        );

        return DB::transaction(function () use ($project, $data, $versionNumber, $duration) {
            $versionData = array_merge($data, [
                'version_number' => $versionNumber,
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'change_description' => $data['change_description'] ?? null,
                'start_date' => $data['start_date'] ?? null,
                'end_date' => $data['end_date'] ?? null,
                'duration' => $duration,
                'based_on_version_id' => $data['based_on_version_id'] ?? null,
                'freeze' => false,
                'created_by' => auth()->id() ?? ($data['created_by'] ?? null),
            ]);

            $version = $project->versions()->create($versionData);

            // Freeze previous versions if not the first version
            if ($versionNumber > 1) {
                $project->versions()
                    ->where('id', '!=', $version->id)
                    ->update(['freeze' => true]);
            }

            // Set current version pointer on project
            $project->update(['current_version_id' => $version->id]);

            return $version->fresh();
        });
    }

    /**
     * Update an existing version. If the version is frozen, branch a new version instead.
     */
    public function updateVersion(Project $project , ProjectVersion $version, array $data): ProjectVersion
    {
        if(!$version)
            $version = $project->currentVersion;
        
        // Business Rule: Frozen versions are immutable. Branch a new version from frozen base.
        if ($version->freeze) {
            return $this->branchVersion($version, $data);
        }

        if (!empty($data['start_date']) || !empty($data['end_date'])) {
            $startDate = $data['start_date'] ?? $version->start_date;
            $endDate = $data['end_date'] ?? $version->end_date;
            $data['duration'] = $this->calculateDuration($startDate, $endDate, $data['duration'] ?? $version->duration);
        }

        $version->update($data);

        return $version->fresh();
    }

    /**
     * Branch a new active draft version from a base source version (cloning features & costs).
     */
    public function branchVersion(ProjectVersion $sourceVersion, array $overrides = []): ProjectVersion
    {
        return DB::transaction(function () use ($sourceVersion, $overrides) {
            $project = $sourceVersion->project;

            // Freeze any existing active draft versions
            $project->versions()->where('freeze', false)->update(['freeze' => true]);

            $startDate = $overrides['start_date'] ?? $sourceVersion->start_date;
            $endDate = $overrides['end_date'] ?? $sourceVersion->end_date;
            $duration = $this->calculateDuration($startDate, $endDate, $overrides['duration'] ?? $sourceVersion->duration);
            $nextVersionNumber = ($project->versions()->max('version_number') ?? 0) + 1;

            $versionData = array_merge([
                'based_on_version_id' => $sourceVersion->id,
                'version_number' => $nextVersionNumber,
                'title' => $overrides['title'] ?? ($sourceVersion->title . ' (v' . $nextVersionNumber . ')'),
                'description' => $overrides['description'] ?? $sourceVersion->description,
                'change_description' => $overrides['change_description'] ?? 'Branched from version #' . $sourceVersion->version_number,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'duration' => $duration,
                'freeze' => false,
                'created_by' => auth()->id() ?? $sourceVersion->created_by,
            ], $overrides);

            $newVersion = $project->versions()->create($versionData);

            // convert features and costs from source version to new version
            $this->convertVersionRelationsReference($sourceVersion, $newVersion);

            // take a snapshot of the old version relationships and freeze it
            $sourceVersion->freezeVersion();

            // Update current version pointer on project
            $project->update(['current_version_id' => $newVersion->id]);

            return $newVersion->fresh(['basedOnVersion', 'features', 'costs']);
        });
    }

    /**
     * Alias for branchVersion to maintain compatibility with clone endpoints.
     */
    public function cloneVersion(ProjectVersion $sourceVersion): ProjectVersion
    {
        return $this->branchVersion($sourceVersion, [
            'title' => $sourceVersion->title . ' (Copy)',
            'change_description' => 'Cloned from version #' . $sourceVersion->version_number,
        ]);
    }

    /**
     * Explicitly freeze a project version and record snapshots.
     */
    public function freezeVersion(ProjectVersion $version): ProjectVersion
    {
        if ($version->freeze) {
            return $version;
        }

        return DB::transaction(function () use ($version) {
            $version->freezeVersion(); // Uses Eloquent Model snapshot logic

            // $version->project->update(['current_version_id' => $version->id]);

            return $version->fresh();
        });
    }

    /**
     * Delete an un-frozen, non-current version without active quotations.
     */
    public function deleteVersion(ProjectVersion $version): bool
    {
        if ($version->freeze) {
            throw new \DomainException('Cannot delete a frozen version.');
        }

        if ($version->project->current_version_id === $version->id) {
            throw new \DomainException('Cannot delete the current active version.');
        }

        if ($version->quotation()->exists()) {
            throw new \DomainException('Cannot delete a version associated with an active quotation.');
        }

        return DB::transaction(function () use ($version) {
            $version->features()->delete();
            $version->costs()->delete();
            return $version->delete();
        });
    }

    // ==========================================
    // Private Helper Methods
    // ==========================================

    /**
     * Calculate duration in days between two date strings.
     */
    private function calculateDuration(?string $startDate, ?string $endDate, mixed $default = null): ?int
    {
        if (empty($startDate) || empty($endDate)) {
            return is_numeric($default) ? (int) $default : null;
        }

        try {
            $start = new \DateTime($startDate);
            $end = new \DateTime($endDate);
            return $start->diff($end)->days + 1;
        } catch (\Throwable) {
            return is_numeric($default) ? (int) $default : null;
        }
    }

    /**
     * Convert features and costs from a source version to a target version by updating their foreign keys.
     * This is used when branching or cloning a version to ensure the new version has its own set of features and costs.
     * @param ProjectVersion $sourceVersion The version to copy from
     * @param ProjectVersion $targetVersion The version to copy to
     * @return void
     */
    private function convertVersionRelationsReference(ProjectVersion $sourceVersion, ProjectVersion $targetVersion): void
    {
        $sourceVersion->features()->update(['project_version_id' => $targetVersion->id]);
        $sourceVersion->costs()->update(['project_version_id' => $targetVersion->id]);
    }
}
