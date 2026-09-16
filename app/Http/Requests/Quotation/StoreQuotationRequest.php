<?php

namespace App\Http\Requests\Quotation;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuotationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 'quotation_number' => ['nullable', 'string', 'max:100'],
            // 'issue_date' => ['required', 'date'],
            'valid_until_days' => ['required', 'integer' , 'min:2'],
            'subtotal' => ['sometimes', 'numeric', 'min:0'],
            'discount' => ['sometimes', 'numeric', 'min:0'],
            'tax' => ['sometimes', 'numeric', 'min:0'],
            'total' => ['sometimes', 'numeric', 'min:0'],
            'payment_terms' => ['required', 'string']
        ];
    }

    public function messages(): array
    {
        return [
            'issue_date.required' => 'Issue date is required',
            'valid_until.required' => 'Valid until date is required',
            'valid_until.after_or_equal' => 'Valid until date must be after or equal to issue date',
        ];
    }
}
