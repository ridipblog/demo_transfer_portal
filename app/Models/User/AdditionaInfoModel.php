<?php

namespace App\Models\User;

use App\Models\User_auth\UserCredentialsModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionaInfoModel extends Model
{
    use HasFactory;
    protected $table = 'additional_info';
    protected $fillable = [
        'user_id',
        'criminal_case',
        'departmental_proceedings',
        'mutual_transfer',
        'no_mutual_transfer',
        'pending_govt_dues',
        'times_mutual_transfer'
    ];
    public function user_credentials()
    {
        return $this->belongsTo(UserCredentialsModel::class, 'user_id');
    }
}
