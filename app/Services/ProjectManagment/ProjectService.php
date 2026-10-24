<?php

namespace App\Services\ProjectManagment;

use App\Enums\enProjectSource;
use App\Enums\enProjectStatus;
use App\Models\Project;
use App\Models\ProjectCost;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProjectService
{
    public function __construct(
        private ProjectPricingService $pricingService,
        private ProjectVersionService $projectVersionService
    ) {}

    public function getFilteredProjects(array $filters = [])
    {
        // Eager-load everything the resource layer reads so list responses
        // never lazy-load per item. Cost totals are preloaded in a single
        // aggregate below instead of materializing every cost row.
        $query = Project::with(['client', 'client.city', 'currentVersion', 'createdBy']);

        // Apply filters
        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['client_id'])) {
            $query->where('client_id', $filters['client_id']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('reference_id', 'like', "%{$search}%")
                    ->orWhereHas('client', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Sort — user input must never reach ORDER BY unvalidated.
        $allowedSortColumns = [
            'created_at', 'updated_at', 'reference_id', 'status', 'sub_total', 'total_amount',
        ];
        $sortBy = in_array($filters['sort_by'] ?? '', $allowedSortColumns, true)
            ? $filters['sort_by']
            : 'created_at';
        $sortOrder = strtolower((string) ($filters['sort_order'] ?? 'desc')) === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sortBy, $sortOrder)
            ->orderBy('projects.id', $sortOrder);

        $projects = $query->paginate(min((int) ($filters['per_page'] ?? 15), 10000));

        $this->preloadCostsTotals($projects);

        return $projects;
    }

    /**
     * Replace per-project cost-row materialization with one server-side
     * aggregate. The list response only needs each project's cost total, so
     * fetching every row (28k rows for 2000 projects) is pure waste.
     * Sets $project->costsTotal, which Project::calculateTotalCosts()
     * short-circuits on. Other flows keep the original relation behaviour.
     */
    protected function preloadCostsTotals(LengthAwarePaginator $projects): void
    {
        if ($projects->isEmpty()) {
            return;
        }

        $totals = ProjectCost::query()
            ->whereIn('project_id', $projects->getCollection()->modelKeys())
            ->groupBy('project_id')
            ->selectRaw('project_id, SUM(quantity * amount) AS total')
            ->pluck('total', 'project_id');

        foreach ($projects as $project) {
            $project->costsTotal = (float) ($totals[(int) $project->id] ?? 0);
        }
    }

    public function createProject(array $data): Project
    {
        $data = $this->preparingProjectData($data);

        try {
            // code...
            $project = DB::transaction(function () use (&$data): Project {
                $project = Project::create($data);


                $this->projectVersionService->createVersion($project, [
                    'version_number' => 1,
                    'title' => $data['title'] ?? 'Initial Version',
                    'description' => $data['description'] ?? null,
                    'freeze' => false,
                    'created_by' => auth()->id(),
                    'start_date' => $data['start_date'] ?? null,
                    'end_date' => $data['end_date'] ?? null,
                    'duration' => $data['duration'] ?? null,
                ]);

                $project->save();

                return $project;
            });

            return $project->load(['client', 'client.city', 'currentVersion', 'currentVersion.createdBy', 'createdBy', 'costs']);

        } catch (\Throwable $th) {
            Log::error('Failed to create project: '.$th->getMessage(), [
                'exception' => $th,
                'data' => $data,
            ]);

            throw new \Exception('Failed to create project.', 500);
        }
    }

    public function updateProject(Project $project, array $data): Project
    {
        if (! empty($data['current_version_id']) && ! $project->versions()->where('id', $data['current_version_id'])->exists()) {
            throw new \Exception('Invalid version ID.');
        }

        // Commercial baseline is derived from project pricing; it is never a
        // caller-controlled total_amount value.
        unset($data['total_amount']);

        if (array_key_exists('sub_total', $data) || array_key_exists('profit_percentage', $data)) {
            $calculationProject = $project->replicate();
            $calculationProject->fill([
                'sub_total' => $data['sub_total'] ?? $project->sub_total,
                'profit_percentage' => $data['profit_percentage'] ?? $project->profit_percentage,
                'discount' => $data['discount'] ?? $project->discount,
                'tax' => $data['tax'] ?? $project->tax,
            ]);
            $data['total_amount'] = $this->pricingService->calculateQuotationTotals($calculationProject)['total'];
        }

        try {
            $project->update($data);

        } catch (\Throwable $th) {
            Log::error('Failed to update the project: '.$th->getMessage(), [
                'exception' => $th,
                'data' => $data,
            ]);

            throw new \Exception('Failed to update the project.', 500);
        }

        return $project->fresh()->load(['client', 'client.city', 'currentVersion', 'currentVersion.createdBy', 'createdBy', 'costs']);
    }

    public function getProject(Project $project): Project
    {
        return $project->load([
            'client',
            'currentVersion.features',
            'createdBy',
            'versions',
            'employees',
        ])->loadCount([
            'versions',
            'employees',
            'costs',
        ]);
    }

    public function deleteProject(Project $project): bool
    {
        if (! $project) {
            return false;
        }
        // Check if project can be deleted (no active versions or quotations)
        // if ($project->versions()->exists()) {
        //     throw new \Exception('Cannot delete project that has versions. Delete versions first.');
        // }

        // delete the project with all features , members , costs , quotations and versions
        return $project->delete();
    }

    public function changeStatus(Project $project, string $status): Project
    {
        $project->update(['status' => $status]);

        return $project->fresh()->load(['client', 'client.city', 'currentVersion', 'currentVersion.createdBy', 'createdBy', 'costs']);
    }

    // PRIVATE Methods
    protected function generateReferenceId(): string
    {
        $prefix = 'PRJ';
        $year = date('Y');
        $month = date('m');

        // Get the last project reference ID for this year/month
        $lastProject = Project::where('reference_id', 'like', "{$prefix}-{$year}{$month}-%")
            ->orderBy('reference_id', 'desc')
            ->first();

        if ($lastProject) {
            $lastNumber = intval(substr($lastProject->reference_id, -4));
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        return "{$prefix}-{$year}{$month}-{$nextNumber}";
    }

    private function preparingProjectData(array $data): array
    {
        // Generate reference ID if not provided
        if (empty($data['reference_id'])) {
            $data['reference_id'] = $this->generateReferenceId();
        }
        // Set created_by
        $data['created_by'] = auth()->id();
        // Set default status
        $data['status'] = $data['status'] ?? enProjectStatus::NEW->value;
        $data['source'] = enProjectSource::INTERNAL->value;

        // financial
        $subTotal = (float) ($data['sub_total'] ?? 0);
        $profit = (int) ($data['profit_percentage'] ?? 20);

        // Create a temporary project instance to calculate totals with provided data
        $tempProject = new Project;
        $tempProject->sub_total = $subTotal;
        $tempProject->profit_percentage = $profit;
        $tempProject->discount = (float) ($data['discount'] ?? 0);
        $tempProject->tax = (float) ($data['tax'] ?? 0);

        $total = $this->pricingService->calculateQuotationTotals($tempProject)['total'];

        $data = array_merge($data, [
            'sub_total' => $subTotal,
            'profit_percentage' => $profit,
            'total_amount' => $total,
        ]);

        return $data;
    }
}
