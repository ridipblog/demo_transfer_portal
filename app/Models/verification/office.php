<?php

namespace App\Models\verification;


use App\Models\Public\DepertmentModel;
use App\Models\Public\DistrictModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class office extends Model
{
    use HasFactory;
protected $table='offices_finassam';
    protected $fillable = [
        'name',
        'department_id',
        'district_id'
    ];

    public function department(){
        return $this->belongsTo(DepertmentModel::class,'department_id');
    }
    public function district(){
        return $this->belongsTo(DistrictModel::class,'district_id');
    }

    public function appointingAuthorities()
    {
        return $this->hasMany(appointing_authorities::class, 'office');
    }
}
