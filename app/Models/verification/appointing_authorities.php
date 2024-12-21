<?php

namespace App\Models\verification;

use App\Models\authority_office_dist_map;
use App\Models\department\departments;
use App\Models\Public\DistrictModel;
use App\Models\Public\PostsNameModel;
use App\Models\User_auth\AllLoginModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class appointing_authorities extends Model
{
    use HasFactory;

    protected $table = 'appointing_authorities';

    protected $fillable = [
        'name',
        'designation',
        'phone',
        'department',
        'office',
        'district',
        'first_login',
        'remarks_by',
        'authority_type',
    ];

    public function department()
    {
        return $this->belongsTo(departments::class, 'department');
    }
    public function departments()
    {
        return $this->belongsTo(departments::class, 'department');
    }
    public function office()
    {
        return $this->belongsTo(office::class, 'office');
    }
    public function district()
    {
        return $this->belongsTo(DistrictModel::class, 'district');
    }
    public function districts()
    {
        return $this->belongsTo(DistrictModel::class, 'district');
    }
    public function post_names()
    {
        return $this->belongsTo(PostsNameModel::class, 'designation');
    }
    public function all_logins(){
        return $this->hasMany(AllLoginModel::class,'user_id');
    }
    public function authority_office_dist_map(){
        return $this->hasMany(authority_office_dist_map::class,'user_id');
    }
}
