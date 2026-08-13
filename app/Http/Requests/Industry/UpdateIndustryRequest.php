<?php

namespace App\Http\Requests\Industry;

use App\Http\Requests\BaseTagsRequest;
use App\Singleton\TenantManager;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateIndustryRequest extends BaseTagsRequest
{
    protected $table_name = 'industries';
    protected $model_name = 'industry';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->updateRequest();
    }

    /**
     * Get body parameters for Scribe documentation.
     *
     * @return array
     */
    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'The name of the industry',
                'required' => false,
                'example' => 'Technology'
            ],
            'color' => [
                'description' => 'The color associated with the industry',
                'required' => false,
                'example' => '#33FF57'
            ]
        ];
    }
}
