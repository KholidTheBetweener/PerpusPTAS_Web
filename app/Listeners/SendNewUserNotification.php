<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Models\Admin;
use Notification;
use App\Notifications\NewUserNotification;
use Illuminate\Auth\Events\Registered;


class SendNewUserNotification
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
    public function handle(Registered $event)
    {
        $admins = Admin::all();
        Notification::send($admins, new NewUserNotification($event->user));
    }
}
