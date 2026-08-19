<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Campaign\StoreCampaignRequest;
use App\Http\Requests\Campaign\UpdateCampaignRequest;
use App\Http\Resources\V1\CampaignResource;
use App\Models\Campaign;
use App\Services\CampaignService;
use App\Services\Marketing\CampaignAnalyticsService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

/**
 * @group campaigns
 */
class CampaignController extends Controller
{
    use AuthorizesRequests;
    public function __construct(
        private CampaignService $service,
        private CampaignAnalyticsService $campaignAnalytics
    ) {
    }

    /**
     * Display a listing of campaigns.
     */
    public function index()
    {
        $this->authorize('viewAny', Campaign::class);
        $campaigns = $this->service->showAll();
        return ApiResponse::success(CampaignResource::collection($campaigns), "Campaigns retrieved successfully");
    }

    /**
     * Store campaign.
     */
    public function store(StoreCampaignRequest $request)
    {
        $this->authorize('create', Campaign::class);
        $validated = $request->validated();
        $campaign = $this->service->save($validated);
        return ApiResponse::success(new CampaignResource($campaign), "Campaign created successfully", 201);
    }

    /**
     * Display campaign.
     */
    public function show(Campaign $campaign)
    {
        $this->authorize('view', $campaign);
        $campaign = $this->service->show($campaign);
        return ApiResponse::success(new CampaignResource($campaign));
    }

    /**
     * Update campaign.
     */
    public function update(UpdateCampaignRequest $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);
        $validated = $request->validated();
        $campaign = $this->service->update($campaign, $validated);
        return ApiResponse::success([], "Campaign updated successfully");
    }

    /**
     * Remove campaign.
     */
    public function destroy(Campaign $campaign)
    {
        $this->authorize('delete', $campaign);
        $this->service->delete($campaign);
        return ApiResponse::success(null, "Campaign deleted successfully");
    }


    /**
     * analytics.
     *  some KPI for the campaign
     */
    public function analytics(Campaign $campaign)
    {
        $this->authorize('view', $campaign);

        $stats = $this->campaignAnalytics->getStats($campaign);

        return ApiResponse::success([
            'campaign' => new CampaignResource($campaign),
            'analytics' => $stats,
        ]);
    }
}
