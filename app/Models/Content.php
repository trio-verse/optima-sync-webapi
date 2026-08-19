<?php

namespace App\Models;

use App\Trait\BelongsToOrganization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    /** @use HasFactory<\Database\Factories\ContentFactory> */
    use HasFactory , BelongsToOrganization;

    protected $fillable = [
        'organization_id',
        'campaign_id',
        'channel_id',
        'title',
        'type',
        'description',
        'script',
        'cost',
        'cost_confirmed_by',
        'cost_confirmed_at',
        'published_at',
        'published_by',
        'status',
        'assigned_by',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'cost_confirmed_at' => 'datetime',
            'approved_at' => 'datetime',
        ];
    }
    protected $appends = [
        'is_published',
    ];
    protected $with = [
        'campaign',
        'channel',
        'assignedBy',
        'costConfirmedBy',
        'publishedBy',
    ];


    // relations
    public function campaign(){
        return $this->belongsTo(Campaign::class);
    }
    public function channel(){
        return $this->belongsTo(Channel::class);
    }
    public function assignedBy(){
        return $this->belongsTo(User::class, 'assigned_by');
    }
    public function costConfirmedBy(){
        return $this->belongsTo(User::class, 'cost_confirmed_by');
    }
    public function publishedBy(){
        return $this->belongsTo(User::class, 'published_by');
    }



    // Attributes
    public function getIsPublishedAttribute(): bool
    {
        return $this->status === 'published';
    }



    // Scopes
    public function scopePublished(Builder $query)
    {
        return $query->where('status', 'published');
    }

    public function scopeStatus(Builder $query, string $status)
    {
        return $query->where('status', $status);
    }

}
