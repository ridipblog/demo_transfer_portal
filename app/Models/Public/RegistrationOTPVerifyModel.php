<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationOTPVerifyModel extends Model
{
    use HasFactory;
    protected $table = 'registration__o_t_p_verify';
    protected $fillable = [
        'phone',
        'OTP',
        'expire_time',
        'is_used',
    ];
}
