<?php

namespace App\Models\Public;

use App\Models\verification\appointing_authorities;
use App\Models\verification\office;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistrictModel extends Model
{
    use HasFactory;
    protected $table='districts';
    protected $fillable=[
        'name',
        'status'
    ];

    public function appointingAuthorities()
    {
        return $this->hasMany(appointing_authorities::class, 'office');
    }

    public function office()
    {
        return $this->hasMany(office::class, 'office_id');
    }
}
