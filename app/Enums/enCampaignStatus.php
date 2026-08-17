<?php

namespace App\Enums;

enum enCampaignStatus: string
{
    case ACTIVE = 'active';
    case DRAFT = 'draft';
    case PAUSED = 'paused';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
 
    public static function all(): array
    {
        return array_map(fn(self $type) => $type->value, self::cases());
    }
}
