<?php

namespace App\Models\trash;

use App\Models\verification\AuthorityRejectionModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectedDocumentsModel extends Model
{
    use HasFactory;
    protected $table = 'rejected_documents';
    protected $fillable = [
        'user_id',
        'authority_id',
        'rejection_type',
        'old_update_on',
        'old_documents',
        'commnents'
    ];
    public function authority_rejections()
    {
        return $this->hasMany(AuthorityRejectionModel::class, 'rejected_document_id');
    }
}