<?php

namespace App\Http\Requests\Media;


use Illuminate\Foundation\Http\FormRequest;

class UploadOrganizationLogoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Standard image rules
            'logo' => ['required', 'file', 'mimes:jpg,jpeg,png,webp', 'max:5120'], // 5MB max
        ];
    }
}
