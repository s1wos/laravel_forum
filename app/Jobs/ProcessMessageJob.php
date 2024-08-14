<?php

namespace App\Jobs;

use App\Events\StoreMessageEvent;
use App\Models\Image;
use App\Models\User;
use App\Service\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $message;
    private $data;

    /**
     * Create a new job instance.
     */
    public function __construct($message, $data)
    {
        //
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $ids =  User::getCleanedUserId($this->data);

        $imgIds = getId($this->data, '/img_id=[\d]+/', '/img_id=/');

        broadcast(new StoreMessageEvent($this->message))->toOthers();

        Image::UpdateMessageId($imgIds, $this->message);

        Image::cleanFromStorage();

        Image::cleanFromTable();

        $this->message->answeredUsers()->attach($ids);

        $ids->each(function ($id) {
            NotificationService::store($this->message, $id, 'Вам ответили');
        });

    }
}
