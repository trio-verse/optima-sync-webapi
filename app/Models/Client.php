<?php

namespace App\Models;

use App\Models\Connection;
use App\Policies\ClientPolicy;
use App\QueriesBuilder\ClientQuery;
use App\Trait\BelongsToOrganization;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
#[UsePolicy(ClientPolicy::class)]
class Client extends Model
{
    use HasFactory , BelongsToOrganization;

    protected $appends = [
        'full_address',
        'city_name',
        'industry_name',
    ];

    public function newEloquentBuilder($query): ClientQuery
    {
        return new ClientQuery($query);
    }

    // Relationships
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    // Direct relationship to Channels via Connections
    public function channels()
    {
        return $this->hasManyThrough(
            Channel::class,
            Connection::class,
            'client_id',  // FK on connections table
            'id',         // FK on channels table
            'id',         // Local key on clients table
            'channel_id'  // Local key on connections table
        );
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function stakeholders()
    {
        return $this->hasMany(Stakeholder::class);
    }


    /**
     * get all Client connections 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Connection, Client>
     */
    public function connections()
    {
        return $this->hasMany(Connection::class , 'client_id' , 'id');
    }



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
