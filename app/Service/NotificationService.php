<?php


namespace App\Service;


use App\Events\StoreNotificationEvent;
use App\Models\Notification;

class NotificationService
{
    public static function store($message, $id = null, $title)
    {
        $id = $id ? $id : $message->user_id;
        $notification = Notification::create([
            'title' => $title,
            'user_id' => $id,
            'url' => route('themes.show', $message->theme_id) . '#' . $message->id
        ]);
        event(new StoreNotificationEvent($notification));
    }
}
