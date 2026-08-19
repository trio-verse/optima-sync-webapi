<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Services\Marketing\MarketingDashboardService;
use App\Singleton\TenantManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Analytics
 */
class MarketingAnalyticsController extends Controller
{
    private Organization $organization;
    public function __construct(private MarketingDashboardService $dashboardService)
    {
        $this->organization = Organization::find(app(TenantManager::class)->getOrganizationId());
    }

    /**
     * Main Dashboard
     * get the dashboard analytics for all campaigns
     * @return JsonResponse
     */
    public function dashboard(): JsonResponse
    {
        $stats = $this->dashboardService->getDashboardStats(
            $this->organization
        );
        return ApiResponse::success($stats);
    }



}
