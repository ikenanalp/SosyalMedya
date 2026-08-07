<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeedbackImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'feedback_images';

    protected $fillable = [
        'feedback_id',
        'image_url',
        'position',
    ];

    protected $casts = [
        'position' => 'integer',
    ];


    public function feedback()
    {
        return $this->belongsTo(Feedback::class, 'feedback_id','id');
    }
}
