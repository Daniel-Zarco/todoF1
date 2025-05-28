<?php

namespace App\Console\Commands;

use App\Services\F1ApiService;
use Illuminate\Console\Command;

class ImportarDatosF1 extends Command
{
    protected $signature = 'f1:importar';
    protected $description = 'Importar resultados F1 de los últimos 10 años';

    protected $f1Api;

    public function __construct(F1ApiService $f1Api)
    {
        parent::__construct();
        $this->f1Api = $f1Api;
    }

    public function handle()
    {
        // Importar datos de los últimos 10 años
        for ($año = now()->year; $año >= now()->year - 9; $año--) {
            $this->info("Importando datos de la temporada $año...");
            $datos = $this->f1Api->getCarrerasPorTemporada($año);

            // Recorrer cada carrera
            foreach ($datos['MRData']['RaceTable']['Races'] as $carrera) {
                // Guardar la escudería y piloto
                foreach ($carrera['Results'] as $resultado) {
                    // Guardar escudería
                    $escuderia = $this->f1Api->guardarEscuderia(
                        $resultado['Constructor']['name'],
                        $resultado['Constructor']['nationality']
                    );

                    // Guardar piloto
                    $piloto = $this->f1Api->guardarPiloto(
                        $resultado['Driver']['givenName'] . ' ' . $resultado['Driver']['familyName'],
                        $resultado['Driver']['nationality'],
                        null // Aquí podrías poner la fecha de nacimiento si la encuentras
                    );

                    // Guardar el gran premio
                    $granPremio = $this->f1Api->guardarGranPremio(
                        $carrera['raceName'],
                        $carrera['Circuit']['circuitName'],
                        $carrera['Circuit']['Location']['country'],
                        $carrera['date'],
                        $año
                    );

                    // Guardar los stats de la carrera
                    $this->f1Api->guardarStatsCarrera(
                        $piloto->id,
                        $escuderia->id,
                        $granPremio->id,
                        $resultado['position'],
                        $resultado['Time']['time'] ?? null, // Tiempo total (si está disponible)
                        $resultado['points'] ?? null, // Puntos (si está disponible),
                        $esVueltaRapida = isset($resultado['FastestLap']) && $resultado['FastestLap']['rank'] === '1',
                        $esPolePosition = isset($resultado['grid']) && $resultado['grid'] === '1'


                    );
                }
            }
        }

        $this->info('¡Importación completada!');
    }
}

