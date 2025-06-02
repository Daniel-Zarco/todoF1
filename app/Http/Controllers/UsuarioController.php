<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
 public function store(Request $request){
    $validated = $request->validate([
        'nombre_usuario' => 'required|string|max:255',
        'gmail' => 'required|email|max:255',
        'password' => 'required|string|min:4',
    ]);

    Usuario::create([
        'nombre_usuario' => $validated['nombre_usuario'],
        'gmail' => $validated['gmail'],
        'contraseña' => bcrypt($validated['password']),
    ]);

    return response()->json(['message' => 'Usuario registrado correctamente'], 200);
}




}

