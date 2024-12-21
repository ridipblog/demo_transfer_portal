<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesModel extends Model
{
    use HasFactory;
    protected $table='roles';
    protected $fillable=[
        'role'
    ];
}
