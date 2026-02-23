<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\Http\Request;
use App\Events\NuevaNotificacion;

class EventoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');

        // Solo admin puede modificar datos
        $this->middleware('admin')->only(['store', 'update', 'destroy']);
    }

    public function index()
    {
        return response()->json(Evento::all());
    }

    public function show($id)
    {
        return response()->json(Evento::findOrFail($id));
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
            'actor' => $request->user()->id,
            'detalles' => $evento->descripcion,
            'fecha' => now()->toDateTimeString()
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
            'actor' => $request->user()->id,
            'detalles' => 'Evento actualizado',
            'fecha' => now()->toDateTimeString()
        ]));

        return response()->json($evento);
    }

    public function destroy(Request $request, $id)
    {
        Evento::findOrFail($id)->delete();

        event(new NuevaNotificacion([
            'tipo' => 'evento',
            'actor' => $request->user()->id,
            'detalles' => 'Evento eliminado',
            'fecha' => now()->toDateTimeString()
        ]));

        return response()->json([
            'message' => 'Evento eliminado correctamente'
        ]);
    }
}