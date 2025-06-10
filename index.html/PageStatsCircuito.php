<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <title>Estadísticas del Circuito</title>
  <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/PageStatsCircuito.css">
  <link rel="stylesheet" href="css/navbar.css">
  <script src="js/PageStatsCirucito.js" defer></script>
</head>

<body>
  <?php include '../api/navbar.php'; ?>
  <h1 id="titulo"></h1>
  <div class="main-container">
    <div class="stats-container">
      <div id="info-adicional"></div>
      <div id="vuelta-rapida"></div>
      <table id="tabla-resultados">
        <thead>
          <tr>
            <th>Posición</th>
            <th>Piloto</th>
            <th>Escudería</th>
            <th>Vueltas</th>
            <th>Tiempo Final</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
      <a href="#" id="btn-volver" class="back-button">← Volver a Circuitos</a>
    </div>

    <div class="foto-block">
      <span class="label">Foto del Circuito:</span>
      <div class="img-wrapper">
        <img id="circuito-foto" src="" alt="Foto del circuito">
      </div>
    </div>
  </div>
</body>

</html>