const params = new URLSearchParams(window.location.search);
const year = params.get("year") || 2025;

fetch(`https://api.jolpi.ca/ergast/f1/${year}/results.json?limit=1000`)
    .then(response => response.json())
    .then(data => {
    const races = data.MRData.RaceTable.Races;
    const pilotosUnicos = new Map();

    races.forEach(race => {
        race.Results.forEach(result => {
        const piloto = result.Driver;
        if (!pilotosUnicos.has(piloto.driverId)) {
            pilotosUnicos.set(piloto.driverId, {
            id: piloto.driverId,
            nombre: `${piloto.givenName} ${piloto.familyName}`,
            nacionalidad: piloto.nationality,
            fechaNacimiento: piloto.dateOfBirth,
            });
        }
        });
    });

    const container = document.getElementById('pilotos-container');
    const pilotosOrdenados = Array.from(pilotosUnicos.values()).sort(
        (a, b) => a.nombre.localeCompare(b.nombre, 'es', {
        sensitivity: 'base'
        })
    );

    pilotosOrdenados.forEach(piloto => {
        const card = document.createElement('div');
        card.classList.add('card');
        card.innerHTML = `
        <h2>${piloto.nombre}</h2>
        <p><strong>Nacionalidad:</strong> ${piloto.nacionalidad}</p>
        <p><strong>Fecha de nacimiento:</strong> ${piloto.fechaNacimiento}</p>
        `;
        card.addEventListener('click', () => {
        const pilotoParam = encodeURIComponent(piloto.nombre);
        window.location.href = `PageStatsPiloto.php?piloto=${pilotoParam}&year=${year}`;
        });
        container.appendChild(card);
    });
    })
    .catch(error => {
    console.error(error);
    document.getElementById('pilotos-container').innerHTML = '<p>Error al cargar pilotos desde la API.</p>';
    });

document.getElementById('btn-volver').addEventListener('click', function() {
    let url = '/TodoF1/todoF1/index.html/PagePrincipal.php';
    if (year) {
    url += `?year=${year}`;
    }
    window.location.href = url;
});