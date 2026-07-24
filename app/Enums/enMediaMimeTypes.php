<?php

namespace App\Enums;

enum enMediaMimeTypes: string
{
    case JPEG = 'image/jpeg';
    case JPG = 'image/jpg';
    case PNG = 'image/png';
    case WEBP = 'image/webp';
    case GIF = 'image/gif';
    case SVG = 'image/svg+xml';

    case PDF = 'application/pdf';
    case ZIP = 'application/zip';
    case DOC = 'application/msword';
    case DOCX = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
    case XLS = 'application/vnd.ms-excel';
    case XLSX = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
    case PPT = 'application/vnd.ms-powerpoint';
    case PPTX = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
    case TXT = 'text/plain';
    case CSV = 'text/csv';


    public static function imageTypes(): array
    {
        return [
            self::JPEG->value,
            self::JPG->value,
            self::PNG->value,
            self::WEBP->value,
            self::GIF->value,
            self::SVG->value,
        ];
    }

    public static function documentTypes(): array
    {
        return [
            self::PDF->value,
            self::DOC->value,
            self::DOCX->value,
            self::XLS->value,
            self::XLSX->value,
            self::PPT->value,
            self::PPTX->value,
            self::TXT->value,
            self::CSV->value,
        ];
    }

    public static function all(): array
    {
        return array_map(fn(self $type) => $type->value, self::cases());
    }

    public static function isImage(string $mimeType): bool
    {
        return in_array($mimeType, self::imageTypes(), true);
    }
}
