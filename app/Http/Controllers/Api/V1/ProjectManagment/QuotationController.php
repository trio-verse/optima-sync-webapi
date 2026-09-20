<?php

// namespace App\Http\Controllers\Api\V1;
namespace App\Http\Controllers\Api\V1\ProjectManagment;


use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectVersion;
use App\Services\ProjectManagment\QuotationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @group Quotations
 *
 * APIs for rendering project quotation previews and PDFs.
 */
class QuotationController extends Controller
{
    public function __construct(
        protected QuotationService $service
    ) {
    }

    /**
     * generate pdf via browsershot
     * @return JsonResponse
     */
    public function generatePdf(Project $project, ProjectVersion $version): JsonResponse
    {
        if ($version->project_id !== $project->id) {
            return ApiResponse::notFound('Version not found for this project');
        }

        $result = $this->service->generatePdf($version);

        return $result['success']
            ? ApiResponse::success($result, $result['message'])
            : ApiResponse::error(null, $result['message'], 500);
    }

    /**
     * preview quotation as HTML (for editing in browser)
     */
    public function preview(Project $project, ProjectVersion $version)
    {
        if ($version->project_id !== $project->id) {
            return ApiResponse::notFound('Version not found for this project');
        }

        $data = $this->service->previewData($version);


        $html = view('quotations.quotation', ['data' => $data])->render();

        // return $html;
        return ApiResponse::success([
            'html' => $html,
            'meta' => [
                'quotation_number' => $data['quo_number'],
                'project_title' => $project->reference_id ?? $project->name ?? 'Project',
                'client_name' => $project->client?->name ?? 'Valued Client',
                'total' => number_format($data['total'], 2),
            ],
        ], 'Quotation preview rendered successfully');
    }

    /**
     * download quotation PDF
     */
    public function downloadPdf(Project $project, ProjectVersion $version): Response
    {
        if ($version->project_id !== $project->id) {
            abort(404, 'Version not found for this project');
        }

        return $this->service->downloadPdf($version);
    }


}
