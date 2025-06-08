<?php
// Datos de conexión a la base de datos (ajusta según tu configuración)
$servername = "localhost";  
$username = "root";         
$password = "";            
$dbname = "todof1"; 

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Revisar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Listas de valores posibles
$generos = ['hombre', 'mujer', 'otro'];
$paises = ["Argentina","Bolivia","Chile","Colombia","Costa Rica","Cuba","Ecuador","El Salvador","España","Guatemala","Honduras","México","Nicaragua","Panamá","Paraguay","Perú","Puerto Rico","República Dominicana","Uruguay","Venezuela"];

// Función para generar edad aleatoria (entre 18 y 80, por ejemplo)
function edadRandom() {
    return rand(18, 80);
}

// Insertar 100 usuarios aleatorios
for ($i = 0; $i < 100; $i++) {
    $genero = $generos[array_rand($generos)];
    $pais = $paises[array_rand($paises)];
    $edad = edadRandom();

    // Preparar la consulta
    $sql = "INSERT INTO info (gender, country, age) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $genero, $pais, $edad);

    if (!$stmt->execute()) {
        echo "Error al insertar: " . $stmt->error . "<br>";
    }
}

echo "100 usuarios generados exitosamente.";

$stmt->close();
$conn->close();
?>
