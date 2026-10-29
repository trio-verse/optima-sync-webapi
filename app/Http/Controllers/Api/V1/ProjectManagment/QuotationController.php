<?php

// namespace App\Http\Controllers\Api\V1;

namespace App\Http\Controllers\Api\V1\ProjectManagment;

use App\Contracts\IQuotationService;
use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectVersion;

/**
 * @group Quotations
 *
 * APIs for rendering project quotation previews and PDFs.
 */
class QuotationController extends Controller
{
    public function __construct(
        protected IQuotationService $service
    ) {
    }

    /**
     * preview quotation as data and send to the front to show the HTML page
     */
    public function preview(Project $project, ProjectVersion $version)
    {
        $this->authorize('view', $project);
        if ($version->project_id !== $project->id) {
            return ApiResponse::notFound('Version not found for this project');
        }

        $data = $this->service->getPreviewData($version);


        // return $html;
        return ApiResponse::success([
            'data' => $data,
            'meta' => [
                'quotation_number' => $data['quo_number'],
                'project_title' => $project->reference_id ?? $project->name ?? 'Project',
                'client_name' => $project->client?->name ?? 'Valued Client',
                'total' => number_format($data['total'], 2),
            ],
        ], 'Quotation preview rendered successfully');
    }

}
