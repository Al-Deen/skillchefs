<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmailSendEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    public $subject;
    public $template;
    public $email;


    public function __construct($data, $email, $subject, $template)
    {
        $this->data = $data;
        $this->email = $email;
        $this->subject = $subject;
        $this->template = $template;
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
