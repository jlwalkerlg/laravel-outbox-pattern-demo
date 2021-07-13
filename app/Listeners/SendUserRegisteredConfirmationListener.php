<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendUserRegisteredConfirmationListener implements ShouldQueue
{
    public function handle(UserRegisteredEvent $event)
    {
        Log::info("Sending user registered confirmation email to {$event->user->name}.");
    }
}
