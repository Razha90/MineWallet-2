<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransferMailNotification extends Notification
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

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'data' => $this->message,
            'url' => route('detail.transfer', [
                'id' => $this->ids,
            ]),
        ];
    }
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Transfer Berhasil - Terima Kasih Telah Melakukan Transaksi')
            ->greeting('Hai,')
            ->line("Kami ingin menginformasikan bahwa proses transfer Anda sebesar Rp {$this->amount} telah berhasil.")
            ->line('Terima kasih telah mempercayakan transaksi Anda kepada kami.')
            ->action(
                'Lihat Detail Transaksi',
                route('detail.transfer', [
                    'id' => $this->ids,
                ]),
            )
            ->line('Jika Anda tidak merasa melakukan transaksi ini, segera hubungi tim support kami.')
            ->salutation('Salam hangat, Tim Kami');
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
