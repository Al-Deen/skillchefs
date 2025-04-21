<?php

namespace App\Listeners;

use App\Mail\AdminEmailVerification;
use Illuminate\Support\Facades\Mail;
use App\Events\AdminEmailVerificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminEmailVerificationListener implements ShouldQueue
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
     * @param  \App\Events\AdminEmailVerification  $event
     * @return void
     */
    public function handle(AdminEmailVerificationEvent $event)
    {
        $email = $event->user->email;
        Mail::to($email)
            ->send(new AdminEmailVerification($event->user));
    }
}
