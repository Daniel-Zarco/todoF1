<?php
session_start();
$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : '';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Página Principal</title>
    <link rel="stylesheet" href="css/PagePrincipal.css">
    <script src="js/PagePrincipal.js" defer></script>
</head>

<body>

    <!-- Navbar -->
    <?php if ($isLoggedIn): ?>
        <nav class="navbar">
            <div class="navbar-user">
                👤 <?php echo htmlspecialchars($username); ?>
            </div>

        </nav>
        <div class="logout-container">
            <form action="../api/logout.php" method="POST" class="logout-form">
                <button type="submit" class="logout-button">Cerrar Sesión</button>
            </form>
        </div>
    <?php endif; ?>

    <!-- Botón volver (si no está logado) -->
    <?php if (!$isLoggedIn): ?>
        <div class="logout-container">
            <form action="/TodoF1/todoF1/index.html/InitSes.html" method="GET" class="logout-form">
                <button type="submit" class="logout-button">Volver a Inicio</button>
            </form>
        </div>
    <?php endif; ?>

    <div class="info-container">
        <button onclick="window.location.href='../api/PageInfo.php'" class="info-btn">Ir a Info</button>
    </div>

    <header>
        <span id="title">Todo F1</span>
        <p>Aprende sobre el mundo de la Fórmula 1</p>
        <div id="anioInput">
            <section class="year-selector" style="text-align: center; margin-top: 20px">
                <label for="anio" style="font-size: 1.1em; margin-right: 10px">Selecciona un año:</label>
                <select id="anio" name="anio" style="padding: 8px 12px; border-radius: 8px; font-size: 1em">
                    <option value="" disabled selected>Elige un año</option>
                </select>
            </section>
        </div>
    </header>

    <main class="container">
        <!-- Cards -->
        <div class="card">
            <h2>Pilotos</h2>
            <p>Consulta y gestiona información de todos los pilotos de F1.</p>
            <a href="#" onclick="redirigirConAño('Pilotos')">Ver Pilotos</a>
        </div>
        <div class="card">
            <h2>Escuderías</h2>
            <p>Conoce las escuderías históricas y actuales.</p>
            <a href="#" onclick="redirigirConAño('Escuderia')">Ver Escuderías</a>
        </div>
        <div class="card">
            <h2>Circuitos</h2>
            <p>Explora los circuitos más emblemáticos del campeonato.</p>
            <a href="#" onclick="redirigirConAño('Circuitos')">Ver Circuitos</a>
        </div>
    </main>

    <section class="ranking-container">
        <h2 id="ranking-title">Por favor, seleccione un año</h2>
        <div id="ranking-lists" class="ranking-grid">
            <div class="ranking-card">
                <h3>Top 3 Pilotos</h3>
                <ol id="top3-pilotos">
                    <li>Cargando...</li>
                </ol>
            </div>
            <div class="ranking-card">
                <h3>Top 3 Escuderías</h3>
                <ol id="top3-escuderias">
                    <li>Cargando...</li>
                </ol>
            </div>
        </div>
    </section>
</body>

</html>