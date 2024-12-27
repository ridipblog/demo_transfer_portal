<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectorateModel extends Model
{
    use HasFactory;
    protected $table='directorate';
    protected $fillable=[
        'name',
        'depertment_id'
    ];
    public function deptartments(){
        return $this->belongsTo(DepertmentModel::class,'depertment_id');
    }
}
