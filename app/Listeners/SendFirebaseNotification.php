<?php

namespace App\Listeners;

use App\Events\FirebaseNotification;
use App\Traits\FCMNotification;

class SendFirebaseNotification
{
    use FCMNotification;

    protected $users;
    protected $title;
    protected $body;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct($users, $title, $body)
    {
        $this->users = $users;
        $this->title = $title;
        $this->body = $body;

    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\FirebaseNotification  $event
     * @return void
     */
    public function handle(FirebaseNotification $event)
    {
        foreach ($this->users as $user) {
            $this->sendFirebaseNotification($user->user_id, 'notice', '', 'notice', $this->title, $this->body);
        }
    }
}
