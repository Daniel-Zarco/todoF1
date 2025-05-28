<?php

//06-05-2025//

namespace App\Http\Controllers;

use App\Models\Piloto;
use Illuminate\Http\Request;

class PilotoController extends Controller
{
    public function index(){
        return Piloto::with('escuderia_actual')->get(); // Asegúrate de tener la relación definida
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'escuderia' => 'required|string',
            'numero' => 'required|integer',
        ]);

        return Piloto::create($request->all());
    }

    public function show(Piloto $piloto)
    {
        return $piloto;
    }

    public function update(Request $request, Piloto $piloto)
    {
        $request->validate([
            'nombre' => 'string',
            'nacionalidad' => 'string',
            'fecha_nacimiento' => 'integer',
        ]);

        $piloto->update($request->all());
        return $piloto;
    }

    public function destroy(Piloto $piloto)
    {
        $piloto->delete();
        return response()->json(['mensaje' => 'Piloto eliminado']);
    }
}




