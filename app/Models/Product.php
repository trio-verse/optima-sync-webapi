<?php

namespace App\Models;

use App\Trait\BelongsToOrganization;
use Dba\Connection;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Str;

#[Fillable(['name', 'slug', 'price', 'description' , 'organization_id'])]
class Product extends Model
{
    use HasFactory , BelongsToOrganization;

    protected function slug(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value,
            set: fn($value) => Str::slug($value),
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

}
