<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private string $message;
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail', 'broadcast'];
    }

    // public function toDatabase(object $notifiable): array
    // {
    //     return [
    //         'data' => 'This is a test notification',
    //         'url' => url('/'),
    //     ];
    // }

    // /**
    //  * Get the mail representation of the notification.
    //  */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage())->line('The introduction to the notification.')->action('Notification Action', url('/'))->line('Thank you for using our application!');
    // }

    public function toDatabase(object $notifiable): array
    {
        return [
            'data' => 'This is a test notification',
            'url' => url('/'),
        ];
    }

    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //         ->line('Selamat penguna baru MineWallet.')
    //         ->action('Click', url('/'))
    //         ->line('Thank you for using our application!');
    // }
    public function toMail(object $notifiable): MailMessage
{
    return (new MailMessage)
        ->subject('Selamat Datang di MineWallet! Dompet Digital Terbaikmu Sudah Hadir!')
        ->greeting('Hai ' . $notifiable->name . '!')
        ->line('Selamat datang di MineWallet! Kami sangat senang kamu bergabung dengan komunitas kami.')
        ->line('Siap untuk pengalaman bertransaksi yang lebih mudah, aman, dan penuh kejutan?')
        ->action('Jelajahi MineWallet Sekarang!', url('/'))
        ->line('Terima kasih telah memilih MineWallet sebagai dompet digital andalanmu. Mari mulai petualangan finansialmu bersama kami!');
}

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'message' => $this->message,
            'url' => url('/'),
        ]);
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
