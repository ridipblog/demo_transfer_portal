<?php

namespace App\Models\User_auth;

use App\Models\Public\ProfileStatusModel;
use App\Models\Public\RolesModel;
use App\Models\Transfer\TransfersModel;
use App\Models\User\AdditionaInfoModel;
use App\Models\User\DocumentModel;
use App\Models\User\EmploymentDetailsModel;
use App\Models\User\PersionalDetailsModel;
use App\Models\User\PreferenceDistrictModel;
use App\Models\verification\appointing_authorities;
use GuzzleHttp\TransferStats;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserCredentialsModel extends  Model

{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'user_credentials';

    protected $fillable = [
        'full_name',
        'user_ref_code',
        'email',
        'phone',
        'profile_verify_status',
        'noc_generate',
        'verified_by',
        'noc_generated_by',
        'verified_remarks_status',
        'noc_remarks_status',
        'verified_remarks',
        'noc_remarks',
        'verified_on',
        'noc_generated_on',
    ];
    public function profile_status()
    {
        return $this->belongsTo(ProfileStatusModel::class, 'profile_status');
    }
    public function persional_details()
    {
        return $this->hasOne(PersionalDetailsModel::class, 'user_id');
    }
    public function employment_details()
    {
        return $this->hasOne(EmploymentDetailsModel::class, 'user_id');
    }
    public function preferences_district()
    {
        return $this->hasMany(PreferenceDistrictModel::class, 'user_id');
    }
    public function documents()
    {
        return $this->hasMany(DocumentModel::class, 'user_id');
    }
    public function additional_info()
    {
        return $this->hasOne(AdditionaInfoModel::class, 'user_id');
    }
    public function employee_transfer_request()
    {
        return $this->hasMany(TransfersModel::class, 'employee_id');
    }
    public function employee_transfer_target_request()
    {
        return $this->hasMany(TransfersModel::class, 'target_employee_id');
    }
    public function noc_generated_by_user()
    {
        return $this->belongsTo(appointing_authorities::class, 'noc_generated_by');
    }
}