<?php

namespace App\Models\verification;

use App\Models\User_auth\UserCredentialsModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rejections extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'message',
        'office_id',
        'role',
        'created_by'
    ];

    public function user_credentials()
    {
        return $this->belongsTo(UserCredentialsModel::class, 'user_id');
    }
}