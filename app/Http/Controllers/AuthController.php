<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Registrar un nuevo usuario.
     */
    public function registro(Request $request)
{
    // Validar
    $validatedData = $request->validate([
        'nombre_usuario' => 'required|string|max:255|unique:usuarios,nombre_usuario',
        'gmail' => 'required|email|unique:usuarios,gmail',
        'password' => 'required|string|min:4',
    ]);

    // Crear el usuario
    Usuario::create([
        'nombre_usuario' => $validatedData['nombre_usuario'],
        'gmail' => $validatedData['gmail'],
        'contraseña' => bcrypt($validatedData['password']),
    ]);

    // Devolver respuesta JSON de éxito
    return response()->json(['message' => '¡Usuario registrado con éxito!'], 201);
}

}
