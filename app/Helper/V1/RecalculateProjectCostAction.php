<?php

namespace App\Helper\V1;

use App\Models\Project;
use App\Services\ProjectManagment\ProjectPricingService;
use Illuminate\Support\Facades\DB;

class RecalculateProjectCostAction
{
    public function __construct(private ProjectPricingService $pricingService)
    {
    }

    public function execute(int $projectId): void
    {
        DB::transaction(function () use ($projectId) {
            $project = Project::query()
                ->with('employees')
                ->lockForUpdate()
                ->find($projectId);

            if (!$project || $project->latest_version?->freeze) {
                return;
            }

            $this->pricingService->recalculate($project);
        });
    }
}
