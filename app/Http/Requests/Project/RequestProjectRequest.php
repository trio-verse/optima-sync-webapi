<?php

namespace App\Http\Requests\Project;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RequestProjectRequest extends FormRequest
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
            // client info
            'name' => ['required' , 'string'],
            'phone' => ['required', 'string', 'regex:/^\+[1-9][0-9]{1,14}$/', 'max:14'],
            'email' => ['nullable', 'email', 'max:255'],
            // project info
            'title' => ['required' , 'string'],
            'description' => ['required' , 'string' , 'max:255'],
            'attachments' => ['array' , 'sometimes']
        ];
    }
}
