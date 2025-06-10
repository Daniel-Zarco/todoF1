const params = new URLSearchParams(window.location.search);
const escuderia = params.get("escuderia");
const year = params.get("year");

document.getElementById("titulo").textContent = `Estadísticas de ${escuderia}`;

const container = document.getElementById("stats-container");

Promise.all([
    fetch(`https://api.jolpi.ca/ergast/f1/${year}.json`).then(res => res.json()),
    fetch(`https://api.jolpi.ca/ergast/f1/${year}/results.json?limit=1000`).then(res => res.json())
    ])
    .then(([temporadaData, data]) => {
    const totalCarrerasTemporada = temporadaData.MRData.RaceTable.Races.length;
    const races = data.MRData.RaceTable.Races;

    // Filtrar resultados para la escudería
    const resultadosEscuderia = [];

    races.forEach(race => {
        race.Results.forEach(result => {
        if (result.Constructor.name.toLowerCase() === escuderia.toLowerCase()) {
            resultadosEscuderia.push({
            race,
            result
            });
        }
        });
    });

    if (resultadosEscuderia.length === 0) {
        container.innerHTML = `<div class="info-block">
        <span class="label">No hay información disponible para la escudería "${escuderia}" en el año ${year}.</span>
    </div>`;
        return;
    }

    let victorias = 0;
    let podios = 0;
    let nacionalidad = resultadosEscuderia[0].result.Constructor.nationality;
    let totalPuntos = 0;
    let pilotos = new Set();
    let posiciones = [];

    resultadosEscuderia.forEach(({
        result
    }) => {
        pilotos.add(`${result.Driver.givenName} ${result.Driver.familyName}`);
        totalPuntos += parseFloat(result.points);
        const pos = parseInt(result.position);
        if (pos === 1) victorias++;
        if (pos <= 3) podios++;
        posiciones.push(pos);
    });

    const posMedia = posiciones.length > 0 ?
        (posiciones.reduce((a, b) => a + b, 0) / posiciones.length).toFixed(2) :
        "N/A";

    const stats = [{
        label: "Nacionalidad",
        value: nacionalidad || "N/A"
        },
        {
        label: `Carreras corridas en ${year}`,
        value: totalCarrerasTemporada
        },
        {
        label: "Victorias",
        value: victorias
        },
        {
        label: "Podios",
        value: podios
        },
        {
        label: "Total de Puntos",
        value: totalPuntos
        },
        {
        label: "Posición Media",
        value: posMedia
        },
        {
        label: "Pilotos ese año",
        value: Array.from(pilotos).join(", ")
        },
    ];

    container.innerHTML = ''; // Limpiar antes
    stats.forEach(stat => {
        const block = document.createElement('div');
        block.classList.add('info-block');
        block.innerHTML = `
        <span class="label">${stat.label}:</span>
        <span class="value">${stat.value}</span>
    `;
        container.appendChild(block);
    });
    })
    .catch(error => {
    console.error(error);
    container.innerHTML = '<p>Error al cargar las estadísticas de la escudería.</p>';
    });

document.getElementById("btn-volver").addEventListener("click", e => {
    e.preventDefault();
    window.history.back();
});