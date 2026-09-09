<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Quotation\StoreQuotationRequest;
use App\Http\Requests\Quotation\UpdateQuotationRequest;
use App\Http\Resources\V1\QuotationResource;
use App\Support\FakePersistence\ProjectModuleFakeStore;
use Database\Factories\QuotationFactory;
use Illuminate\Http\JsonResponse;

/**
 * @group Quotations
 *
 * APIs for managing quotations (fake persistence — no DB yet)
 */
class QuotationController extends Controller
{
    public function __construct(
        protected ProjectModuleFakeStore $store
    ) {
    }

    /**
     * list
     * @return JsonResponse
     */
    public function index(string $project, string $version): JsonResponse
    {
        $quotations = $this->store->quotations()->where(
            fn(array $quotation) => (int) $quotation['project_version_id'] === (int) $version
        );

        return ApiResponse::success(
            QuotationResource::collection($quotations),
            'Quotations retrieved successfully'
        );
    }

    /**
     * store
     * @return JsonResponse
     */
    public function store(StoreQuotationRequest $request, string $project, string $version): JsonResponse
    {
        $validated = $request->validated();
        $projectItem = $this->store->projects()->find((int) $project);
        $projectSubTotal = (float) ($projectItem['sub_total'] ?? 0);
        $projectProfitPercentage = (float) ($projectItem['profit_percentage'] ?? 0);
        $subtotal = (float) ($projectItem['total_amount'] ?? ($projectSubTotal * (1 + ($projectProfitPercentage / 100))));
        $discount = (float) ($validated['discount'] ?? 0);
        $tax = (float) ($validated['tax'] ?? 0);
        $total = $subtotal - $discount + $tax;

        $quotation = $this->store->quotations()->create(QuotationFactory::dto(0, (int) $version, array_merge($validated, [
            'quotation_number' => $validated['quotation_number'] ?? sprintf('QTN-%s-%04d', now()->format('Ym'), random_int(1, 9999)),
            'subtotal' => number_format($subtotal, 2, '.', ''),
            'discount' => number_format($discount, 2, '.', ''),
            'tax' => number_format($tax, 2, '.', ''),
            'total' => number_format($total, 2, '.', ''),
            'pdf_path' => null,
            'created_by' => 1,
            'created_by_user' => [
                'id' => 1,
                'name' => 'Admin User',
                'email' => 'admin@optima.test',
            ],
        ])));

        return ApiResponse::success(new QuotationResource($quotation), 'Quotation created successfully', 201);
    }

    /**
     * show
     * @return JsonResponse
     */
    public function show(string $project, string $version, string $quotation): JsonResponse
    {
        $item = $this->findForVersion((int) $version, (int) $quotation);

        if (!$item) {
            return ApiResponse::notFound('Quotation not found');
        }

        return ApiResponse::success(new QuotationResource($item), 'Quotation retrieved successfully');
    }

    /**
     * update
     * @return JsonResponse
     */
    public function update(UpdateQuotationRequest $request, string $project, string $version, string $quotation): JsonResponse
    {
        if (!$this->findForVersion((int) $version, (int) $quotation)) {
            return ApiResponse::notFound('Quotation not found');
        }

        $validated = $request->validated();
        $projectItem = $this->store->projects()->find((int) $project);
        $projectSubTotal = (float) ($projectItem['sub_total'] ?? 0);
        $projectProfitPercentage = (float) ($projectItem['profit_percentage'] ?? 0);
        $subtotal = (float) ($projectItem['total_amount'] ?? ($projectSubTotal * (1 + ($projectProfitPercentage / 100))));
        $discount = (float) ($validated['discount'] ?? $this->findForVersion((int) $version, (int) $quotation)['discount'] ?? 0);
        $tax = (float) ($validated['tax'] ?? $this->findForVersion((int) $version, (int) $quotation)['tax'] ?? 0);
        $total = $subtotal - $discount + $tax;

        $validated['subtotal'] = number_format($subtotal, 2, '.', '');
        $validated['discount'] = number_format($discount, 2, '.', '');
        $validated['tax'] = number_format($tax, 2, '.', '');
        $validated['total'] = number_format($total, 2, '.', '');

        $item = $this->store->quotations()->update((int) $quotation, $validated);

        return ApiResponse::success(new QuotationResource($item), 'Quotation updated successfully');
    }

    /**
     * delete quotation
     */
    public function destroy(string $project, string $version, string $quotation)
    {
        if (!$this->findForVersion((int) $version, (int) $quotation)) {
            return ApiResponse::notFound('Quotation not found');
        }


        $item = $this->store->quotations()->delete((int) $quotation);

        return ApiResponse::success(new QuotationResource($item), 'Quotation updated successfully');

    }
    /**
     * generate pdf
     * @return JsonResponse
     */
    public function generatePdf(string $project, string $version, string $quotation): JsonResponse
    {
        if (!$this->findForVersion((int) $version, (int) $quotation)) {
            return ApiResponse::notFound('Quotation not found');
        }

        $item = $this->store->quotations()->update((int) $quotation, [
            'pdf_path' => sprintf('quotations/QTN-%s-%04d.pdf', now()->format('Ym'), (int) $quotation),
        ]);

        return ApiResponse::success(new QuotationResource($item), 'PDF generated successfully');
    }

    private function findForVersion(int $versionId, int $quotationId): ?array
    {
        $item = $this->store->quotations()->find($quotationId);

        if (!$item || (int) $item['project_version_id'] !== $versionId) {
            return null;
        }

        return $item;
    }
}
