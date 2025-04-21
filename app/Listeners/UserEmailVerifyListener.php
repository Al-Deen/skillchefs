<?php

namespace App\Listeners;

use App\Mail\EmailVerification;
use App\Events\UserEmailVerifyEvent;
use Illuminate\Support\Facades\Mail;
use App\Mail\Student\SendVerification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserEmailVerifyListener implements ShouldQueue
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
    public function handle(UserEmailVerifyEvent $event)
    {
        $email = $event->user->email;
        Mail::to($email)
        ->send(new EmailVerification($event->user) );
    }
}
