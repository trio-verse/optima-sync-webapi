<?php

namespace App\Models;

use App\Trait\BelongsToOrganization;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['organization_id', 'user_id', 'role'])]
class OrganizationMember extends Model
{
    use BelongsToOrganization;

    
    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    

}
