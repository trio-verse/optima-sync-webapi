<?php

namespace App\Http\Requests\Quotation;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuotationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quotation_number' => ['sometimes', 'string', 'max:100'],
            'issue_date' => ['sometimes', 'date'],
            'valid_until' => ['sometimes', 'date', 'after_or_equal:issue_date'],
            'subtotal' => ['sometimes', 'numeric', 'min:0'],
            'discount' => ['sometimes', 'numeric', 'min:0'],
            'tax' => ['sometimes', 'numeric', 'min:0'],
            'total' => ['sometimes', 'numeric', 'min:0'],
            'pdf_path' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'valid_until.after_or_equal' => 'Valid until date must be after or equal to issue date',
        ];
    }
}
