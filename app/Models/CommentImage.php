<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommentImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'comment_images';

    protected $fillable = [
        'comment_id',
        'image_url',
        'position',
    ];

    protected $casts = [
        'position' => 'integer',
    ];


    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id', 'id');
    }
}
