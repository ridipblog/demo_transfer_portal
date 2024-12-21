<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileStatusModel extends Model
{
    use HasFactory;
    protected $table='profile_status';
    protected $fillable=[
        'profile_status'
    ];
}
