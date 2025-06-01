<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Registro
    public function registro(Request $request)
    {
        $request->validate([
            'nombre_usuario' => 'required|string|max:255|unique:usuarios,nombre_usuario',
            'gmail' => 'required|email|unique:usuarios,gmail',
            'password' => 'required|string|min:4|confirmed',
        ]);

        Usuario::create([
            'nombre_usuario' => $request->nombre_usuario,
            'gmail' => $request->gmail,
            'contraseña' => bcrypt($request->password),
        ]);

        return response()->json(['message' => 'Usuario registrado correctamente'], 201);
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'nombre_usuario' => 'required',
            'password' => 'required',
        ]);

        $usuario = Usuario::where('nombre_usuario', $request->nombre_usuario)->first();

        if (!$usuario || !Hash::check($request->password, $usuario->contraseña)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        Auth::login($usuario);
        return response()->json(['message' => 'Inicio de sesión exitoso'], 200);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(['message' => 'Sesión cerrada'], 200);
    }
}
