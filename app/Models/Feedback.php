<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'feedbacks';


    public const TYPE_COMPLAINT = 1;   // şikayet
    public const TYPE_SUGGESTION = 2;  // öneri



    public const STATUS_PENDING = 0;
    public const STATUS_REVIEWING = 1;
    public const STATUS_RESOLVED = 2;
    public const STATUS_REJECTED = 3;


    protected $fillable = [
        'user_id',
        'type',
        'subject',
        'message',
        'status',
        'admin_response',
        'responded_by',
        'responded_at',
    ];

    protected $casts = [
        'type' => 'integer',
        'status' => 'integer',
        'responded_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }


    public function respondedBy()
    {
        return $this->belongsTo(User::class, 'responded_by','id');
    }


    public function images()
    {
        return $this->hasMany(FeedbackImage::class, 'feedback_id','id')->orderBy('position');
    }

    // ------------------------------------------------------------------
    // Yardımcı scope ve accessor'lar
    // ------------------------------------------------------------------

    public function scopeComplaints($query)
    {
        return $query->where('type', self::TYPE_COMPLAINT);
    }

    public function scopeSuggestions($query)
    {
        return $query->where('type', self::TYPE_SUGGESTION);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function getIsRespondedAttribute(): bool
    {
        return ! is_null($this->responded_at);
    }
}
