<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Industry\StoreIndustryRequest;
use App\Http\Requests\Industry\UpdateIndustryRequest;
use App\Http\Resources\V1\IndustryResource;
use App\Models\Industry;
use App\Services\IndustryService;
use Illuminate\Http\JsonResponse;

/**
 * @group Industries
 */
class IndustryController extends Controller
{

    public function __construct(private IndustryService $industryService)
    {
    }
    /**
     * Display all Industries.
     * 
     * @return JsonResponse
     */
    public function index()
    {
        $industries = $this->industryService->getAllIndustries();

        return ApiResponse::response(IndustryResource::collection($industries), 'Data fetched successfully', 200);
    }


    /**
     * Store industry.
     * @param StoreIndustryRequest $request
     * @return JsonResponse
     */
    public function store(StoreIndustryRequest $request): JsonResponse
    {
        $industry = $this->industryService->create($request->validated());

        return ApiResponse::response(
            new IndustryResource($industry),
            'Industry created successfully',
            201
        );
    }

    /**
     * Update industry.
     * @param UpdateIndustryRequest $request
     * @param Industry $industry
     * @return JsonResponse
     */
    public function update(UpdateIndustryRequest $request, Industry $industry): JsonResponse
    {
        $industry = $this->industryService->update($request->validated(), $industry);

        return ApiResponse::response(
            new IndustryResource($industry),
            'Industry updated successfully',
            200
        );
    }

    /**
     * Delete industry.
     * @param Industry $industry
     * @return JsonResponse
     */
    public function delete(Industry $industry): JsonResponse
    {
        $isDeleted = $this->industryService->delete($industry);

        if ($isDeleted)
            return ApiResponse::response(
                [],
                'Industry deleted successfully',
                200
            );
        return ApiResponse::error('Industry not found', 404);

    }
}
