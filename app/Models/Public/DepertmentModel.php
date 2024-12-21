<?php

namespace App\Models\Public;

use App\Models\verification\appointing_authorities;
use App\Models\verification\office;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepertmentModel extends Model
{
    use HasFactory;
    protected $table='deptartments';
    protected $fillable=[
        'name'
    ];

    public function appointingAuthorities()
    {
        return $this->hasMany(appointing_authorities::class, 'department');
    }

    public function office()
    {
        return $this->hasMany(office::class, 'department_id');
    }
    public function depts_posts_map(){
        return $this->hasMany(DepertPostsMapModel::class,'dept_id');
    }
    public function offices_finassam(){
        return $this->hasMany(OfficeFinAsssamModel::class,'department_id');
    }
}
