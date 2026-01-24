<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'asistencia';

    protected $fillable = [
        'id_evento',
        'id_persona',
        'fecha'
    ];

    public $timestamps = false;
}
