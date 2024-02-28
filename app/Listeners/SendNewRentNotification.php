<?php

namespace App\Listeners;

use App\Events\NewRentNotify;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Models\Admin;
use App\Notifications\NewRentNotification;
use Notification;

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
    public function handle(NewRentNotify $event): void
    {
        $admins = Admin::all();
        Notification::send($admins, new NewRentNotification($event->user));
    }
}
