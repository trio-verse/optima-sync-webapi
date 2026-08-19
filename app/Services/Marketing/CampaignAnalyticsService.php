<?php

namespace App\Services\Marketing;

use App\Models\Campaign;

class CampaignAnalyticsService
{

    public function getStats(Campaign $campaign): array
    {
        $connectionStats = $campaign->connections()
            ->selectRaw('
                COUNT(*) as total_count,
                COUNT(CASE WHEN stage = "win" THEN 1 END) as win_count,
                SUM(CASE WHEN stage = "win" THEN deal_value ELSE 0 END) as total_revenue
            ')
            ->first();

        $connections_count = $connectionStats->total_count;
        $wins_count = $connectionStats->win_count;
        $win_rate = $connections_count > 0 ? round($wins_count / $connections_count * 100, 2) : 0;
        $revenue = (float) $connectionStats->total_revenue;


        // from content :
        $contentStats = $campaign->contents()->selectRaw("
                    COUNT(*) AS content_count ,
                    SUM(case when `cost_confirmed_by` IS NOT NULL then `cost` ELSE 0 END ) AS current_spent"
        )->first();

        $spent = (float) $contentStats->current_spent;
        $budget = (float) $campaign->expected_budget;

        return [
            // budeget
            'expected_budget' => $budget,
            'current_spent' => $spent,
            'remaining_budget' => $budget - $spent,
            'budget_utilization' => $budget > 0 ? round($spent / $budget * 100, 2) : null,

            // connections
            'connections_count' => $connections_count,
            'win_count' => $wins_count,
            'win_rate' => $win_rate,

            // Revenue and preformance
            'total_revenue' => $wins_count > 0 ? $revenue : null,
            'cpl' => $connections_count > 0 && $spent > 0 ? round($spent / $connections_count, 2) : null,
            'roi' => $this->ROIcalculate($spent, $revenue, $wins_count),


            // content
            'expected_content_count' => (int) $campaign->estimated_content_count,
            'current_content_count' => $contentStats->content_count,
            'content_by_status' => $this->contentByStatus($campaign),
            'content_by_channel' => $this->contentByChannel($campaign),
        ];
    }


    /**
     * method to calculate the ROI (return on investment)
     */
    private function ROIcalculate(float $spent, float $revenue, int $wins_count)
    {
        if ($spent === 0 || $wins_count === 0)
            return null;

        return round(($revenue - $spent) / $spent * 100, 2);
    }

    private function contentByStatus(Campaign $campaign): array
    {
        return $campaign->contents()
            ->selectRaw("status , COUNT(*) as count")
            ->groupBy("status")
            ->pluck('count', 'status')
            ->toArray();
    }
    private function contentByChannel(Campaign $campaign)
    {
        return $campaign->contents()
            ->with('channel:id,name')
            ->selectRaw("channel_id , COUNT(*) as count")
            ->groupBy("channel_id")
            ->get()
            ->map(fn($raw) => [
                'channel' => $raw->channel?->name,
                'count' => $raw->count,
            ])->toArray();
    }
}
