<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <title>Estadísticas del Piloto</title>
  <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/PageStatsPiloto.css">
  <link rel="stylesheet" href="css/navbar.css">
  <script src="js/PageStatsPiloto.js" defer></script>
</head>

<body>
  <?php include '../api/navbar.php'; ?>
  <h1 id="titulo">Estadísticas del Piloto</h1>

  <!-- Bloque de la foto -->
  <div class="foto-block">
    <span class="label">Foto del Piloto:</span>
    <img id="piloto-foto" src="" alt="Foto del piloto">
  </div>

  <div class="grid-container">
    <div class="info-block"><span class="label">Edad:</span><span class="value" id="edad">Cargando...</span></div>
    <div class="info-block"><span class="label">Nacionalidad:</span><span class="value" id="nacionalidad">Cargando...</span></div>
    <div class="info-block"><span class="label">Inicio en F1:</span><span class="value" id="inicio">Cargando...</span></div>
    <div class="info-block"><span class="label">Escuderías:</span><span class="value" id="escuderias">Cargando...</span></div>
    <div class="info-block"><span class="label">Carreras ganadas:</span><span class="value" id="victorias">Cargando...</span></div>
    <div class="info-block"><span class="label">Podios:</span><span class="value" id="podios">Cargando...</span></div>
    <div class="info-block"><span class="label">Mejor resultado:</span><span class="value" id="mejor-resultado">Cargando...</span></div>
    <div class="info-block"><span class="label">Temporadas:</span><span class="value" id="temporadas">Cargando...</span></div>
    <div class="info-block wiki-block">
      <span class="label">Wikipedia:</span>
      <a id="wiki" href="#" target="_blank" class="value" style="color:#fff; text-decoration:underline;">Ver más</a>
    </div>
  </div>

  <a href="#" id="btn-volver" class="back-button">← Volver a Pilotos</a>
</body>

</html>