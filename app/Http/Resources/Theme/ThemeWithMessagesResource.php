<?php

namespace App\Http\Resources\Theme;

use App\Http\Resources\Message\MessageResource;
use App\Models\Complaint;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThemeWithMessagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $msgIds = auth()->user()->likedMessages()->get()->pluck('id');

        $this->messages->each(function ($message) use ($msgIds) {
            $message->is_liked = $msgIds->contains($message->id);
        });

        $complaintedMsgs = auth()->user()->complaintedMessages()->get()->pluck('id');

        $this->messages->each(function ($message) use ($complaintedMsgs) {
            $message->is_not_solved_complaint = $complaintedMsgs->contains($message->id);
        });

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'branch_id' => $this->branch_id,
            'messages' => MessageResource::collection($this->messages->load('user'))->resolve(),
        ];
    }
}
