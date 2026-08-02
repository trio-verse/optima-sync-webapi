<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Str;

#[Fillable(['name', 'slug', 'price', 'description'])]
class Product extends Model
{
    use HasFactory;

    protected function slug(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value,
            set: fn($value) => Str::slug($value),
        );
    }


}
