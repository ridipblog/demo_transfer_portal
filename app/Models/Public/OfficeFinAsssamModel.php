<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficeFinAsssamModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'offices_finassam';
    protected $fillable = [
        'name',
        'department_id',
        'district_id',
        'DDO',
        'office_code',
        'trs_code',
        'assign_by'
    ];
    protected $dates = ['deleted_at'];
    public function deptartments()
    {
        return $this->belongsTo(DepertmentModel::class, 'department_id');
    }
    public function districts()
    {
        return $this->belongsTo(DistrictModel::class, 'district_id');
    }
    public function office_dist_dept_map()
    {
        return $this->hasMany(OfficesDistDeptModel::class, 'office_id');
    }
}