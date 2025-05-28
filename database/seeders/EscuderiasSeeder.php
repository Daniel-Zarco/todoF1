<?php

namespace Database\Seeders;

use App\Models\Escuderia;
use Illuminate\Database\Seeder;

class EscuderiasSeeder extends Seeder
{
    public function run()
    {
        Escuderia::create([
            'nombre' => 'Mercedes',
            'pais' => 'Alemania',
            'año_fundacion' => 1954,
        ]);

        Escuderia::create([
            'nombre' => 'Red Bull Racing',
            'pais' => 'Austria',
            'año_fundacion' => 2005,
        ]);
    }
}

