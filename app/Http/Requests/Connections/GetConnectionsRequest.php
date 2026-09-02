<?php

namespace App\Http\Requests\Connections;

use App\Enums\enConnectionStages;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetConnectionsRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'per_page' => 'integer|min:1|max:100',
            'page' => 'integer|min:1',
            'sort' => 'string|in:asc,desc',
            'order' => 'string|in:created_at,name,email,phone',
            'stage' => ['string', Rule::in(array_merge(enConnectionStages::all(), ['all', '*']))],
            'clientName' => 'string|nullable',
            'product_id' => 'nullable|exists:products,id'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'stage' => strtolower($this->stage) == 'all' ? '*' : strtolower($this->stage),
        ]);
    }
}
