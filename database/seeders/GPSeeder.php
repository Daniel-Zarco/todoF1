<?php

namespace Database\Seeders;

use App\Models\GP;
use Illuminate\Database\Seeder;

class GPSeeder extends Seeder
{
    public function run()
    {
        GP::create([
            'nombre' => 'GP de España',
            'circuito' => 'Circuit de Barcelona-Catalunya',
            'pais' => 'España',
            'fecha' => '2023-06-04',
            'temporada' => 2023,
        ]);
    }
}

