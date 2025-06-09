<?php
// Datos de conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todof1";

// Datos del nuevo admin
$newAdminUser = "Daniel";
$newAdminPass = "TodoF1";
//$newAdminUser = "Alonso";
//$newAdminPass = "ElNanoAe"; 
//$newAdminUser = "Manolo";
//$newAdminPass = "Manolo1234"; 
// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Hashear la contraseña
$hashed_password = password_hash($newAdminPass, PASSWORD_DEFAULT);

// Preparar consulta para insertar admin
$stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')");
$stmt->bind_param("ss", $newAdminUser, $hashed_password);

if ($stmt->execute()) {
    echo "Usuario admin creado exitosamente.<br>";
    echo "Usuario: $newAdminUser <br>Contraseña: $newAdminPass";
} else {
    echo "Error al crear usuario admin: " . $stmt->error;
}

$stmt->close();
$conn->close();
