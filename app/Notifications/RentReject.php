<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Rent;

class RentReject extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(Rent $rent)
    {
        $this->rent = $rent;
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
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
            return [
                'title' => 'Peminjaman Buku Ditolak',
                'message' => "Pengajuan Peminjaman Buku {$this->rent->book->book_title} oleh {$this->rent->user->name} ditolak",
                'type' => 'rent',
                'id' => $this->rent->id,
            ];
     
    }
}
