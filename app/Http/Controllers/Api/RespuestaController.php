<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Respuesta;
use Illuminate\Http\Request;
use App\Events\NuevaNotificacion;

class RespuestaController extends Controller
{
    public function index()
    {
        return Respuesta::all();
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
            'actor' => 'usuario',
            'detalles' => 'Nueva respuesta registrada',
            'fecha' => now()->format('Y-m-d H:i:s')
        ]));

        return response()->json($respuesta, 201);
    }

    public function show($id)
    {
        return Respuesta::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $respuesta = Respuesta::findOrFail($id);

        $respuesta->update($request->validate([
            'respuesta' => 'required|string'
        ]));

        event(new NuevaNotificacion([
            'tipo' => 'respuesta',
            'actor' => 'usuario',
            'detalles' => 'Respuesta actualizada',
            'fecha' => now()->format('Y-m-d H:i:s')
        ]));

        return $respuesta;
    }

    public function destroy($id)
    {
        Respuesta::findOrFail($id)->delete();

        event(new NuevaNotificacion([
            'tipo' => 'respuesta',
            'actor' => 'usuario',
            'detalles' => 'Respuesta eliminada',
            'fecha' => now()->format('Y-m-d H:i:s')
        ]));

        return response()->json(['message' => 'Respuesta eliminada']);
    }

    public function count(Request $request)
    {
        $id_pregunta = $request->query('id_pregunta');

        $si = Respuesta::where('id_pregunta', $id_pregunta)->where('respuesta', 'si')->count();
        $no = Respuesta::where('id_pregunta', $id_pregunta)->where('respuesta', 'no')->count();
        $abstengo = Respuesta::where('id_pregunta', $id_pregunta)->where('respuesta', 'abstengo')->count();

        return response()->json([
            'si' => $si,
            'no' => $no,
            'abstengo' => $abstengo
        ]);
    }
}
