<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asistencia;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public function index()
    {
        return Asistencia::all();
    }

    public function store(Request $request)
    {
        return Asistencia::create($request->validate([
            'id_evento' => 'required|integer',
            'id_persona' => 'required|integer',
            'fecha' => 'required|date'
        ]));
    }

    public function show($id)
    {
        return Asistencia::findOrFail($id);
    }

    public function destroy($id)
    {
        Asistencia::findOrFail($id)->delete();
        return response()->json(['message' => 'Asistencia eliminada']);
    }
}
