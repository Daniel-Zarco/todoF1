const params = new URLSearchParams(window.location.search);
const circuito = params.get("circuito");
const year = params.get("year");

const titulo = document.getElementById("titulo");
titulo.textContent = `Estadísticas del ${circuito} (${year})`;

const tbody = document.querySelector("#tabla-resultados tbody");
const infoAdicional = document.getElementById("info-adicional");
const vueltaRapidaDiv = document.getElementById("vuelta-rapida");
const circuitoFotoElem = document.getElementById("circuito-foto");

// Obtener la foto del circuito desde Wikipedia
const wikiTitle = circuito.replace(/ /g, '_');
fetch(`https://en.wikipedia.org/w/api.php?action=query&format=json&origin=*&prop=pageimages|pageprops&titles=${wikiTitle}&piprop=original`)
    .then(res => res.json())
    .then(wikiData => {
    const pages = wikiData.query.pages;
    const pageId = Object.keys(pages)[0];
    const page = pages[pageId];
    const imageUrl = page.original ? page.original.source : '';
    const fotoBlock = document.querySelector('.foto-block');

    if (imageUrl) {
        circuitoFotoElem.src = imageUrl;
    } else {
        // Oculta el bloque completo si no hay foto
        fotoBlock.style.display = 'none';
    }

    })
    .catch(error => {
    console.error(error);
    circuitoFotoElem.src = 'none';
    });

// Primero obtenemos todas las carreras del año para encontrar la que corresponde al circuito
fetch(`https://api.jolpi.ca/ergast/f1/${year}/races.json?limit=1000`)
    .then(response => response.json())
    .then(data => {
    const races = data.MRData.RaceTable.Races;
    const carrera = races.find(race => race.Circuit.circuitName === circuito);

    if (!carrera) {
        tbody.innerHTML = `<tr><td colspan="5">No se encontró la carrera de ${circuito} en ${year}.</td></tr>`;
        return null;
    }

    infoAdicional.innerHTML = `
        <p><span class="highlight">País:</span> ${carrera.Circuit.Location.country}</p>
        <p><span class="highlight">Ciudad:</span> ${carrera.Circuit.Location.locality}</p>
        <p><span class="highlight">Fecha:</span> ${carrera.date}</p>
    `;

    // Obtenemos resultados de la carrera usando el round para la url
    return fetch(`https://api.jolpi.ca/ergast/f1/${year}/${carrera.round}/results.json`);
    })
    .then(response => response ? response.json() : null)
    .then(data => {
    if (!data) return;

    const results = data.MRData.RaceTable.Races[0]?.Results;
    if (!results || results.length === 0) {
        tbody.innerHTML = `<tr><td colspan="5">No hay resultados disponibles.</td></tr>`;
        return;
    }

    results.forEach(result => {
        const row = document.createElement("tr");
        row.innerHTML = `
        <td>${result.position}</td>
        <td>${result.Driver.givenName} ${result.Driver.familyName}</td>
        <td>${result.Constructor.name}</td>
        <td>${result.laps}</td>
        <td>${result.Time ? result.Time.time : 'N/A'}</td>
        `;
        tbody.appendChild(row);
    });

    // Buscar vuelta rápida
    let fastestLap = null;
    results.forEach(result => {
        if (result.FastestLap && result.FastestLap.rank === "1") {
        fastestLap = result.FastestLap;
        }
    });

    if (fastestLap) {
        const driver = results.find(r => r.FastestLap && r.FastestLap.rank === "1").Driver;
        vueltaRapidaDiv.innerHTML = `
        <p><span class="highlight">Vuelta rápida:</span> ${driver.givenName} ${driver.familyName} - ${fastestLap.Time.time} (Vuelta ${fastestLap.lap})</p>
        `;
    } else {
        vueltaRapidaDiv.innerHTML = `
        <p><span class="highlight">Vuelta rápida:</span> No disponible en la API para este año.</p>
        `;
    }
    })
    .catch(error => {
    console.error(error);
    tbody.innerHTML = `<tr><td colspan="5">Error al cargar los datos.</td></tr>`;
    });

document.getElementById("btn-volver").addEventListener("click", function(e) {
    e.preventDefault();
    window.history.back();
});