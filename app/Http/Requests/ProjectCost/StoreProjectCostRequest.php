<?php

namespace App\Http\Requests\ProjectCost;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectCostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'quantity' => ['sometimes', 'integer', 'min:1'],
            'amount' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Cost name is required',
            'amount.required' => 'Amount is required',
            'amount.min' => 'Amount must be at least 0',
        ];
    }
}
