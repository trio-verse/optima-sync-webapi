<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color'
    ];
    
    // public function Clients()
    // {
    //     return $this->hasMany(Client::class);
    // }


}
