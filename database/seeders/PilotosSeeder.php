<?php

namespace Database\Seeders;

use App\Models\Piloto;
use Illuminate\Database\Seeder;

class PilotosSeeder extends Seeder
{
    public function run()
    {
        Piloto::create([
            'nombre' => 'Lewis Hamilton',
            'nacionalidad' => 'Británica',
            'fecha_nacimiento' => '1985-01-07',
        ]);

        Piloto::create([
            'nombre' => 'Max Verstappen',
            'nacionalidad' => 'Neerlandesa',
            'fecha_nacimiento' => '1997-09-30',
        ]);
    }
}

