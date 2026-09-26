<?php

namespace App\Http\Requests\Project\Query;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProjectQueryRequest extends FormRequest
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
            'query' => [
                'required',
                'array',
            ],

            'query.logic' => [
                'required',
                'string',
                'in:and,or',
            ],

            'query.conditions' => [
                'present',
                'array',
                'max:50',
            ],

            'query.conditions.*.field' => [
                'required_with:query.conditions.*',
                'string',
            ],

            'query.conditions.*.operator' => [
                'required_with:query.conditions.*',
                'string',
            ],

            'query.conditions.*.value' => [
                'present',
            ],

            'metrics' => [
                'nullable',
                'array',
            ],

            'metrics.*' => [
                'string',
            ],

            'charts' => [
                'nullable',
                'array',
            ],

            'charts.*' => [
                'string',
            ],

            'page' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'per_page' => [
                'nullable',
                'integer',
                'min:1',
                'max:100',
            ],
        ];
    }
}
