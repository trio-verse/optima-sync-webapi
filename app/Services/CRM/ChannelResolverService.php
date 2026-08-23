<?php

namespace App\Services\CRM;

use App\Models\Channel;

class ChannelResolverService
{
    public function resolveBySource(int $organizationId, ?string $source): ?Channel
    {
        if (empty($source))
            return null;

        return Channel::where('organization_id', $organizationId)
            ->where(
                fn($query) =>
                $query->whereRaw("LOWER(name) = ?", [strtolower($source)])
            )->first();
    }
}
