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

// Login
Route::post('/login', [AuthController::class, 'login']);

// Recuperar contraseña (correo)
Route::post('/recover-password', [AuthController::class, 'sendRecoverEmail']);

// Resetear contraseña con token
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Cambiar contraseña con la actual
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    // Recursos básicos de la app
    Route::get('/personas', function () {
        return DB::table('personas')->get();
    });

    Route::get('/departamentos', function () {
        return DB::table('departamentos')->get();
    });

    // CRUD de eventos y preguntas
    Route::apiResource('eventos', EventoController::class);
    Route::apiResource('preguntas', PreguntaController::class);

    // Respuestas
    Route::get('/respuestas-count', [RespuestaController::class, 'count']);
    Route::apiResource('respuestas', RespuestaController::class);

    // Asistencias
    Route::apiResource('asistencia', AsistenciaController::class)
        ->only(['index', 'store', 'show', 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | RUTAS SOLO PARA ADMIN
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