<?php

namespace App\Http\Requests\product;

use App\Rules\UniqueProductSlug;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        // Get the product ID from the route parameter
        $productId = $this->route('product');

        return [
            'name' => ['sometimes', 'string', 'max:255', new UniqueProductSlug($productId)],
            'price' => 'sometimes|numeric',
            'description' => 'sometimes|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.string' => 'The product name must be a text value.',
            'name.max' => 'The product name must not exceed 255 characters.',
            'price.numeric' => 'The product price must be a number.',
            'description.string' => 'The product description must be a text value.',
            'description.max' => 'The product description must not exceed 255 characters.',
        ];
    }
}
