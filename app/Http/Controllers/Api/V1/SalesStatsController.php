<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Sales\SalesService;
use Illuminate\Http\Request;

class SalesStatsController extends Controller
{
    public function __construct(private SalesService $salesService)
    {
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = $this->salesService->getSalesStats();
        // return response()->json($data);
        return ApiResponse::success($data);
        
    }
}
