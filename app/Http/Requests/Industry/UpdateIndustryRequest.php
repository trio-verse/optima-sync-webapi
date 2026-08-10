<?php

namespace App\Http\Requests\Industry;

use App\Http\Requests\BaseTagsRequest;
use App\Singleton\TenantManager;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateIndustryRequest extends BaseTagsRequest
{

    public function __construct()
    {
        $this->table_name = 'industries';
        $this->model_name = 'industry';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->updateRequest();
    }
}
