<?php

namespace App\Http\Requests\ProjectVersion;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectVersionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'based_on_version_id' => ['nullable', 'integer', 'min:1'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'change_description' => ['nullable', 'string'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'duration' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'end_date.after_or_equal' => 'End date must be after or equal to start date',
        ];
    }
}
