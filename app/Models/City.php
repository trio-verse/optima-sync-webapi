<?php

namespace App\Models;

use App\Trait\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory , BelongsToOrganization;

    protected $fillable = ['name', 'color' , 'organization_id'];


    // Relations
}
