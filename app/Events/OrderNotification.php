<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $event;
    public $channel;
    public function __construct($channel, $event, $message)
    {
        $this->message = $message;
        $this->event = $event;
        $this->channel = $channel;
    }

    public function broadcastOn()
    {
        return new Channel($this->channel);
    }

    public function broadcastAs()
    {
        return $this->event;
    }
}
