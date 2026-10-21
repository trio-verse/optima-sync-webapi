<?php

namespace App\Services\ProjectManagment;

use App\Models\Project;
use App\Models\ProjectCost;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ProjectCostService
{
    public function __construct(private ProjectPricingService $pricingService) {}

    /**
     * Get all costs belonging to a project.
     */
    public function getProjectCosts(Project $project): Collection
    {
        return $project->costs()
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Get a specific cost ensuring it belongs to the project.
     */
    public function getCost(Project $project, ProjectCost|int $cost): ProjectCost
    {
        $costModel = is_int($cost)
            ? ProjectCost::find($cost)
            : $cost;

        if (! $costModel || $costModel->project_id !== $project->id) {
            throw new \DomainException('Cost item does not belong to the specified project.');
        }

        return $costModel;
    }

    /**
     * Create a new project cost item.
     */
    public function createCost(Project $project, array $data): ProjectCost
    {
        return DB::transaction(function () use ($project, $data) {
            $data['project_id'] = $project->id;
            $data['quantity'] = $data['quantity'] ?? 1;

            $cost = $project->costs()->create($data);
            $this->pricingService->recalculateQuotationTotal($project->fresh());

            return $cost;
        });
    }

    /**
     * Update an existing project cost item.
     */
    public function updateCost(Project $project, ProjectCost|int $cost, array $data): ProjectCost
    {
        $costModel = $this->getCost($project, $cost);

        return DB::transaction(function () use ($costModel, $data) {
            $costModel->update($data);
            $this->pricingService->recalculateQuotationTotal($costModel->project()->lockForUpdate()->firstOrFail());

            return $costModel->fresh();
        });
    }

    /**
     * Delete a project cost item.
     */
    public function deleteCost(Project $project, ProjectCost|int $cost): bool
    {
        $costModel = $this->getCost($project, $cost);

        return DB::transaction(function () use ($costModel) {
            $project = $costModel->project()->lockForUpdate()->firstOrFail();
            $deleted = (bool) $costModel->delete();
            $this->pricingService->recalculateQuotationTotal($project->fresh());

            return $deleted;
        });
    }

    /**
     * Calculate total budget sum for current project costs.
     */
    public function calculateTotalBudget(Project $project): array
    {
        $costs = $this->getProjectCosts($project);

        $totalBudget = $costs->sum(function (ProjectCost $cost) {
            return (float) $cost->quantity * (float) $cost->amount;
        });

        return [
            'project_id' => $project->id,
            'total_items' => $costs->count(),
            'total_budget' => $totalBudget,
            'formatted_total_budget' => number_format($totalBudget, 2, '.', ''),
        ];
    }
}
