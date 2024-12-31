<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportingDocumentsModel extends Model
{
    use HasFactory;
    protected $table = 'supporting_documents';
    protected $fillable = [
        'user_id',
        'document_title',
        'document_location'
    ];
}
