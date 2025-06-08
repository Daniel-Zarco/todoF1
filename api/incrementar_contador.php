<?php
header('Content-Type: application/json');

// Configuración base de datos
$servername = "localhost";
$username = "tu_usuario";
$password = "tu_contraseña";
$dbname = "todof1";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  http_response_code(500);
  echo json_encode(["error" => "Error de conexión a la base de datos"]);
  exit;
}

// Incrementar contador
$sql = "UPDATE contador_sesiones SET contador = contador + 1 WHERE id = 1";

if ($conn->query($sql) === TRUE) {
  // Obtener valor actualizado
  $result = $conn->query("SELECT contador FROM contador_sesiones WHERE id = 1");
  $row = $result->fetch_assoc();
  echo json_encode(["contador" => (int)$row['contador']]);
} else {
  http_response_code(500);
  echo json_encode(["error" => "Error al actualizar contador"]);
}

$conn->close();
