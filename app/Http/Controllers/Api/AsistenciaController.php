<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use App\Events\NuevaNotificacion;

class AsistenciaController extends Controller
{
    public function index()
    {
        return Asistencia::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_evento' => 'required|integer|exists:eventos,id',
            'id_persona' => 'required|integer',
            'fecha' => 'required|date'
        ]);

        $asistencia = Asistencia::create($validated);

        event(new NuevaNotificacion([
            'tipo' => 'asistencia',
            'actor' => 'usuario',
            'detalles' => 'Nueva asistencia registrada',
            'fecha' => now()->format('Y-m-d H:i:s')
        ]));

        return response()->json($asistencia, 201);
    }

    public function show($id)
    {
        return Asistencia::findOrFail($id);
    }

    public function destroy($id)
    {
        Asistencia::findOrFail($id)->delete();

        event(new NuevaNotificacion([
            'tipo' => 'asistencia',
            'actor' => 'usuario',
            'detalles' => 'Asistencia eliminada',
            'fecha' => now()->format('Y-m-d H:i:s')
        ]));

        return response()->json(['message' => 'Asistencia eliminada']);
    }
}
