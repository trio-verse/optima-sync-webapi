<?php

namespace App\Enums;

enum enMediaFileTypes: string
{
    case LOGO = 'logo';
    case PROJECT_DETAIL = 'project_detail';
    case DOCUMENT = 'document';

    public static function all(): array
    {
        return array_map(fn(self $type) => $type->value, self::cases());
    }
}
