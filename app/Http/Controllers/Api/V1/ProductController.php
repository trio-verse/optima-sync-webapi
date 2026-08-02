<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\product\StoreProductRequest as ProductStoreProductRequest;
use App\Http\Requests\product\UpdateProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService)
    {
    }
    /**
     * Display Products.
     * show a list of latest added products with pagination
     */
    public function index()
    {
        $products = $this->productService->getProductsList();

        return ApiResponse::success($products, 'products retrieved successfully');
    }

    /**
     * Store new Product.
     */
    public function store(ProductStoreProductRequest $request)
    {
        try {
            $validated = $request->validated();
            $product = $this->productService->createProduct($validated);
            return ApiResponse::success($product, "product created successfully", 201);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(null, "server error", 500);
        }
    }


    /**
     * Show Product.
     */
    public function show(Product $product)
    {
        $product = $this->productService->getProductById($product->id);
        return ApiResponse::success($product, "product retrieved successfully", 200);
    }

    /**
     * Update Product.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $validated = $request->validated();
            $product = $this->productService->updateProduct(
                $validated,
                $product
            );
            return ApiResponse::success([], "product retrieved successfully", 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(null, "server error", 500);
        }
    }

    /**
     * Delete Product.
     */
    public function destroy(Product $product)
    {
        try {
            $this->productService->deleteProduct($product);
            return ApiResponse::success(null, "product deleted successfully", 200);
            
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(null, "server error", 500);
        }
    }
}
