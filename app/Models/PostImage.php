<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'post_id',
        'image_url',
        'position',
    ];

    protected $casts = [
        'position' => 'integer',
    ];

    /**
     * Bu resmin ait olduğu post.
     */
    public function post(){
        return $this->belongsTo(Post::class,'post_id','id');
    }

}
