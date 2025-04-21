<?php

namespace App\Listeners;

use App\Mail\PayoutRejectMail;
use App\Events\PayoutRejectEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PayoutRejectListener
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
     * @param  \App\Events\PayoutRejectEvent  $event
     * @return void
     */
    public function handle(PayoutRejectEvent $event)
    {
        $email = $event->payout->user->email;
        Mail::to($email)
            ->send(new PayoutRejectMail($event->payout));
    }
}
