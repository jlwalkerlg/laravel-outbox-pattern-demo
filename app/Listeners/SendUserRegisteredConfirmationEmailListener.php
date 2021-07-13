<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use App\Mail\UserRegisteredConfirmationEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendUserRegisteredConfirmationEmailListener implements ShouldQueue
{
    public function handle(UserRegisteredEvent $event)
    {
        Log::info("Sending a confirmation email to new user {$event->user->name}.");

        // Mail::to($event->user->email)
        //     ->send(new UserRegisteredConfirmationEmail($event->user));
    }
}
