<?php

namespace App\Models\User;

use App\Models\Public\DepertmentModel;
use App\Models\Public\DistrictModel;
use App\Models\Public\OfficeFinAsssamModel;
use App\Models\Public\PayScaleModel;
use App\Models\Public\PostsNameModel;
use App\Models\Transfer\TransfersModel;
use App\Models\User_auth\UserCredentialsModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploymentDetailsModel extends Model
{
    use HasFactory;
    protected $table = 'employment_details';
    protected $fillable = [
        'user_id',
        'district_id',
        'depertment_id',
        'ddo_code',
        'office_id',
        'designation_id',
        'first_date_of_joining',
        'current_date_of_joining',
        'pay_grade',
        'pay_band',
        'dept_post_id',
        'ex_serviceman'
    ];
    public function user_credentials()
    {
        return $this->belongsTo(UserCredentialsModel::class, 'user_id');
    }
    public function districts()
    {
        return $this->belongsTo(DistrictModel::class, 'district_id');
    }
    public function offices_finassam(){
        return $this->belongsTo(OfficeFinAsssamModel::class,'office_id');
    }
    public function post_names(){
        return $this->belongsTo(PostsNameModel::class,'designation_id');
    }
    public function departments()
    {
        return $this->belongsTo(DepertmentModel::class, 'depertment_id');
    }
    public function preference_district_employment(){
        return $this->hasMany(PreferenceDistrictModel::class,'user_id','user_id');
    }
    public function employee_transfer_request_employment()
    {
        return $this->hasMany(TransfersModel::class, 'employee_id','user_id');
    }
    public function employee_transfer_target_request_employment()
    {
        return $this->hasMany(TransfersModel::class, 'target_employee_id','user_id');
    }
}
