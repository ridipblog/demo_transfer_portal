<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepertPostsMapModel extends Model
{
    use HasFactory;
    protected $table='depts_posts_map';
    protected $fillable=[
        'dept_id',
        'post_id',
        'grade_pay'
    ];
    public function deptartments(){
        return $this->belongsTo(DepertmentModel::class,'dept_id');
    }
    public function post_names(){
        return $this->belongsTo(PostsNameModel::class,'post_id');
    }
}
