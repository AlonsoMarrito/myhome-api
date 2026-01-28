<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\EventoController;
use App\Http\Controllers\Api\PreguntaController;
use App\Http\Controllers\Api\RespuestaController;
use App\Http\Controllers\Api\AsistenciaController;
use App\Events\NuevaPregunta;

Route::get('/personas', function () {
    return DB::table('personas')->get();
});

Route::get('/departamentos', function () {
    return DB::table('departamentos')->get();
});

Route::apiResource('eventos', EventoController::class);
Route::apiResource('preguntas', PreguntaController::class);

Route::get('/respuestas-count', [RespuestaController::class, 'count']);

Route::apiResource('respuestas', RespuestaController::class);

// Rutas de asistencia
Route::apiResource('asistencia', AsistenciaController::class)
    ->only(['index', 'store', 'show', 'destroy']);

Route::get('/test/nueva-pregunta', function () {
    $pregunta = [
        'id' => rand(1, 999),
        'pregunta' => 'Pregunta de prueba ' . now()->format('H:i:s'),
        'id_evento' => 7,
    ];

    broadcast(new NuevaPregunta($pregunta));

    return response()->json([
        'message' => 'Evento NuevaPregunta disparado',
        'pregunta' => $pregunta
    ]);
});