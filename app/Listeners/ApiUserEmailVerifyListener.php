<?php

namespace App\Listeners;


use App\Mail\ApiEmailVerification;
use Illuminate\Support\Facades\Mail;
use App\Events\ApiUserEmailVerifyEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApiUserEmailVerifyListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserEmailVerifyEvent  $event
     * @return void
     */
    public function handle(ApiUserEmailVerifyEvent $event)
    {

        $email = $event->user->email;

        Mail::to($email)
        ->send(new ApiEmailVerification($event->user));
    }
}
