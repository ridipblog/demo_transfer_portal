<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficesDistDeptModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'office_dist_dept_map';
    protected $fillable = [
        'office_id',
        'district_id',
        'depertment_id',
    ];
    protected $dates = ['deleted_at'];
    public function office_fin_assam()
    {
        return $this->belongsTo(OfficeFinAsssamModel::class, 'office_id');
    }
    public function deptartments()
    {
        return $this->belongsTo(DepertmentModel::class, 'depertment_id');
    }
    public function districts()
    {
        return $this->belongsTo(DistrictModel::class, 'district_id');
    }
}