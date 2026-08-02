<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function createProduct(array $data): Product
    {
        $product = Product::create($data)->first();
        return $product;
    }

    public function updateProduct(array $data, Product $product): bool
    {
        $product->update($data);
        return $product->save();
    }

    public function getProductsList()
    {
        return Product::query()
            ->latest()
            ->paginate(15);
    }

    public function getProductById(int $id): Product
    {
        return Product::query()->find($id);
    }

    public function deleteProduct(Product $product): bool
    {
        return $product->delete();
    }
}
