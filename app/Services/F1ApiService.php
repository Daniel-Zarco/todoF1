<?php

namespace App\Services;

use App\Models\Escuderia;
use App\Models\Piloto;
use App\Models\GP;
use App\Models\StatsCarrera;
use Illuminate\Support\Facades\Http;

class F1ApiService
{
    // Función para obtener las carreras de un año
    public function getCarrerasPorTemporada($año){
        $url = "https://ergast.com/api/f1/{$año}/results.json?limit=1000";
        $response = Http::get($url);
        return $response->json();
    }

    // Función para guardar las escuderías en la base de datos
    public function guardarEscuderia($nombre, $pais, $año_fundacion = null){
        return Escuderia::firstOrCreate(
            ['nombre' => $nombre], // Si ya existe por nombre, no lo crea
            ['pais' => $pais, 'año_fundacion' => $año_fundacion]
        );
    }

    // Función para guardar los pilotos
    public function guardarPiloto($nombre, $nacionalidad, $fecha_nacimiento = null){
        return Piloto::firstOrCreate(
            ['nombre' => $nombre], // Si ya existe, no lo crea
            ['nacionalidad' => $nacionalidad, 'fecha_nacimiento' => $fecha_nacimiento]
        );
    }

    // Función para guardar los grandes premios
    public function guardarGranPremio($nombre, $circuito, $pais, $fecha, $temporada){
        return GP::firstOrCreate(
            ['nombre' => $nombre, 'temporada' => $temporada], // Si existe por nombre y temporada, no lo crea
            ['circuito' => $circuito, 'pais' => $pais, 'fecha' => $fecha]
        );
    }

    // Función para guardar los resultados de la carrera
    public function guardarStatsCarrera($piloto_id, $escuderia_id, $gran_premio_id, $posicion, $tiempo_total, $puntos, $vuelta_rapida, $pole_position){
        StatsCarrera::firstOrCreate(
            [
                'piloto_id' => $piloto_id,
                'escuderia_id' => $escuderia_id,
                'gran_premio_id' => $gran_premio_id
            ],
            [
                'posicion' => $posicion,
                'tiempo_total' => $tiempo_total,
                'puntos' => $puntos,
                'vuelta_rapida' => $vuelta_rapida,
                'pole_position' => $pole_position
            ]
        );
    }
}

