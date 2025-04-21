<?php

namespace App\Listeners;


use App\Mail\EmailVerification;
use App\Events\ForgotPasswordEvent;
use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgotPasswordListener implements ShouldQueue
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
    public function handle(ForgotPasswordEvent $event)
    {
        $email = $event->user->email;
        Mail::to($email)
        ->send(new ForgotPassword($event->user));
    }
}
