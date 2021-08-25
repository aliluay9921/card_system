<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;

class BalanceUpdate extends Notification implements ShouldQueue
{
    use Queueable;
    public $body;
    public $title;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $body)
    {
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [OneSignalChannel::class];
    }


    public function toOneSignal($notifiable)
    {
        return OneSignalMessage::create()
            ->subject($this->title)
            ->body($this->body);
    }

}
