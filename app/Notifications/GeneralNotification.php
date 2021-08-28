<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GeneralNotification extends Notification
{
    use Queueable;

    protected $title,$message,$sourable_id,$sourable_type,$web_link,$deep_link;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title,$message,$sourable_id,$sourable_type,$web_link,$deep_link)
    {
        $this->title = $title;
        $this->message = $message;
        $this->sourable_id = $sourable_id;
        $this->sourable_type = $sourable_type;
        $this->web_link = $web_link;
        $this->deep_link = $deep_link;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'sourable_id' => $this->sourable_id,
            'sourable_type' => $this->sourable_type,
            'web_link' => $this->web_link,
            'deep_link' => $this->deep_link,
        ];
    }
}
