<?php
namespace App\Services\Marketing;

use App\Models\Campaign;
use App\Models\Organization;

class MarketingDashboardService
{

    public function __construct(
        private CampaignAnalyticsService $campaignAnalytics
    ) {
    }

    /**
     * get Marketing Dashboard analytics
     * @param Organization $org
     * @return array{active_campaigns: mixed, overall_CPL: float|null, overall_ROI: float|null, total_campaigns: mixed, total_cnnections: int, total_revenue: float, total_spent: float, total_wins: int}
     */
    public function getDashboardStats(Organization $org): array
    {
        $campaignStats = Campaign::where('organization_id', $org->id)
            ->selectRaw('
            COUNT(*) as total,
            COUNT(CASE WHEN status = "active" THEN 1 END) as active
        ')->first();

        $connectionStats = $org->connections()->selectRaw("
            COUNT(*) as total,
            COUNT(CASE WHEN stage = 'win' THEN 1 END) as total_wins,
            SUM(CASE WHEN stage = 'win' THEN deal_value ELSE 0 END) as total_revenue
        ")->first();

        $spent = (float) $org->contents()
            ->whereNotNull('cost_confirmed_by')
            ->sum('cost');


        $leads = (int) $connectionStats->total;
        $wins = (int) $connectionStats->total_wins;
        $revenue = (float) $connectionStats->total_revenue;


        return [

            'total_campaigns' => $campaignStats->total,
            'active_campaigns' => $campaignStats->active,

            'total_spent' => $spent,
            'total_cnnections' => $leads,

            'total_wins' => $wins,
            'total_revenue' => $revenue,

            'overall_CPL' => $leads > 0 && $spent > 0 ? round($spent / $leads, 2) : null,
            'overall_percentage_ROI' => $this->calculateOverallROI($spent, $revenue),

        ];
    }


    


    private function calculateOverallROI(float $spent, float $revenue): null|float
    {
        if ($spent === 0.0 || $revenue === 0.0)
            return null;
        return round(($revenue - $spent) / $spent * 100, 2);
    }

}
