<?php

namespace App\Services\ProjectManagment;

use App\Contracts\IQuotationService;
use App\Enums\enProjectFeatureStatus;
use App\Models\Project;
use App\Models\ProjectFeature;
use App\Models\ProjectVersion;
use Closure;
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

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['freeze'])) {
            $query->where('freeze', filter_var($filters['freeze'], FILTER_VALIDATE_BOOLEAN));
        }

        if (! empty($filters['search'])) {
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
        $duration = $this->calculateDuration(
            $data['start_date'] ?? null,
            $data['end_date'] ?? null,
            $data['duration'] ?? null
        );

        return DB::transaction(function () use ($project, $data, $duration) {
            $lockedProject = Project::query()->whereKey($project->id)->lockForUpdate()->firstOrFail();
            $versionNumber = $data['version_number']
                ?? (($lockedProject->versions()->max('version_number') ?? 0) + 1);
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

            $previousCurrentVersion = $lockedProject->currentVersion()->lockForUpdate()->first();
            if ($previousCurrentVersion) {
                $previousCurrentVersion->freezeVersion();
            }

            $version = $lockedProject->versions()->create($versionData);

            // Set current version pointer on project
            $lockedProject->update(['current_version_id' => $version->id]);

            return $version->fresh();
        });
    }

    /**
     * Update an existing version. If the version is frozen, branch a new version instead.
     */
    public function updateVersion(Project $project, ProjectVersion $version, array $data): ProjectVersion
    {
        if (! $version) {
            $version = $project->currentVersion;
        }

        // Business Rule: Frozen versions are immutable. Branch a new version from frozen base.
        if ($version->freeze) {
            return $this->branchVersion($version, $data);
        }

        if (! empty($data['start_date']) || ! empty($data['end_date'])) {
            $startDate = $data['start_date'] ?? $version->start_date;
            $endDate = $data['end_date'] ?? $version->end_date;
            $data['duration'] = $this->calculateDuration($startDate, $endDate, $data['duration'] ?? $version->duration);
        }

        $version->update($data);

        return $version->fresh();
    }

    /**
     * Branch a new active draft version from a current or historical source.
     */
    public function branchVersion(ProjectVersion $sourceVersion, array $overrides = []): ProjectVersion
    {
        return DB::transaction(function () use ($sourceVersion, $overrides) {
            $project = Project::query()
                ->whereKey($sourceVersion->project_id)
                ->lockForUpdate()
                ->firstOrFail();

            return $this->branchVersionWithinTransaction($project, $sourceVersion, $overrides);
        });
    }

    /**
     * Run a versioned mutation under one project lock and transaction.
     * A frozen current version is branched only after the caller reaches the
     * mutation, so a failed mutation rolls the branch back with the mutation.
     */
    public function withEditableVersion(Project $project, Closure $mutation): mixed
    {
        $transactionResult = DB::transaction(function () use ($project, $mutation) {
            $lockedProject = Project::query()->whereKey($project->id)->lockForUpdate()->firstOrFail();
            $version = $lockedProject->currentVersion()->lockForUpdate()->first();
            $branchedVersion = null;

            if ($version?->freeze) {
                $branchedVersion = $this->branchVersionWithinTransaction($lockedProject, $version, [
                    'change_description' => 'Automatically branched for a project mutation',
                ]);
                $lockedProject->refresh();
            }

            return [
                'result' => $mutation($lockedProject, $branchedVersion),
                'branched_version' => $branchedVersion,
            ];
        });

        // Set request metadata only after the transaction has committed.
        if ($transactionResult['branched_version'] && function_exists('request')) {
            request()->attributes->set('branched_new_version', $transactionResult['branched_version']);
        }

        return $transactionResult['result'];
    }

    /*
     * Generate a freezed version of a project version and recored snapshots with the current state for quotation data.
     */
    public function generateFreezedVersion(ProjectVersion $version): array
    {
        if ($version->freeze && is_array($version->quotation_data)) {
            return [
                'success' => true,
                'message' => 'Version is already freezed',
                'data' => $version->quotation_data ?? $this->quotationService->getPreviewData($version),
            ];
        }

        try {
            return DB::transaction(function () use ($version) {
                $version = ProjectVersion::query()
                    ->whereKey($version->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                // Persist snapshots before quotation rendering. This also
                // safely backfills legacy frozen rows that have no snapshot.
                $version->freezeVersion();
                $data = $this->quotationService->getPreviewData($version);

                $version->forceFill([
                    'quotation_number' => $data['quo_number'],
                    'quotation_data' => $data,
                    'quotation_generated_at' => now(),
                ])->save();

                Log::info('version info saved => time : ' . now());
                Log::info('version freezed info saved => time : ' . now());

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
                'message' => 'Failed to freeze version : ' . $exception->getMessage(),
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

    private function branchVersionWithinTransaction(Project $project, ProjectVersion $sourceVersion, array $overrides = []): ProjectVersion
    {

        // The project lock is acquired before all version locks. This gives all
        // branch paths one lock order and avoids concurrent duplicate branches.
        $sourceVersion = ProjectVersion::query()
            ->where('project_id', $project->id)
            ->whereKey($sourceVersion->id)
            ->lockForUpdate()
            ->firstOrFail();
        $currentVersion = $project->currentVersion()->lockForUpdate()->first();

        if (! $currentVersion) {
            throw new \DomainException('Project does not have an active version.');
        }

        $sourceIsCurrent = $sourceVersion->is($currentVersion);

        // An older version is already historical. When branching from it, the
        // current draft also becomes historical and must snapshot its shared
        // costs and employee assignments before the pointer changes.
        if (! $sourceIsCurrent) {
            $currentVersion->freezeVersion();

            // Its immutable record is now in the snapshot. Historical
            // branches do not need a second live copy of those Features.
            ProjectFeature::query()
                ->where('project_version_id', $currentVersion->id)
                ->delete();
        }

        // Backfill only missing legacy snapshots. Existing snapshots must stay
        // immutable, otherwise later project-level cost changes rewrite history.
        $sourceVersion->freezeVersion();

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

        // create the new branched version,
        $newVersion = $project->versions()->create($versionData);

        if ($sourceIsCurrent) {
            // Normal auto-branch: keep Feature identities and move the live
            // rows. The frozen source is represented by its snapshot.
            ProjectFeature::query()
                ->where('project_version_id', $sourceVersion->id)
                ->update(['project_version_id' => $newVersion->id]);
        } else {
            // Historical branch: its live Feature rows were intentionally moved
            // away when it was frozen. Rehydrate only this new editable draft
            // from the stored JSON snapshot, in one bulk insert.
            $this->restoreFeaturesFromSnapshot($sourceVersion, $newVersion);
        }

        $project->update(['current_version_id' => $newVersion->id]);

        return $newVersion->fresh(['basedOnVersion', 'features', 'createdBy']);
    }

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
     * Rebuild editable Feature rows for an explicit branch from history.
     * Snapshot data is authoritative for frozen versions, so old database rows
     * are never copied or mutated here.
     */
    private function restoreFeaturesFromSnapshot(ProjectVersion $sourceVersion, ProjectVersion $targetVersion): void
    {
        $now = now();
        $features = collect($sourceVersion->features_snapshot ?? [])
            ->map(fn(array $feature) => [
                'project_id' => $targetVersion->project_id,
                'project_version_id' => $targetVersion->id,
                'name' => $feature['name'] ?? '',
                'description' => $feature['description'] ?? null,
                'status' => $feature['status'] ?? enProjectFeatureStatus::NEW->value,
                'created_at' => $now,
                'updated_at' => $now,
            ])
            ->filter(fn(array $feature) => $feature['name'] !== '')
            ->values()
            ->all();

        if ($features !== []) {
            ProjectFeature::query()->insert($features);
        }
    }
}
