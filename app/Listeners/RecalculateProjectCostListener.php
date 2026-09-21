<?php

namespace App\Listeners;

use App\Contracts\AffectsProjectCost;
use App\Helper\V1\RecalculateProjectCostAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class RecalculateProjectCostListener implements ShouldQueue
{
    /**
     * The listener must see committed employee rates and pivot allocations.
     */

    public bool $afterCommit = true;

    /**
     * Create the event listener.
     */
    public function __construct(private RecalculateProjectCostAction $recalculateAction)
    {
    }

    /**
     * Handle the event.
     */
    public function handle(AffectsProjectCost $event): void
    {
        foreach ($event->getProjectId() as $projectId) {
            $this->recalculateAction->execute($projectId);
        }
    }
}
