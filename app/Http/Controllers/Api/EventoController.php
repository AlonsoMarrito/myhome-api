<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    // GET /api/eventos
    public function index()
    {
        return Evento::all();
    }

    // GET /api/eventos/{id}
    public function show($id)
    {
        return Evento::findOrFail($id);
    }

    // POST /api/eventos
    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'descripcion' => 'required|string',
        ]);

        return Evento::create($request->all());
    }

    // PUT /api/eventos/{id}
    public function update(Request $request, $id)
    {
        $evento = Evento::findOrFail($id);

        $request->validate([
            'fecha' => 'required|date',
            'descripcion' => 'required|string',
        ]);

        $evento->update($request->all());

        return $evento;
    }

    // DELETE /api/eventos/{id}
    public function destroy($id)
    {
        Evento::destroy($id);

        return response()->json([
            'message' => 'Evento eliminado correctamente'
        ]);
    }
}
