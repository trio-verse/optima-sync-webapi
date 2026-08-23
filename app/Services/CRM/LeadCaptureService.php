<?php

namespace App\Services\CRM;

use App\Enums\enCampaignStatus;
use App\Enums\enConnectionStages;
use App\Exceptions\Marketing\CampaignCaptureDisabledException;
use App\Models\Campaign;
use App\Models\Connection;
use Exception;

class LeadCaptureService
{
    public function __construct(
        private readonly ClientResolverService $clientResolver,
        private readonly ChannelResolverService $channelResolver
    ) {
    }

    public function resolver(Campaign $campaign, array $data, ?string $source): Connection
    {
        if (!$campaign->capture_form_enabled || $campaign->status !== enCampaignStatus::ACTIVE->value) {
            // throw new Exception('campaign capture disabled ');
            throw new CampaignCaptureDisabledException($campaign);
        }

        $client = $this->clientResolver->reslover($campaign->organization_id, $data);
        $channel = $this->channelResolver->resolveBySource($campaign->organization_id, $source);

        $connection = Connection::create([
            'organization_id' => $campaign->organization_id,
            'client_id' => $client->id,
            'campaign_id' => $campaign->id,
            'channel_id' => $channel?->id,
            'stage' => enConnectionStages::LEAD->value,
            'notes' => $data['message'] ?? null,
            'initiated_by' => $source ?? "capture_form"
        ]);

        // Fire event — listeners handle assignment rules + notifications
        // event(new ConnectionCreatedViaCapture($connection));

        return $connection;
    }
}
