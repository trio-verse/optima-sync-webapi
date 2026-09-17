<?php

namespace App\Events;

use App\Contracts\AffectsProjectCost;
use App\Enums\enProjectStatus;
use App\Models\Employee;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Override;

class EmployeeHourlyCostChanged implements AffectsProjectCost
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Employee $employee)
    {
        //
    }


    #[Override]
    public function getProjectId(): array
    {
        return $this->employee->projects()->whereIn('status', [
            enProjectStatus::NEW ->value,
            enProjectStatus::UNDER_REVIEW->value
        ], 'or')->pluck('products.id')->toArray();
    }
}
