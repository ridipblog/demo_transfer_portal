<?php

namespace App\Models;

use App\Models\Public\DepertmentModel;
use App\Models\Public\DistrictModel;
use App\Models\Public\OfficeFinAsssamModel;
use App\Models\Public\RolesModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class authority_office_dist_map extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'office_id',
        'district_id',
        'department_id',
        'role_id',
    ];
    public function office_fin_assam()
    {
        return $this->belongsTo(OfficeFinAsssamModel::class, 'office_id');
    }
    public function deptartments()
    {
        return $this->belongsTo(DepertmentModel::class, 'depertment_id');
    }
    public function new_deptartments()
    {
        return $this->belongsTo(DepertmentModel::class, 'department_id');
    }
    public function districts()
    {
        return $this->belongsTo(DistrictModel::class, 'district_id');
    }
    public function roles(){
        return $this->belongsTo(RolesModel::class,'role_id');
    }

}
