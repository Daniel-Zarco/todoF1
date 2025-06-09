<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <title>Escuderías F1</title>
  <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/PageEscuderias.css">
  <link rel="stylesheet" href="css/navbar.css">
</head>

<body>
  <?php include '../api/navbar.php'; ?>
  <header>
    <h1>Escuderías F1</h1>
  </header>
  <!--Boton de retroceso-->
  <button id="btn-volver" class="back-button">
    ← Página principal
  </button>
  <div class="container" id="escuderias-container"></div>

  <script>
    const params = new URLSearchParams(window.location.search);
    const year = params.get("year") || 2025;

    // 1. Diccionario de colores por escudería
    const coloresPorEscuderia = {
      "ferrari": "#e10600",
      "mercedes": "#00d2be",
      "red bull": "#0600ef",
      "mclaren": "#ff8700",
      "alpine": "#0090ff",
      "aston martin": "#006f62",
      "williams": "#005aff",
      "sauber": "#39FF14",
      "haas": "#F74955",
      "rb f1 team": "#ffffff"
    };

    fetch(`https://api.jolpi.ca/ergast/f1/${year}/results.json?limit=1000`)
      .then(response => response.json())
      .then(data => {
        const races = data.MRData.RaceTable.Races;
        const escuderiasUnicas = new Map();

        races.forEach(race => {
          race.Results.forEach(result => {
            const constructor = result.Constructor;
            if (!escuderiasUnicas.has(constructor.constructorId)) {
              escuderiasUnicas.set(constructor.constructorId, {
                nombre: constructor.name,
                nacionalidad: constructor.nationality
              });
            }
          });
        });

        const container = document.getElementById('escuderias-container');

        // Convertir el Map a un array y ordenarlo alfabéticamente
        const escuderiasOrdenadas = Array.from(escuderiasUnicas.values())
          .sort((a, b) => a.nombre.localeCompare(b.nombre));

        escuderiasOrdenadas.forEach(escuderia => {
          const card = document.createElement('div');
          card.classList.add('card');
          card.innerHTML = `
          <h2>${escuderia.nombre}</h2>
          <p><strong>Nacionalidad:</strong> ${escuderia.nacionalidad}</p>
        `;

          // 2. Normalizar el nombre para comparar con el diccionario
          const nombreNormalizado = escuderia.nombre.toLowerCase().replace(/[^a-z0-9]/gi, '').trim();
          let colorBorde = "#000000"; // valor por defecto si no se encuentra

          // 3. Buscar coincidencia en el diccionario de colores
          for (const equipo in coloresPorEscuderia) {
            if (nombreNormalizado.includes(equipo.replace(/[^a-z0-9]/gi, ''))) {
              colorBorde = coloresPorEscuderia[equipo];
              break;
            }
          }

          // 4. Aplicar el borde de color
          card.style.border = `2px solid ${colorBorde}`;
          card.addEventListener('mouseenter', () => {
            card.style.boxShadow = `0 0 15px ${colorBorde}`;
          });

          card.addEventListener('mouseleave', () => {
            card.style.boxShadow = ''; // Lo removemos cuando no hay hover
          });


          // Evento click para redirigir
          card.addEventListener('click', () => {
            window.location.href = `PageStatsEscuderia.php?escuderia=${encodeURIComponent(escuderia.nombre)}&year=${year}`;
          });

          container.appendChild(card);
        });
      })
      .catch(error => {
        console.error(error);
        document.getElementById('escuderias-container').innerHTML = '<p>Error al cargar escuderías desde la API.</p>';
      });

    // Botón de retroceso
    document.getElementById('btn-volver').addEventListener('click', function() {
      const params = new URLSearchParams(window.location.search);
      const year = params.get('year');

      let url = '/TodoF1/todoF1/index.html/PagePrincipal.php';
      if (year) {
        url += `?year=${year}`;
      }
      window.location.href = url;
    });
  </script>

</body>

</html>