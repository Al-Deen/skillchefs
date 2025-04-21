<?php

namespace App\Listeners;

use App\Mail\MakePayoutMail;
use App\Events\MakePayoutEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MakePayoutListener
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
     * @param  \App\Events\MakePayoutEvent  $event
     * @return void
     */
    public function handle(MakePayoutEvent $event)
    {
        $email = $event->payout->user->email;
        Mail::to($email)
            ->send(new MakePayoutMail($event->payout));
    }
}
