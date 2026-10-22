<?php

namespace App\Services\ProjectManagment;

use App\Contracts\IQuotationService;
use App\Models\Project;
use App\Models\ProjectVersion;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProjectVersionService
{
    private IQuotationService $quotationService;
    public function __construct(IQuotationService $quotationService)
    {
        $this->quotationService = $quotationService;
    }

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
    public function updateVersion(Project $project, ProjectVersion $version, array $data): ProjectVersion
    {
        if (!$version)
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
            $sourceVersion = ProjectVersion::query()
                ->whereKey($sourceVersion->id)
                ->lockForUpdate()
                ->firstOrFail();
            $project = Project::query()
                ->whereKey($sourceVersion->project_id)
                ->lockForUpdate()
                ->firstOrFail();

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

            // Snapshot the source before copying its immutable historical data.
            $sourceVersion->load(['features', 'project.costs', 'project.employees']);
            $sourceVersion->freezeVersion();
            $this->copyFeatures($sourceVersion, $newVersion);

            // Update current version pointer on project
            $project->update(['current_version_id' => $newVersion->id]);

            return $newVersion->fresh(['basedOnVersion', 'features', 'createdBy']);
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

    /*
     * Generate a freezed version of a project version and recored snapshots with the current state for quotation data.
     */
     public function generateFreezedVersion(ProjectVersion $version): array
    {
       
         
        if($version->freeze && is_array($version->quotation_data)) {
            return [
                'success' => true,
                'message' => 'Version is already freezed',
                'data' => $version->quotation_data ?? $this->quotationService->getPreviewData($version),
            ];
        }

        try {
            $data = $this->quotationService->getPreviewData($version);

            return DB::transaction(function () use ($version, $data) {

                $version->forceFill([
                    'quotation_number' => $data['quo_number'],
                    'quotation_data' => $data,
                    'quotation_generated_at' => now(),
                ])->save();

                Log::info('version info saved => time : '.now());
                if (! $version->freeze) {
                    $version->loadMissing(['features', 'project.costs', 'project.employees']);
                    $version->freezeVersion();
                }

                Log::info('version freezed info saved => time : '.now());

                return [
                    'success' => true,
                    'message' => 'version freezed successfully',
                    'data' => $data,
                ];
            });

        } catch (\Throwable $exception) {
            Log::error('freezing version Error.', [
                'version_id' => $version->id,
                'project_id' => $version->project_id,
                'exception' => $exception,
            ]);

            return [
                'success' => false,
                'message' => 'Failed to freeze version : '.$exception->getMessage(),
            ];
        }
    }

    /**
     * Delete an un-frozen, non-current version.
     */
    public function deleteVersion(ProjectVersion $version): bool
    {
        if ($version->freeze) {
            throw new \DomainException('Cannot delete a frozen version.');
        }

        if ($version->project->current_version_id === $version->id) {
            throw new \DomainException('Cannot delete the current active version.');
        }

        return DB::transaction(function () use ($version) {
            $version->features()->delete();
            // $version->costs()->delete();
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
     *
     * @param  ProjectVersion  $sourceVersion  The version to copy from
     * @param  ProjectVersion  $targetVersion  The version to copy to
     */
    private function copyFeatures(ProjectVersion $sourceVersion, ProjectVersion $targetVersion): void
    {
        foreach ($sourceVersion->features as $feature) {
            $copy = $feature->replicate();
            $copy->project_version_id = $targetVersion->id;
            $copy->save();
        }
    }
}
