<?php



use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PilotoController;

/*27/05/25 */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

Route::post('/login', function (Request $request) {
    $data = $request->json()->all();

    $usuario = Usuario::where('nombre_usuario', $data['usuario'])->first();

    if ($usuario && Hash::check($data['password'], $usuario->contraseña)) {
        Auth::login($usuario);
        return response()->json(['success' => true]);
    }

    return response()->json(['message' => 'Credenciales inválidas'], 401);
});



/*22/05/25*/
use App\Services\F1ApiService;

Route::get('/importar-pilotos', function (F1ApiService $api) {
    $datos = $api->getCarrerasPorTemporada(2023); // puedes cambiar el año
    $yaImportados = [];

    foreach ($datos['MRData']['RaceTable']['Races'] as $carrera) {
        foreach ($carrera['Results'] as $result) {
            $piloto = $result['Driver'];
            $id = $piloto['driverId'];

            if (!in_array($id, $yaImportados)) {
                $api->guardarPiloto(
                    $piloto['givenName'] . ' ' . $piloto['familyName'],
                    $piloto['nationality'],
                    $piloto['dateOfBirth'] ?? null
                );
                $yaImportados[] = $id;
            }
        }
    }

    return "Pilotos importados correctamente.";
});
/*22/05/25*/


Route::get('/', function () {
    return view('welcome');
});



//06-05-2025//

Route::get('/ver-pilotos', function () {
    return view('pilotos');
});


Route::get('/pilotos', [PilotoController::class, 'index']);



