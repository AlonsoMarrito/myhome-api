<?php

namespace App\Events;

use App\Models\Pregunta;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class NuevaPregunta implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $pregunta;

    public function __construct(Pregunta $pregunta)
    {
        $this->pregunta = $pregunta;
    }

    // Nombre del canal
    public function broadcastOn()
    {
        return new Channel('eventos');
    }

    // Nombre del evento que recibe el cliente
    public function broadcastAs()
    {
        return 'NuevaPregunta';
    }
}
