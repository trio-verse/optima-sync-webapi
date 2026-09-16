<?php

// namespace App\Http\Controllers\Api\V1;
namespace App\Http\Controllers\Api\V1\ProjectManagment;


use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Quotation\StoreQuotationRequest;
use App\Http\Requests\Quotation\UpdateQuotationRequest;
use App\Models\Project;
use App\Models\ProjectVersion;
use App\Models\Quotation;
use App\Services\ProjectManagment\QuotationService;
use App\Support\FakePersistence\ProjectModuleFakeStore;
use Database\Factories\QuotationFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * @group Quotations
 *
 * APIs for managing quotations (fake persistence — no DB yet)
 */
class QuotationController extends Controller
{
    public function __construct(
        protected QuotationService $service
    ) {
    }

    /**
     * list
     * @return JsonResponse
     */
    public function index(Project $project): JsonResponse
    {

        $quotations = $project->quotations ;

        return ApiResponse::success(
            \App\Http\Resources\V1\ProjectManagment\QuotationResource::collection($quotations),
            'Quotations retrieved successfully'
        );
    }

    /**
     * store
     * @return JsonResponse
     */
    public function store(StoreQuotationRequest $request, int $project, ProjectVersion $version): JsonResponse
    {
        $validated = $request->validated();
        // $quotation = Quotation::create($validated);
        $validated['issue_date'] = now();
        $validated['valid_until'] = now()->addDays((int) $validated['valid_until_days']);


        DB::transaction(function () use ($version, $validated) {

            $quotation = $version->quotation()->create([
                "valid_until" => $validated['valid_until'],
                "discount" => $validated['discount'],
                "tax" => $validated['tax'],
                "payment_terms" => $validated['payment_terms'],
                "issue_date" => $validated['issue_date'],
                "data" => [],
                "created_by" => auth()->id()
            ]);

        });
        return ApiResponse::success([], 'Quotation created successfully', 201);
    }



    /**
     * generate pdf via browsershot
     * @return JsonResponse
     */
    public function generatePdf(Project $project, ProjectVersion $version, Quotation $quotation): JsonResponse
    {
        if ($version->project_id !== $project->id) {
            return ApiResponse::notFound('Version not found for this project');
        }

        if ($quotation->project_version_id !== $version->id) {
            return ApiResponse::notFound('Quotation not found for this version');
        }

        $result = $this->service->generatePdf($quotation);

        if (!$result['success']) {
            return ApiResponse::error(null, $result['message'], 500);
        }

        return ApiResponse::success($result, $result['message']);
    }

    /**
     * preview quotation as HTML (for editing in browser)
     */
    public function preview(Project $project, ProjectVersion $version)
    {
        if ($version->project_id !== $project->id) {
            return ApiResponse::notFound('Version not found for this project');
        }

        $quotation = $version->quotation;

        if (!$quotation) {
            $quotation = new Quotation([
                'project_version_id' => $version->id,
                'quotation_number' => Quotation::generateQuotationNumber(),
                'issue_date' => now(),
                'valid_until' => now()->addDays(30),
                'subtotal' => 0,
                'discount' => 0,
                'tax' => 0,
                'total' => 0,
                'payment_terms' => config('app.payment_terms', 'Net 30'),
                'data' => [],
            ]);
        }

        $data = $this->service->previewData($quotation);


        $html = view('quotations.quotation', ['data' => $data])->render();

        // return $html ;
        return ApiResponse::success([
            'html' => $html,
            'meta' => [
                'quotation_id' => $quotation->id,
                'quotation_number' => $quotation->quotation_number,
                'project_title' => $project->reference_id ?? $project->name ?? 'Project',
                'client_name' => $project->client?->name ?? 'Valued Client',
                'total' => number_format($data['total'], 2),
            ],
        ], 'Quotation preview rendered successfully');
    }

    /**
     * download quotation PDF
     */
    public function downloadPdf(Project $project, ProjectVersion $version, Quotation $quotation): Response
    {
        if ($version->project_id !== $project->id) {
            abort(404, 'Version not found for this project');
        }

        if ($quotation->project_version_id !== $version->id) {
            abort(404, 'Quotation not found for this version');
        }

        return $this->service->downloadPdf($quotation);
    }


}
