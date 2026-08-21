<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAvatar extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_avatars';

    protected $fillable = [
        'user_id',
        'image_url',
        'position',
    ];

    protected $casts = [
        'position' => 'integer',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
