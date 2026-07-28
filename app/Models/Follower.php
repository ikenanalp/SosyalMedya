<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Follower extends Model
{
    use HasFactory, softDeletes;

    protected $table = 'followers';

    protected $fillable = ['follower_id', 'following_id'];

    public function follower()
    {
        return $this->belongsTo(related: User::class, foreignKey: 'follower_id', ownerKey: 'id');
    }

    public function following()
    {
        return $this->belongsTo(related: User::class, foreignKey: 'following_id', ownerKey: 'id');
    }
}
