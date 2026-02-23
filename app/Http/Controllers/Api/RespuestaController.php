<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Respuesta;
use Illuminate\Http\Request;
use App\Events\NuevaNotificacion;

class RespuestaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('admin')->only('destroy');
    }

    public function index()
    {
        return response()->json(Respuesta::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pregunta' => 'required|integer|exists:preguntas,id',
            'id_asistente' => 'required|integer',
            'respuesta' => 'required|string'
        ]);

        $respuesta = Respuesta::create($validated);

        event(new NuevaNotificacion([
            'tipo' => 'respuesta',
            'actor' => $request->user()->id,
            'detalles' => 'Nueva respuesta registrada',
            'fecha' => now()->toDateTimeString()
        ]));

        return response()->json($respuesta, 201);
    }

    public function show($id)
    {
        return response()->json(Respuesta::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $respuesta = Respuesta::findOrFail($id);

        $validated = $request->validate([
            'respuesta' => 'required|string'
        ]);

        $respuesta->update($validated);

        event(new NuevaNotificacion([
            'tipo' => 'respuesta',
            'actor' => $request->user()->id,
            'detalles' => 'Respuesta actualizada',
            'fecha' => now()->toDateTimeString()
        ]));

        return response()->json($respuesta);
    }

    public function destroy(Request $request, $id)
    {
        Respuesta::findOrFail($id)->delete();

        event(new NuevaNotificacion([
            'tipo' => 'respuesta',
            'actor' => $request->user()->id,
            'detalles' => 'Respuesta eliminada',
            'fecha' => now()->toDateTimeString()
        ]));

        return response()->json([
            'message' => 'Respuesta eliminada'
        ]);
    }

    public function count(Request $request)
    {
        $request->validate([
            'id_pregunta' => 'required|integer|exists:preguntas,id'
        ]);

        $id_pregunta = $request->id_pregunta;

        return response()->json([
            'si' => Respuesta::where('id_pregunta', $id_pregunta)->where('respuesta', 'si')->count(),
            'no' => Respuesta::where('id_pregunta', $id_pregunta)->where('respuesta', 'no')->count(),
            'abstengo' => Respuesta::where('id_pregunta', $id_pregunta)->where('respuesta', 'abstengo')->count()
        ]);
    }
}