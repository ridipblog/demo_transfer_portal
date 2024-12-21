<?php

namespace App\Models\trash;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectedDocumentsModel extends Model
{
    use HasFactory;
    protected $table = 'rejected_documents';
    protected $fillable = [
        'user_id',
        'old_update_on',
        'old_documents',
    ];
}
