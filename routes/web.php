<?php



use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PilotoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

/*28/05/25*/

Route::post('/registro', function (Request $request) {
    $data = $request->json()->all();

    // Validar campos mínimos
    if (!$data['nombre_usuario'] || !$data['gmail'] || !$data['password']) {
        return response()->json(['message' => 'Datos incompletos.'], 422);
    }

    // Comprobar si ya existe ese usuario o correo
    if (Usuario::where('nombre_usuario', $data['nombre_usuario'])->exists()) {
        return response()->json(['message' => 'Nombre de usuario ya registrado.'], 409);
    }

    if (Usuario::where('gmail', $data['gmail'])->exists()) {
        return response()->json(['message' => 'Correo ya registrado.'], 409);
    }

    // Crear usuario
    Usuario::create([
        'nombre_usuario' => $data['nombre_usuario'],
        'gmail' => $data['gmail'],
        'contraseña' => Hash::make($data['password']),
    ]);

    return response()->json(['success' => true], 201);
});



/*27/05/25 */

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



