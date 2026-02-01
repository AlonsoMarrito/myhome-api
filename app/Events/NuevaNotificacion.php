<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class NuevaNotificacion implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('notificaciones');
    }

    public function broadcastAs(): string
    {
        return 'NuevaNotificacion';
    }

    public function broadcastWith(): array
    {
        return $this->data;
    }
}
