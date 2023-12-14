<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The message associated with event.
     * @var string
     */
    protected $message;

    /**
     * Create a new event instance.
     */
    public function __construct($message)
    {
        // Assign the provided message to the event's message property.
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return Channel('chat');
        /*[
            new PrivateChannel('channel-name'),
        ];*/
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array, \Illuminate\Broadcasting>
     */
    public function broadcastWith()
{
    return ['message' => $this->message];
}
}
