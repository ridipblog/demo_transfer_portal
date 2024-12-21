<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForgotPasswordManagerModel extends Model
{
    use HasFactory;
    protected $table = 'forgot_password_manager';
    protected $fillable = [
        'phone',
        'otp',
        'expire_time',
        'is_used',
    ];
}
