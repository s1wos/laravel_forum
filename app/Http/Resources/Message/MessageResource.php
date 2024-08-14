<?php

namespace App\Http\Resources\Message;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'theme_id' => $this->theme_id,
            'is_liked' => $this->is_liked,
            'likes' => $this->liked_users_count,
            'is_not_solved_complaint' => $this->is_not_solved_complaint,
            'user' => UserResource::make($this->user)->resolve(),
            'time' => $this->created_at->format('d-m-Y')
        ];
    }
}
