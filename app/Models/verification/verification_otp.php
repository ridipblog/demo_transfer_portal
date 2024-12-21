<?php

namespace App\Models\verification;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class verification_otp extends Model
{
    use HasFactory;
    protected $table = 'verification_otps';
    protected $fillable = [
        'phone',
        'OTP',
        'expire_time',
        'is_used',
    ];
}
