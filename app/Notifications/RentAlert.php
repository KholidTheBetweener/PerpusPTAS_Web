<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Rent;

class RentAlert extends Notification
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
            'title' => 'Waktu Peminjaman Hampir Habis',
            'message' => "Buku {$this->rent->book->book_title} dipinjam oleh {$this->rent->user->name} akan melewati batas waktu peminjaman pada {$this->rent->date_due}",
            'type' => 'rent',
            'id' => $this->rent->id,
        ];
    }
}
