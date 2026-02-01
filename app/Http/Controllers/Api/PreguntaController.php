<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pregunta;
use Illuminate\Http\Request;
use App\Events\NuevaPregunta;
use App\Events\NuevaNotificacion;

class PreguntaController extends Controller
{
    public function index(Request $request)
    {
        $eventoId = $request->query('id_evento');

        if ($eventoId) {
            return Pregunta::where('id_evento', $eventoId)->get();
        }

        return Pregunta::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pregunta' => 'required|string',
            'id_evento' => 'required|integer|exists:eventos,id',
        ]);

        $pregunta = Pregunta::create($validated);

        event(new NuevaPregunta($pregunta->toArray()));

        event(new NuevaNotificacion([
            'tipo' => 'pregunta',
            'actor' => 'usuario',
            'detalles' => $pregunta->pregunta,
            'fecha' => now()->toDateTimeString(),
        ]));

        return response()->json($pregunta, 201);
    }

    public function show($id)
    {
        return Pregunta::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $pregunta = Pregunta::findOrFail($id);

        $validated = $request->validate([
            'pregunta' => 'sometimes|required|string',
        ]);

        $pregunta->update($validated);

        return response()->json($pregunta);
    }

    public function destroy($id)
    {
        Pregunta::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Pregunta eliminada'
        ]);
    }
}
