<?php

namespace App\Models\verification;

use App\Models\trash\RejectedDocumentsModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorityRejectionModel extends Model
{
    use HasFactory;
    protected $table = 'authority_rejections';
    protected $fillable = [
        'rejected_document_id',
        'document_location',
        'document_type',
        'remarks',
    ];
    public function rejected_documents(){
        return $this->belongsTo(RejectedDocumentsModel::class,'rejected_document_id');
    }
}
