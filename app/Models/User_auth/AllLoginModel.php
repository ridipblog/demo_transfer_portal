<?php

namespace App\Models\User_auth;

use App\Models\Public\RolesModel;
use App\Models\verification\appointing_authorities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AllLoginModel extends Authenticatable
{
    use HasApiTokens,HasFactory ,Notifiable;
    protected $guard='user_guard';
    protected $table = 'all_login';
    protected $fillable = [
        'user_id',
        'user_type',
        'phone',
        'password',
        'role_id',
        'status',
    ];
    protected $hidden=[
        'password'
    ];
    public function roles(){
        return $this->belongsTo(RolesModel::class,'role_id');
    }
    public function user_credentials(){
        return $this->belongsTo(UserCredentialsModel::class,'user_id');
    }
    public function appointing_authorities(){
        return $this->belongsTo(appointing_authorities::class,'user_id');
    }
}
