<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\EventoController;
use App\Http\Controllers\Api\PreguntaController;
use App\Http\Controllers\Api\RespuestaController;
use App\Http\Controllers\Api\AsistenciaController;

Route::get('/personas', function () {
    return DB::table('personas')->get();
});

Route::get('/departamentos', function () {
    return DB::table('departamentos')->get();
});

// Eventos y preguntas
Route::apiResource('eventos', EventoController::class);
Route::apiResource('preguntas', PreguntaController::class);

// Ruta especial para contar votos por pregunta
Route::get('/respuestas-count', [RespuestaController::class, 'count']);

// Rutas estándar de respuestas
Route::apiResource('respuestas', RespuestaController::class);

// Rutas de asistencia
Route::apiResource('asistencia', AsistenciaController::class)
    ->only(['index', 'store', 'show', 'destroy']);
