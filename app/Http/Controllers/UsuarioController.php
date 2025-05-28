<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'usuario' => 'required|string|max:255',
        'password' => 'required|string|min:4',
    ]);

    Usuario::create([
        'nombre_usuario' => $request->input('usuario'),
        'contraseña' => bcrypt($request->input('password')),
        'gmail' => $request->input('usuario') . '@gmail.com',
    ]);

    return redirect('/TodoF1/todoF1/PagePrincipal.html');
}


}

