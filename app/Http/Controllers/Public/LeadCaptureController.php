<?php

namespace App\Http\Controllers\Public;

use App\Enums\enCampaignStatus;
use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Marketing\LeadCaptureRequest;
use App\Models\Campaign;
use App\Services\CRM\LeadCaptureService;
use Illuminate\Http\Request;

/**
 *  @group public_lead_Capture
 */
class LeadCaptureController extends Controller
{
    public function __construct(private readonly LeadCaptureService $service)
    {
    }

    /**
     * show the form.
     *
     * GET /capture/{token}
     * Returns the minimal public info needed to render the form.
     * Never exposes internal IDs, org data, or cost/analytics info.
     *
     * @param string $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $token)
    {
        $campaign = Campaign::where('capture_token', $token)
            ->where('capture_form_enabled')
            ->firstOrFail();

        return ApiResponse::success([
            'campaign_name' => $campaign->name,
            'is_accepting' => $campaign->status === enCampaignStatus::ACTIVE->value,
        ]);
    }


    /**
     * save the form data.
     * POST /capture/{token}
     * Processes the submission and creates Client + Connection.
     * @param LeadCaptureRequest $request
     * @param string $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LeadCaptureRequest $request, string $token)
    {
        $campaign = Campaign::where('capture_token', $token)
            ->where('capture_form_enabled', true)
            ->firstOrFail();
        $connection = $this->service->resolver($campaign, $request->validated(), $request->query('source'));

        return ApiResponse::success([], 'Thank you! Your submission has been received.', 201);
    }
}
