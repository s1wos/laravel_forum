<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = false;

    protected $withCount = ['likedUsers'];


//    public function getIsLikedAttribute()
//    {
//        return $this->likedUsers()->where('user_id', auth()->id())->exists();
//    }
//
//    public function getIsNotSolvedComplaintAttribute()
//    {
//        return $this->complaintedUsers()
//            ->where('user_id', auth()->id())
//            ->where('is_solved', false)
//            ->exists();
//    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function likedUsers()
    {
        return $this->belongsToMany(User::class, 'message_user_likes', 'message_id', 'user_id');
    }

    public function answeredUsers()
    {
        return $this->belongsToMany(User::class, 'message_user_answers', 'message_id', 'user_id');
    }

    public function complaintedUsers()
    {
        return $this->belongsToMany(User::class, 'complaints', 'message_id', 'user_id');
    }
}
