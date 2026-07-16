<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['email'])]
class OtpAuthentication extends Model
{
    /** @use HasFactory<\Database\Factories\OtpAuthenticationFactory> */
    use HasFactory;

    protected $table = 'otp_authentications';

    // public $timestamps = false;

}
