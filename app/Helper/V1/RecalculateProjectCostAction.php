<?php

namespace App\Helper\V1;

use App\Models\Project;
use App\Services\ProjectManagment\ProjectEmployeeService;

use function Illuminate\Log\log;

class RecalculateProjectCostAction
{

    public function execute(int $projectId): void
    {

        $project = Project::with(['employees'])->find($projectId);

        if (!$project || $project->latest_version->freeze)
            return;

        $total_emp_costs = (int) (new ProjectEmployeeService())->calculatePointsSummary($project)['total_cost'];

        if (
            $project->sub_total == null || $project->sub_total == 0 ||
            $total_emp_costs > $project->sub_total
        ) {
            $total_amount = $total_emp_costs * ($project->profit_percentage / 100 + 1);

            Project::find($projectId)->update([
                "sub_total" => (float) $total_emp_costs,
                "total_amount" => (float) $total_amount
            ]);
        }
    }

}

