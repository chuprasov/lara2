<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Notifications\NewUserNotification;

class SendEmailNewUserListener
{
    public function handle(Registered $event): void
    {
        $event->user->notify(new NewUserNotification());
    }
}
