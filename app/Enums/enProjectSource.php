<?php

namespace App\Enums;

enum enProjectSource: string
{
    case INTERNAL = 'internal';
    case CLIENT = 'Client';
    public static function all(): array
    {
        return array_map(fn(self $type) => $type->value, self::cases());
    }
}