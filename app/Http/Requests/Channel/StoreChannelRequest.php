<?php

namespace App\Http\Requests\Channel;

use App\Http\Requests\BaseTagsRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreChannelRequest extends BaseTagsRequest
{
 
        protected $table_name = 'channels';
        protected $model_name = 'channel';
     

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->storeRequest();
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
                'description' => 'The name of the channel',
                'required' => true,
                'example' => 'Social Media'
            ],
            'color' => [
                'description' => 'The color associated with the channel',
                'required' => true,
                'example' => '#3357FF'
            ]
        ];
    }
}
