<?php

namespace App\Models;

use App\Trait\BelongsToOrganization;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(
    [
        'client_id',
        'product_id',
        'assigne_id',
        'channel_id',
        'organization_id',
        'initiated_by',
        'stage'
    ]
)]
class Connection extends Model
{
    /** @use HasFactory<\Database\Factories\ConnectionFactory> */
    use HasFactory , BelongsToOrganization;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $attributes = [
        'stage' => 'LEAD',
    ];

    protected $appends = [
        'is_closed',
    ];
    protected $with = [
        'product',
        'client',
        'assignee'
    ];

    public function IsClosed(): Attribute
    {
        return new Attribute(
            get: fn() => in_array($this->stage, ['WIN', 'CLOSE'])
        );
    }

    // relations
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }
}
