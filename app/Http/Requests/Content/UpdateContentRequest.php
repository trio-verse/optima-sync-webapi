<?php

namespace App\Http\Requests\Content;

use App\Enums\enContentStatus;
use App\Models\Content;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContentRequest extends FormRequest
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

        return $this->user()->can('update', $content);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'channel_id' => ['sometimes', 'exists:channels,id'],
            'title' => ['sometimes', 'string', 'max:255'],
            'type' => ['sometimes', 'string', 'max:255'],
            'script' => ['nullable', 'string'],
            'cost' => ['nullable', 'numeric', 'min:0'],
            'status' => ['nullable', Rule::enum(enContentStatus::class)],
            'published_at' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
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
            'channel_id.exists' => 'The selected channel does not exist.',
            'title.max' => 'The title must not exceed 255 characters.',
            'type.max' => 'The type must not exceed 255 characters.',
            'cost.numeric' => 'The cost must be a valid number.',
            'cost.min' => 'The cost must be at least 0.',
            'status.enum' => 'The selected status is invalid.',
            'published_at.date' => 'The published date must be a valid date.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert cost to numeric if provided
        if ($this->has('cost') && is_string($this->cost)) {
            $this->merge([
                'cost' => (float) $this->cost,
            ]);
        }
    }
}
