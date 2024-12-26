<?php

namespace App\Models\verification;

use App\Models\User_auth\UserCredentialsModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationRemarksDocumentModel extends Model
{
    use HasFactory;
    protected $table = 'verification_remarks_documents';
    protected $fillable = [
        'user_id',
        'document_location',
        'remarks',
        'document_type',
        'remarks_by',
        'authority_type',
        'status'
    ];
    public function user_credentials()
    {
        return $this->belongsTo(UserCredentialsModel::class, 'user_id');
    }
    public function appointing_authorities()
    {
        return $this->belongsTo(appointing_authorities::class, 'appointing_authorities');
    }
}
