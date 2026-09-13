<?php

namespace App\Http\Requests\ProjectCost;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectCostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'quantity' => ['sometimes', 'integer', 'min:1'],
            'amount' => ['sometimes', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.min' => 'Amount must be at least 0',
        ];
    }
}
