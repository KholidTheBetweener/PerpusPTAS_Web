<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Models\Admin;
use App\Notifications\NewRentNotification;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Events\Registered;

class SendNewRentNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Event $event): void
    {
        $admins = Admin::all();
        Notification::send($admins, new NewRentNotification($event->user));
    }
}
