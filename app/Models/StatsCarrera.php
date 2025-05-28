<?php

//18/05/25
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatsCarrera extends Model
{
    use HasFactory;

    protected $table = 'z_stats_carrera';

    protected $fillable = [
        'piloto_id',
        'escuderia_id',
        'gran_premio_id',
        'posicion',
        'tiempo_total',
        'puntos',
        'vuelta_rapida',
        'pole_position',
    ];

    public function piloto()
    {
        return $this->belongsTo(Piloto::class, 'piloto_id');
    }

    public function escuderia()
    {
        return $this->belongsTo(Escuderia::class, 'escuderia_id');
    }

    public function granPremio()
    {
        return $this->belongsTo(GP::class, 'gran_premio_id');
    }
}


/*
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatsCarrera extends Model
{
    use HasFactory;

    protected $table = 'z_stats_carrera';

    public function piloto()
    {
        return $this->belongsTo(Piloto::class);
    }

    public function escuderia()
    {
        return $this->belongsTo(Escuderia::class);
    }

    public function gp()
    {
        return $this->belongsTo(GP::class, 'gran_premio_id');
    }

    protected $fillable = [
        'piloto_id', 'escuderia_id', 'gran_premio_id', 'posicion', 
        'tiempo_total', 'puntos', 'vuelta_rapida', 'pole_position'
    ];
}
*/
