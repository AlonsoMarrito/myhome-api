<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class NuevaPregunta implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $pregunta;

    public function __construct(array $pregunta)
    {
        $this->pregunta = $pregunta;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('eventos');
    }

    public function broadcastAs(): string
    {
        return 'NuevaPregunta';
    }

    public function broadcastWith(): array
    {
        return $this->pregunta;
    }
}
