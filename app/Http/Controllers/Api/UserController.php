<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Muestra la lista de todos los usuarios.
     */
    public function index()
    {
        // Traemos todos los usuarios de la BD
        // Puedes usar User::orderBy('id', 'desc')->get() para ver los nuevos primero
        $users = User::all();

        // Retornamos JSON con código 200 (Éxito)
        return response()->json($users, 200);
    }

    /**
     * Agrega a un usuario a la bd.
     */
    public function store(Request $request)
    {
        // 1. Validamos los datos de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'apellidos' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'rol' => 'required|string',
            'telefono' => 'nullable|string|max:20',
            'password' => 'required|string|min:8'
        ]);

        // 2. Creamos la instancia y asignamos valores
        $user = new User();
        $user->name = $request->name;
        $user->apellidos = $request->apellidos;
        $user->email = $request->email;
        $user->rol = $request->rol;
        $user->telefono = $request->telefono;
        $user->password = bcrypt($request->password); // Ciframos siempre

        $user->save();

        // 3. Respuesta de éxito
        return response()->json([
            'message' => 'Usuario creado exitosamente',
            'user' => $user
        ], 201); // 201 significa "Created"
    }

    /**
     * Muestra un usuario específico por ID.
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json($user, 200);
    }

    /**
     * Actualiza un usuario en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // Validamos los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'apellidos' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'rol' => 'required|string',
            'telefono' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8'
        ]);

        // Actualizamos los campos
        $user->name = $request->name;
        $user->apellidos = $request->apellidos; // Asegúrate que exista en tu Migración
        $user->email = $request->email;
        $user->rol = $request->rol;
        $user->telefono = $request->telefono;
        // Si el request trae password, la actualizamos cifrándola
        if ($request->has('password') && $request->password != null) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return response()->json([
            'message' => 'Usuario actualizado correctamente',
            'user' => $user
        ], 200);
    }

    /**
     * Elimina un usuario específico.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
    }
}