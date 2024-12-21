<?php

namespace App\Models\User;

use App\Models\User_auth\UserCredentialsModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentModel extends Model
{
    use HasFactory;
    protected $table = 'documents';
    protected $fillable = [
        'user_id',
        'documet_location',
        'document_type',
    ];
    public function user_credentials()
    {
        return $this->belongsTo(UserCredentialsModel::class, 'user_id');
    }
}
