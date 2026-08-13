<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
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
            'email' => 'required|email',
            'otp' => 'required|string|min:6|max:6',
        ];
    }

    /**
     * Get body parameters for Scribe documentation.
     *
     * @return array
     */
    public function bodyParameters(): array
    {
        return [
            'email' => [
                'description' => 'The email address',
                'required' => true,
                'example' => 'user@example.com'
            ],
            'otp' => [
                'description' => 'The OTP code received via email',
                'required' => true,
                'example' => '123456'
            ]
        ];
    }
}
