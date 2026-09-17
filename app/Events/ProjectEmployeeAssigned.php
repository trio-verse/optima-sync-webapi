<?php

namespace App\Events;

use App\Contracts\AffectsProjectCost;
use App\Models\Employee;
use App\Models\Project;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Override;

class ProjectEmployeeAssigned implements AffectsProjectCost
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Project $project,
        public Employee $employee
    ) {
        //
    }

    #[Override]
    public function getProjectId(): array
    {
        return [$this->project->id];
    }
}
