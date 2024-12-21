<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayScaleModel extends Model
{
    use HasFactory;
    protected $table='pay_scale';
    protected $fillable=[
        'pay_scale'
    ];
}
