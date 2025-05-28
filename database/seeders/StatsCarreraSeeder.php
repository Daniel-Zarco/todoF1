<?php

namespace Database\Seeders;

use App\Models\StatsCarrera;
use Illuminate\Database\Seeder;

class StatsCarreraSeeder extends Seeder
{
    public function run()
    {
        StatsCarrera::create([
            'piloto_id' => 1,
            'escuderia_id' => 1,
            'gran_premio_id' => 1,
            'posicion' => 2,
            'tiempo_total' => '1:33:12.345',
            'puntos' => 18,
            'vuelta_rapida' => false,
            'pole_position' => false,
        ]);

        StatsCarrera::create([
            'piloto_id' => 2,
            'escuderia_id' => 2,
            'gran_premio_id' => 1,
            'posicion' => 1,
            'tiempo_total' => '1:32:58.123',
            'puntos' => 25,
            'vuelta_rapida' => true,
            'pole_position' => true,
        ]);
    }
}

