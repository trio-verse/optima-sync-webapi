<?php

namespace App\Events;

use App\Contracts\AffectsProjectCost;
use App\Models\Employee;
use App\Models\Project;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Override;

class ProjectEmployeeRemoved implements AffectsProjectCost
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Project $project, public Employee $employee)
    {
    }

    #[Override]
    public function getProjectId(): array
    {
        return [$this->project->id];
    }
}
