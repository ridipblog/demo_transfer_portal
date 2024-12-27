<?php

namespace App\Models\User;

use App\Models\Public\CasteModel;
use App\Models\Public\DisabilityTypesModel;
use App\Models\Public\DistrictModel;
use App\Models\Public\GovtIDTypeModel;
use App\Models\User_auth\UserCredentialsModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersionalDetailsModel extends Model
{
    use HasFactory;
    protected $table = 'persional_details';
    protected $fillable = [
        'user_id',
        'gender',
        'date_of_birth',
        'father_name',
        'mother_name',
        'alt_phone_number',
        'category_id',
        'pan_number',
        'home_district_id'
    ];
    public function user_credentials()
    {
        return $this->belongsTo(UserCredentialsModel::class, 'user_id');
    }
    public function caste()
    {
        return $this->belongsTo(CasteModel::class, 'category_id');
    }
    public function districts()
    {
        return $this->belongsTo(DistrictModel::class, 'home_district_id');
    }
}
