<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GovtIDTypeModel extends Model
{
    use HasFactory;
    protected $table='govt__i_d_type';
    protected $fillable=[
        'ID_type'
    ];
}
