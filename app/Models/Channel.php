<?php

namespace App\Models;

use App\Trait\BelongsToOrganization;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use BelongsToOrganization ;
    protected $fillable = [
        'name',
        'color',
        'organization_id'
    ];
}
