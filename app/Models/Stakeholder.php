<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stakeholder extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'name',
        'phone',
        'role'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
