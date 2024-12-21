<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesPermissionsModel extends Model
{
    use HasFactory;
    protected $table='role_permission';
    protected $fillable=[
        'role_id',
        'permission_id'
    ];
}
