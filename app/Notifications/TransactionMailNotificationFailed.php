<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionMailNotificationFailed extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private string $message;
    private string $ids;
    private string $amount;
    public function __construct($message, $id, $amount)
    {
        $this->message = $message;
        $this->ids = $id;
        $this->amount = $amount;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'data' => $this->message,
            'url' => route('detail.transaction', [
                'id' => $this->ids,
            ]),
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Top Up Gagal - Mohon Coba Kembali')
            ->greeting('Halo!')
            ->line("Kami ingin menginformasikan bahwa proses top up Anda sebesar Rp {$this->amount} tidak berhasil diselesaikan.")
            ->line('Silakan klik tombol di bawah ini untuk melihat detail transaksi Anda atau mencoba kembali.')
            ->action(
                'Lihat Detail Transaksi',
                route('detail.transaction', [
                    'id' => $this->ids,
                ])
            )
            ->line('Kami mohon maaf atas ketidaknyamanan ini. Anda bisa mencoba kembali beberapa saat lagi atau hubungi tim dukungan kami untuk bantuan lebih lanjut.')
            ->salutation('Hormat kami, Tim Kami');
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
