<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pregunta;
use Illuminate\Http\Request;
use App\Events\NuevaPregunta;

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

    // Convertir a array para que el evento funcione
    $preguntaArray = $pregunta->toArray();

    // Disparar evento inmediatamente
    event(new NuevaPregunta($preguntaArray));

    return response()->json($pregunta, 201);
}


    public function show($id)
    {
        $pregunta = Pregunta::findOrFail($id);
        return response()->json($pregunta);
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
        return response()->json(['message' => 'Pregunta eliminada']);
    }
}
