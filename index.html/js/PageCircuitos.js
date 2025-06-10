const params = new URLSearchParams(window.location.search);
    const year = params.get("year") || 2025;

    fetch(`https://api.jolpi.ca/ergast/f1/${year}.json`)
      .then(response => response.json())
      .then(data => {
        const races = data.MRData.RaceTable.Races;
        const container = document.getElementById('circuitos-container');
        container.innerHTML = "";

        const today = new Date(); // fecha actual real

        races.forEach(race => {
          const circuito = race.Circuit;
          const raceDate = new Date(race.date);

          const card = document.createElement('div');
          card.classList.add('card');

          // Si la fecha de la carrera es mayor a hoy, aún no se corrió
          if (raceDate > today) {
            card.style.backgroundColor = '#555'; // fondo blanco
            card.style.color = '#000'; // para que el texto sea legible con fondo blanco
          }

          card.innerHTML = `
      <h2>${circuito.circuitName}</h2>
      <p><strong>País:</strong> ${circuito.Location.country}</p>
      <p><strong>Ciudad:</strong> ${circuito.Location.locality}</p>
      <p><strong>Fecha:</strong> ${race.date}</p>
    `;

          card.addEventListener('click', () => {
            const circuitoParam = encodeURIComponent(circuito.circuitName);
            window.location.href = `PageStatsCircuito.php?circuito=${circuitoParam}&year=${year}`;
          });

          if (raceDate > today) {
            card.classList.add('no-corrida');
            card.innerHTML += `<div class="badge">Proximamente </div>`;
          }


          container.appendChild(card);
        });

      })
      .catch(error => {
        console.error(error);
        document.getElementById('circuitos-container').innerHTML = '<p>Error al cargar los circuitos desde la API Jolpi.</p>';
      });


    /*Boton retroceso*/
    document.getElementById('btn-volver').addEventListener('click', function() {
      let url = '/TodoF1/todoF1/index.html/PagePrincipal.php';
      if (year) {
        url += `?year=${year}`;
      }
      window.location.href = url;
    });