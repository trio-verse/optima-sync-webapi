<?php
namespace App\Contracts;

use App\Models\ProjectVersion;


interface IQuotationService
{
    public function getPreviewData(ProjectVersion $version): array;
}