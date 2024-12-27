<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class additional_conditions extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'condition'
    ];
}