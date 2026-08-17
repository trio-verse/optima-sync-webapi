<?php

namespace App\Models;

use App\Trait\BelongsToOrganization;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable([
    'connection_id',
    'user_id',
    'organization_id',
    'content',
    'metadata',
])]
class Activity extends Model
{
    /** @use HasFactory<\Database\Factories\ActivityFactory> */
    use HasFactory, BelongsToOrganization;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'metadata' => 'array',
    ];

    protected $with = [
        'user',
    ];

    // Relations
    public function connection(): BelongsTo
    {
        return $this->belongsTo(Connection::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent activity model (morphable for future flexibility)
     */
    public function activityable(): MorphTo
    {
        return $this->morphTo();
    }
}