<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TopUpNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private string $message;
    private string $ids;
    public function __construct($message, $id)
    {
        $this->message = $message;
        $this->ids = $id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())->line('The introduction to the notification.')->action('Notification Action', url('/'))->line('Thank you for using our application!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'data' => $this->message,
            'url' => route('detail.topup', [
                'id' => $this->ids,
            ]),
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
                //
            ];
    }
}
