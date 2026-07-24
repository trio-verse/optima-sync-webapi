<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    protected $fillable = [
        'file_path',
        'file_name',
        'file_type',
        'mime_type',
        'size',
    ];

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }
}
