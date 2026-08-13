<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductService
{
    public function createProduct(array $data): Product
    {
        // Slug will be auto-generated from name in the model's boot method
        $product = Product::create($data);
        return $product;
    }

    public function updateProduct(array $data, Product $product): bool
    {
        // Slug will be auto-updated if name changes in the model's boot method
        return $product->update($data);
    }

    public function getProductsList()
    {
        return Product::query()
            ->latest();
    }

    public function getProductById(int $id): Product
    {
        $product = Product::query()->findOrFail($id);
        if (!$product) {
            throw new NotFoundHttpException;
        }
        return $product;
    }

    public function deleteProduct(Product $product): bool
    {
        return $product->delete();
    }
}
