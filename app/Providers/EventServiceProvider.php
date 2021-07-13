<?php

namespace App\Providers;

use App\Events\UserRegisteredEvent;
use App\Listeners\SendUserRegisteredConfirmationEmailListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserRegisteredEvent::class => [
            SendUserRegisteredConfirmationEmailListener::class,
        ],
    ];
}
