<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\Http\Request;
use App\Events\NuevaNotificacion;

class EventoController extends Controller
{
    public function index()
    {
        return Evento::all();
    }

    public function show($id)
    {
        return Evento::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'descripcion' => 'required|string',
        ]);

        $evento = Evento::create($validated);

        event(new NuevaNotificacion([
            'tipo' => 'evento',
            'actor' => 'usuario',
            'detalles' => $evento->descripcion,
            'fecha' => now()->format('Y-m-d H:i:s')
        ]));

        return response()->json($evento, 201);
    }

    public function update(Request $request, $id)
    {
        $evento = Evento::findOrFail($id);

        $validated = $request->validate([
            'fecha' => 'required|date',
            'descripcion' => 'required|string',
        ]);

        $evento->update($validated);

        event(new NuevaNotificacion([
            'tipo' => 'evento',
            'actor' => 'usuario',
            'detalles' => 'Evento actualizado',
            'fecha' => now()->format('Y-m-d H:i:s')
        ]));

        return $evento;
    }

    public function destroy($id)
    {
        Evento::findOrFail($id)->delete();

        event(new NuevaNotificacion([
            'tipo' => 'evento',
            'actor' => 'usuario',
            'detalles' => 'Evento eliminado',
            'fecha' => now()->format('Y-m-d H:i:s')
        ]));

        return response()->json([
            'message' => 'Evento eliminado correctamente'
        ]);
    }
}
