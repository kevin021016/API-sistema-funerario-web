<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // <-- IMPORTANTE: Agrega esta línea
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validar que vengan los datos
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Buscar al usuario por correo
        $user = User::where('email', $request->email)->first();

        // 3. Verificar si existe y si la contraseña coincide
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Las credenciales proporcionadas son incorrectas.'
            ], 401);
        }

        // --- LAS DOS LÍNEAS MÁGICAS PARA WEB.PHP ---
        // Esto le dice a Laravel: "Inicia sesión en el servidor y crea la Cookie"
        Auth::guard('web')->login($user);
        $request->session()->regenerate(); 
        // -------------------------------------------

        // 4. Actualizar última vez activo
        $user->update(['last_active_at' => now()]);

        // 5. Crear el Token de Sanctum
        $token = $user->createToken('token_funeraria')->plainTextToken;

        // 6. Responder con el token y datos básicos del usuario
        return response()->json([
            'status' => true,
            'message' => 'Sesión iniciada correctamente',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'nombre' => $user->name,
                'apellidos' => $user->apellidos,
                'role' => $user->rol,
                'telefono' => $user->telefono,
                'email' => $user->email
            ]
        ], 200);
    }

    public function logout(Request $request)
    {
        // 1. Revocar el token de la API
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }

        // 2. IMPORTANTE: Cerrar la sesión del servidor (PHP)
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'status' => true,
            'message' => 'Sesión cerrada exitosamente'
        ]);
    }
}