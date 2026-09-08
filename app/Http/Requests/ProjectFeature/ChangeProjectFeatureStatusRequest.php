<?php

namespace App\Http\Requests\ProjectFeature;

use App\Enums\enProjectFeatureStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeProjectFeatureStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'string', Rule::in(enProjectFeatureStatus::all())],
        ];
    }
}
