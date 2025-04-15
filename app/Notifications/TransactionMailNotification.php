<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionMailNotification extends Notification
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
            ->subject('Pembelian Berhasil - Terima Kasih Telah Melakukan Transaksi')
            ->greeting('Halo!')
            ->line("Kami dengan senang hati menginformasikan bahwa top up Anda sebesar Rp {$this->amount} telah berhasil diproses.")
            ->line('Silakan klik tombol di bawah ini untuk melihat detail transaksi Anda.')
            ->action(
                'Lihat Detail Transaksi',
                route('detail.transaction', [
                    'id' => $this->ids,
                ])
            )
            ->line('Terima kasih telah menggunakan layanan kami. Kepuasan Anda adalah prioritas kami.')
            ->line('Jika Anda tidak merasa melakukan transaksi ini, mohon segera hubungi tim dukungan kami untuk penanganan lebih lanjut.')
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
