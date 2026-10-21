<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Colonia;
use Illuminate\Http\Request;

class ColoniaController extends Controller
{
    public function index()
    {
        $colonia = Colonia::latest()->get();
        return response()->json($colonia);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo_postal' => 'required|string|max:10',     
        ]);

        $colonia = Colonia::create($request->all());

        return response()->json([
            'message' => 'Colonia creada con éxito',
            'colonia' => $colonia
        ], 201);
    }

    public function show($id)
    {
        $colonia = Colonia::find($id);

        if (!$colonia) {
            return response()->json(['message' => 'Colonia no encontrada'], 404);
        }

        return response()->json($colonia, 200);
    }

    public function update(Request $request, Colonia $colonia)
    {
        $colonia->update($request->all());

        return response()->json([
            'message' => 'Información actualizada',
            'colonia' => $colonia
        ]);
    }

    public function destroy(Colonia $colonia)
    {
        $colonia->delete();

        return response()->json([
            'message' => 'Colonia eliminada correctamente'
        ]);
    }
}