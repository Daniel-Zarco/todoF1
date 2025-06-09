<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: PagePrincipal.php");
    exit();
}


$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datos enviados
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Conexión a BBDD (ajusta con tus datos)
    $conn = new mysqli("localhost", "root", "", "todof1");
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Buscar usuario admin
    $stmt = $conn->prepare("SELECT password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hashed_password, $role);
        $stmt->fetch();

        // Verificar contraseña
        if (password_verify($password, $hashed_password)) {
            if ($role === 'admin') {
                $_SESSION['user_role'] = 'admin';
                $_SESSION['username'] = $username;
                header("Location: PagePrincipal.php");
                exit();
            } else {
                $error = "No tienes permisos para acceder.";
            }
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Login Admin</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <video id="background-video" autoplay loop muted playsinline>
        <source src="/TodoF1/todoF1/Images/InitSes5.mp4" type="video/mp4" />
        Tu navegador no soporta video HTML5.
    </video>
    <button onclick="window.history.back()" class="back-button">
        Volver
    </button>
    <div class="login-container">
        <h2>Login Admin</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Usuario" required />
            <input type="password" name="password" placeholder="Contraseña" required />
            <button type="submit">Entrar</button>
        </form>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
