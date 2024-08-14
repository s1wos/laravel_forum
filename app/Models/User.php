<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? url('storage/' . $this->avatar) : null;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id')
            ->where('is_read', false);
    }


    public static function getCleanedUserId($data)
    {
        return getId($data, '/@[\d]+/', '/@/')->filter(function ($id) {
            return User::where('id', $id)->exists();
        });
    }


    public function likedMessages()
    {
        return $this->belongsToMany(Message::class, 'message_user_likes', 'user_id', 'message_id');
    }

    public function complaintedMessages()
    {
        return $this->belongsToMany(Message::class, 'complaints', 'user_id', 'message_id');
    }

}
