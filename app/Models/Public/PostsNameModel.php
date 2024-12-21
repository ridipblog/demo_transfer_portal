<?php

namespace App\Models\Public;

use App\Models\User\EmploymentDetailsModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostsNameModel extends Model
{
    use HasFactory;
    protected $table='post_names';
    protected $fillable=[
        'name',
        'type'
    ];
    public function depts_posts_map(){
        return $this->hasMany(DepertPostsMapModel::class,'post_id');
    }
    public function employment_details(){
        return $this->hasMany(EmploymentDetailsModel::class,'designation_id');
    }
}
