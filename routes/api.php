<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\EventoController;
use App\Http\Controllers\Api\PreguntaController;
use App\Http\Controllers\Api\RespuestaController;
use App\Http\Controllers\Api\AsistenciaController;
use App\Http\Controllers\Api\AuthController;
use App\Events\NuevaPregunta;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

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

    Route::apiResource('asistencia', AsistenciaController::class)
        ->only(['index', 'store', 'show', 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | SOLO ADMIN
    |--------------------------------------------------------------------------
    */

    Route::middleware('admin')->group(function () {
        Route::delete('/eventos/{evento}', [EventoController::class, 'destroy']);
    });

    /*
    |--------------------------------------------------------------------------
    | TEST EVENTO
    |--------------------------------------------------------------------------
    */

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

});