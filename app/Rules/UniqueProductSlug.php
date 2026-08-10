<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Illuminate\Support\Str;

class UniqueProductSlug implements ValidationRule
{
    protected ?string $ignoreId;

    public function __construct(?string $ignoreId = null)
    {
        $this->ignoreId = $ignoreId;
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Generate slug from the name value
        $slug = Str::slug($value);

        // Check if slug already exists
        $query = Product::where('slug', $slug);

        // If updating, ignore the current product
        if ($this->ignoreId) {
            $query->where('id', '!=', $this->ignoreId);
        }

        if ($query->exists()) {
            $fail("The product name '{$value}' is already taken. Please use a different name.");
        }
    }
}
