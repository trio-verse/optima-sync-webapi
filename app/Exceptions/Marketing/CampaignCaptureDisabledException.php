<?php

namespace App\Exceptions\Marketing;

use App\Models\Campaign;
use Exception;

class CampaignCaptureDisabledException extends Exception
{
    public function __construct(Campaign $campaign)
    {
        parent::__construct(
            "Campaign #{$campaign->id} dose not accept lead capture submission.",
            410
        );
    }
}
