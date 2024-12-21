<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionModel extends Model
{
    use HasFactory;
    protected $table='permissions';
    protected $fillable=[
        'permission'
    ];
}
