<?php

namespace App\Helper\V1;

use App\Models\Project;
use App\Services\ProjectManagment\ProjectEmployeeService;

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
        )
            $project->update([
                'sub_total' => $total_emp_costs
            ]);

    }

}

