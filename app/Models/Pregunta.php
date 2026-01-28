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
    ];

    public $timestamps = false;

    // Relación con Evento
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento');
    }
}
