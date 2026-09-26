<?php

namespace App\Services\ProjectManagment;

use App\Models\Project;

class ProjectPricingService
{
    public function __construct(private ProjectEmployeeService $projectEmployeeService)
    {
    }

    /**
     * The internal development-cost baseline. This intentionally excludes
     * project add-on costs, tax, discount, and quotation presentation data.
     */
    public function calculateDevelopmentCost(Project $project): float
    {
        $summary = $this->projectEmployeeService->calculatePointsSummary($project);

        return round((float) $summary['total_cost'], 2);
    }

    /**
     * The project-owned commercial baseline derived from its internal cost.
     */
    public function calculateCommercialCost(float $developmentCost, float $profitPercentage): float
    {
        return round($developmentCost * (1 + ($profitPercentage / 100)), 2);
    }

    /**
     * Rebuild the persisted project pricing baseline from current resources.
     */
    public function recalculate(Project $project): void
    {
        $developmentCost = $this->calculateDevelopmentCost($project);
        $project->forceFill([
            'sub_total' => $developmentCost,
            'total_amount' => $this->calculateQuotationTotals($project)['total'],
        ])->save();
    }

    /**
     * The only calculation used for persisted quotation money fields.
     */
    public function calculateQuotationTotals(Project $project, ?float $discount = null, ?float $tax = null): array
    {
        $developmentFee = $this->calculateCommercialCost(
            (float) $project->sub_total,
            (float) $project->profit_percentage
        );
        $addedCostsTotal = round($project->calculateTotalCosts(), 2);
        $subtotal = round($developmentFee + $addedCostsTotal, 2);
        $discount = round($discount ?? (float) $project->discount, 2);
        $tax = round($tax ?? (float) $project->tax, 2);

        return [
            'development_fee' => $developmentFee,
            'added_costs_total' => $addedCostsTotal,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax' => $tax,
            'total' => round($subtotal - $discount + $tax, 2),
        ];
    }

}
