<?php

namespace App\Models;

use App\Trait\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    use HasFactory , BelongsToOrganization;

    protected $fillable = [
        'name',
        'color',
        'organization_id'
    ];
    
    // public function Clients()
    // {
    //     return $this->hasMany(Client::class);
    // }


}
