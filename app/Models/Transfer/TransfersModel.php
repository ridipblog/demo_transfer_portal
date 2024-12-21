<?php

namespace App\Models\Transfer;

use App\Models\User_auth\UserCredentialsModel;
use App\Models\verification\appointing_authorities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransfersModel extends Model
{
    use HasFactory;
    protected $table = 'transafers';
    protected $fillable = [
        'employee_id',
        'target_employee_id',
        'request_status',
        'request_status_by_target_emp',
        'remarks',
        'transfer_ref_code',
        'final_approval',
        'approver_remarks',
        'approved_by',
        'jto_generate_status',
        'approved_on',
        '2nd_recommend',
        '2nd_recommend_remarks',
        '2nd_recommended_by',
        '2nd_recommended_on'
    ];
    public function transfer_employee_user()
    {
        return $this->belongsTo(UserCredentialsModel::class, 'employee_id');
    }
    public function transfer_employee_target_user()
    {
        return $this->belongsTo(UserCredentialsModel::class, 'target_employee_id');
    }
    public function appointing_authorities()
    {
        return $this->belongsTo(appointing_authorities::class, 'approved_by');
    }
}