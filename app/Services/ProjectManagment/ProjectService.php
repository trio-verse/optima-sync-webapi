<?php

namespace App\Services\ProjectManagment;


use App\Enums\enProjectSource;
use App\Enums\enProjectStatus;
use App\Models\Project;
use App\Singleton\TenantManager;
use App\Support\FakePersistence\FakeStore;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProjectService
{
    public function __construct(private ProjectPricingService $pricingService)
    {
    }

    public function getFilteredProjects(array $filters = [])
    {
        $query = Project::with(['client', 'currentVersion', 'createdBy']);

        // Apply filters
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['client_id'])) {
            $query->where('client_id', $filters['client_id']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('reference_id', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhereHas('client', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Sort
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($filters['per_page'] ?? 15);
    }

    public function createProject(array $data): Project
    {
        $data = $this->preparingProjectData($data);

        try {
            //code...
            $project = DB::transaction(function () use (&$data): Project {
                $project = Project::create($data);

                // $version = $project->versions()->create([
                //     'version_number' => 1,
                //     'title' => $data['title'] ?? 'Initial Version',
                //     'description' => $data['description'] ?? null,
                //     'freeze' => false,
                //     'created_by' => auth()->id(),
                // ]);

                // $project->current_version_id = $version->id;

                (new ProjectVersionService)->createVersion($project, [
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

            return $project->load(['client', 'currentVersion']);

        } catch (\Throwable $th) {
            Log::error('Failed to create project: ' . $th->getMessage(), [
                'exception' => $th,
                'data' => $data,
            ]);

            throw new \Exception('Failed to create project.', 500);
        }
    }

    public function updateProject(Project $project, array $data): Project
    {
        if (!empty($data['current_version_id']) && !$project->versions()->where('id', $data['current_version_id'])->exists()) {
            throw new \Exception('Invalid version ID.');
        }

        // Commercial baseline is derived from project pricing; it is never a
        // caller-controlled total_amount value.
        unset($data['total_amount']);

        if (array_key_exists('sub_total', $data) || array_key_exists('profit_percentage', $data)) {
            $subTotal = (float) ($data['sub_total'] ?? $project->sub_total);
            $profitPercentage = (float) ($data['profit_percentage'] ?? $project->profit_percentage);
            $data['total_amount'] = $this->pricingService->calculateCommercialCost($subTotal, $profitPercentage);
        }

        try {
            $project->update($data);

        } catch (\Throwable $th) {
            Log::error('Failed to update the project: ' . $th->getMessage(), [
                'exception' => $th,
                'data' => $data,
            ]);

            throw new \Exception('Failed to update the project.', 500);
        }
        return $project->fresh();
    }

    public function getProject(Project $project): Project
    {
        return $project->load([
            'client',
            'currentVersion',
            'createdBy',
            'versions',
            'features',
            'employees',
        ])->loadCount([
                    'versions',
                    'features',
                    'employees',
                    'costs'
                ]);
    }

    public function deleteProject(Project $project): bool
    {
        if (!$project) {
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

        return $project->fresh();
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
        $data['status'] = $data['status'] ?? enProjectStatus::NEW ->value;
        $data['source'] = enProjectSource::INTERNAL->value;

        // financial
        $subTotal = (float) ($data['sub_total'] ?? 0);
        $profit = (int) ($data['profit_percentage'] ?? 20);
        $total = $this->pricingService->calculateCommercialCost($subTotal, $profit);


        $data = array_merge($data, [
            'sub_total' => $subTotal,
            'profit_percentage' => $profit,
            'total_amount' => $total
        ]);

        return $data;
    }
}
