<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisabilityTypesModel extends Model
{
    use HasFactory;
    protected $table='disabiity_types';
    protected $fillable=[
        'name'
    ];
}
