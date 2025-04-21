<?php

namespace App\Listeners;

use App\Mail\EmailVerification;
use App\Events\EmailSendEvent;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailSend;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailSendListener implements ShouldQueue
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
    public function handle(EmailSendEvent $event)
    {
        $email = $event->email;
        $subject = $event->subject;
        $template = $event->template;
        Mail::to($email)
        ->send(new EmailSend($event->data, $email, $subject, $template));
    }
}
