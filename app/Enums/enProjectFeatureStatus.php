<?php

namespace App\Enums;

enum enProjectFeatureStatus: string
{

    case NEW = 'new';
    case IN_PROGRESS = 'in_progress';
    case ON_HOLD = 'on_hold';
    case COMPLETED = 'completed';

    public static function all(): array
    {
        return array_map(fn(self $type) => $type->value, self::cases());
    }
}
