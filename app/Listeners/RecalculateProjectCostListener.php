<?php

namespace App\Listeners;

use App\Contracts\AffectsProjectCost;
use App\Helper\V1\RecalculateProjectCostAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RecalculateProjectCostListener implements ShouldQueue
{
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
