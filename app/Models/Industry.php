<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    protected $fillable = [
        'name',
        'color'
    ];
    
    // public function Clients()
    // {
    //     return $this->hasMany(Client::class);
    // }


}
