<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory,softDeletes;

    protected $table = 'posts';

    public function likes(){
        return $this->hasMany(Like::class,'post_id','id');
    }

    public function comments(){
        return $this->hasMany(Comment::class,'post_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

}

