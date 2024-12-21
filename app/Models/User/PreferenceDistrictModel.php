<?php

namespace App\Models\User;

use App\Models\Public\DistrictModel;
use App\Models\User_auth\UserCredentialsModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferenceDistrictModel extends Model
{
    use HasFactory;
    protected $table = 'preferences_district';
    protected $fillable = [
        'user_id',
        'district_id',
        'form_status',
        'remarks',
    ];
    public function user_credentials()
    {
        return $this->belongsTo(UserCredentialsModel::class, 'user_id');
    }
    public function districts(){
        return $this->belongsTo(DistrictModel::class,'district_id');
    }
    public function employement_details_employment(){
        return $this->belongsTo(EmploymentDetailsModel::class,'user_id','user_id');
    }
}
