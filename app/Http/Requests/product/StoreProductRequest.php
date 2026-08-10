<?php

namespace App\Http\Requests\product;

use App\Rules\UniqueProductSlug;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:255', new UniqueProductSlug()],
            'price' => 'required|numeric',
            'description' => 'required|string|max:255',
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
            'name.required' => 'The product name is required.',
            'name.string' => 'The product name must be a text value.',
            'name.max' => 'The product name must not exceed 255 characters.',
            'price.required' => 'The product price is required.',
            'price.numeric' => 'The product price must be a number.',
            'description.required' => 'The product description is required.',
            'description.string' => 'The product description must be a text value.',
            'description.max' => 'The product description must not exceed 255 characters.',
        ];
    }
}
