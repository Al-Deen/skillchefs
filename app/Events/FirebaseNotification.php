<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FirebaseNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $users;
    protected $title;
    protected $body;

    /**
     * Create a new event instance.
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
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
