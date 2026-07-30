<?php

namespace App\Models;

use App\QueriesBuilder\ClientQuery;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'organization_id',
    'name',
    'email',
    'phone',
    'address',
    'phone',
    'email',
    'whatsapp',
    'website',
    'city_id',
    'industry_id',
    'client_type',
    'notes'
])]
class Client extends Model
{

    public function newEloquentBuilder($query): ClientQuery
    {
        return new ClientQuery($query);
    }

    protected $appends = [
        'full_address',
        'city_name',
        'industry_name',
    ];
    // Query Builder
    

    // Relationships
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }


    // public function projects()
    // {
    //     return $this->hasMany(Project::class);
    // }

    //    public funcrtion stackholders(){
    //       return $this->hasMany(Stackholder::class);
    //    }



    // Mutator
    protected function fullAddress(): Attribute
    {
        return Attribute::make(
            get: fn() => trim($this->address . ', ' . $this->city?->name, ', '),
        );
    }

    protected function cityName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->city?->name,
        );
    }

    protected function industryName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->industry?->name,
        );
    }

    protected function email(): Attribute
    {
        return Attribute::make(
            set: fn(?string $value) => $value ? strtolower(trim($value)) : null,
        );
    }

    protected function phone(): Attribute
    {
        return Attribute::make(
            set: fn(?string $value) => $value ? preg_replace('/\s+/', '', $value) : null,
        );
    }

}
