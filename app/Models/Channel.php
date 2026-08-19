<?php

namespace App\Models;

use App\Trait\BelongsToOrganization;
use Database\Factories\ChannelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /** @use HasFactory<ChannelFactory> */
    use HasFactory, BelongsToOrganization;
    protected $fillable = [
        'name',
        'color',
        'organization_id'
    ];


    public function contents(){
        return $this->hasMany(Content::class);
    }
}
