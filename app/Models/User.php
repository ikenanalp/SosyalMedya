<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    const ROLE_USER  = 0;
    const ROLE_ADMIN = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'is_banned',
        'ban_reason',
        'banned_by',
        'banned_at',
        'bio',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
        'banned_at'          => 'datetime',
        'is_banned'          => 'boolean',
    ];


    // Kullanıcının gönderileri
    public function posts()
    {
        return $this->hasMany(Post::class,'user_id','id');
    }

    // Kullanıcının yorumları
    public function comments()
    {
        return $this->hasMany(Comment::class,'user_id','id');
    }

    // Kullanıcının beğenileri
    public function likes()
    {
        return $this->hasMany(Like::class,'user_id','id');
    }

    // Bu kullanıcının takip ettiği kullanıcılar
    public function following()
    {
        return $this->belongsToMany(
            User::class,
            'followers',
            'follower_id',
            'following_id'
        )->withTimestamps();
    }

    // Bu kullanıcıyı takip eden kullanıcılar (takipçiler)
    public function followers()
    {
        return $this->belongsToMany(
            User::class,
            'followers',
            'following_id',
            'follower_id'
        )->withTimestamps();
    }

    // Claude Sistemi

    public function isAdmin(): bool
    {
        return $this->role == self::ROLE_ADMIN;
    }

    public function bannedBy()
    {
        return $this->belongsTo(User::class, 'banned_by');
    }

    public function avatars()
    {
        return $this->hasMany(UserAvatar::class, 'user_id', 'id')->orderBy('created_at', 'desc');
    }

}
