<?php

namespace App\Models;

use App\Models\Connection;
use App\Trait\BelongsToOrganization;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

#[Fillable(['name', 'slug', 'price', 'description', 'organization_id'])]
class Product extends Model
{
    use HasFactory, BelongsToOrganization;

    protected static function boot()
    {
        parent::boot();

        // Automatically generate slug from name when creating
        static::creating(function ($product) {
            if (empty($product->slug) && !empty($product->name)) {
                $product->slug = Str::slug($product->name);
            }
        });

        // Automatically update slug when name is updated
        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    protected function slug(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value,
            set: fn($value, $attributes) => Str::slug($attributes['name'] ?? $value),
        );
    }

    /**
     * get the client that connected to this product
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough<Client, Connection, Product>
     */
    public function clients()
    {
        return $this->hasManyThrough(Client::class, Connection::class, 'product_id', 'id', 'id', 'client_id');
    }

    public function connections()
    {
        return $this->hasMany(Connection::class, 'product_id', 'id');
    }

}
