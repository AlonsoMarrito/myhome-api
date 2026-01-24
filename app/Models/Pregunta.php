<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    use HasFactory;

    protected $table = 'preguntas';

    protected $fillable = [
        'pregunta',
        'id_evento',
        'votos', // lo guardaremos como JSON
    ];

    public $timestamps = false;

    protected $casts = [
        'votos' => 'array', // Laravel lo convertirá automáticamente a array
    ];

    // Relación con Evento
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento');
    }
}
