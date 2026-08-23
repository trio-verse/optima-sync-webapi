<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 *  @group admin_lead_capture
 */
class CampaignCaptureController extends Controller
{
    /**
     * show campaign caputer settings.
     * GET /campaigns/{campaign}/capture
     * Returns capture link, QR code data, and current config.
     */
    public function show(Campaign $campaign): JsonResponse
    {
        return ApiResponse::success([
            'enabled' => $campaign->capture_form_enabled,
            'capture_url' => $campaign->capture_url,

            // 'qr_code' => $campaign->capture_url
            //     ? $this->generateQrDataUri($campaign->capture_url)
            //     : null,
        ]);
    }

    /**
     * Enable or disable the capture form.
     * PATCH /campaigns/{campaign}/capture
     * Body: { "enabled": true }
     */
    public function update(Request $request, Campaign $campaign): JsonResponse
    {
        $request->validate(['enabled' => ['required', 'boolean']]);

        $campaign->update(['capture_form_enabled' => $request->boolean('enabled')]);

        return ApiResponse::success([
            'enabled' => $campaign->capture_form_enabled,
            'capture_url' => $campaign->capture_url,
        ]);
    }


    /**
     * Invalidates the current token and generate a new one.
     * POST /campaigns/{campaign}/capture/regenerate-token
     * Use when a token is leaked or a campaign is cloned and needs a fresh link.
     */
    public function regenerateToken(Campaign $campaign): JsonResponse
    {
        $campaign->update(['capture_token' => Str::random(48)]);

        return ApiResponse::success([
            'enabled' => $campaign->capture_form_enabled,
            'capture_url' => $campaign->capture_url,
        ]);
    }



}
