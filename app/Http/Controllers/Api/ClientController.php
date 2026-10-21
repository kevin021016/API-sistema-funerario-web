<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // Listar todos los clientes
    public function index()
    {
        $clients = Client::latest()->get();
        return response()->json($clients);
    }

    // Guardar un nuevo cliente
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'calle' => 'required|string',
            'entre_calles' => 'nullable|string|max:255',
            'colonia' => 'required|string',
            'ciudad' => 'required|string',
            'codigo_postal' => 'required|string|max:10',
            'referencia_domicilio' => 'nullable|string',
            'celular' => 'nullable|string|max:20',
        ]);

        $client = Client::create($request->all());

        return response()->json([
            'message' => 'Cliente creado con éxito',
            'cliente' => $client
        ], 201);
    }

    // Mostrar un cliente específico
    public function show($id)
    {
        $client = Client::with(['contratos'])->find($id);


        if (!$client) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        return response()->json($client, 200);
    }


    // Actualizar datos del cliente
    public function update(Request $request, Client $client)
    {
        $client->update($request->all());

        return response()->json([
            'message' => 'Información actualizada',
            'cliente' => $client
        ]);
    }

    // Eliminar un cliente
    public function destroy(Client $client)
    {
        $client->delete();

        return response()->json([
            'message' => 'Cliente eliminado correctamente'
        ]);
    }
}