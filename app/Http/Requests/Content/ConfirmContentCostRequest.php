<?php

namespace App\Http\Requests\Content;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ConfirmContentCostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $content = $this->route('content');

        if (!$content) {
            return false;
        }

        return $this->user()->can('set_cost', $content);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cost' => ['sometimes', 'nullable', 'numeric', 'min:0'],
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'cost.numeric' => 'The cost must be a valid number.',
            'cost.min' => 'The cost must be at least 0.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('cost') && is_string($this->cost)) {
            $this->merge([
                'cost' => (float) $this->cost,
            ]);
        }
    }
}
