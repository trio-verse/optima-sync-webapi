<?php

namespace App\Rules;

use App\Models\Connection;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class CheckConnectionStatusRule implements ValidationRule
{


    public $organization_id;
    public $client_id;
    public $product_id;
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function __construct( $client_id, $product_id)
    {
        // $this->organization_id = $organization_id;
        $this->client_id = $client_id;
        $this->product_id = $product_id;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = Connection::where('client_id' , '=' , $this->client_id)
        ->where('product_id' , '=' , $this->product_id)
        ->exists();
        if($exists){
            $fail('The selected client is already connected to this product.');
        }
    }
}
