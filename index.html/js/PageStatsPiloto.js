const params = new URLSearchParams(window.location.search);
const pilotoNombre = params.get("piloto");
const year = params.get("year");

document.getElementById("titulo").textContent = `Estadísticas de ${pilotoNombre}`;

const edadElem = document.getElementById("edad");
const nacionalidadElem = document.getElementById("nacionalidad");
const inicioElem = document.getElementById("inicio");
const escuderiasElem = document.getElementById("escuderias");
const victoriasElem = document.getElementById("victorias");
const podiosElem = document.getElementById("podios");
const mejorResultadoElem = document.getElementById("mejor-resultado");
const temporadasElem = document.getElementById("temporadas");
const wikiElem = document.getElementById("wiki");
const pilotoFotoElem = document.getElementById("piloto-foto");

let pilotoId = "";

fetch(`https://api.jolpi.ca/ergast/f1/${year}/results.json?limit=1000`)
    .then(response => response.json())
    .then(data => {
    const races = data.MRData.RaceTable.Races;
    races.forEach(race => {
        race.Results.forEach(result => {
        const nombreCompleto = `${result.Driver.givenName} ${result.Driver.familyName}`;
        if (nombreCompleto === pilotoNombre) {
            pilotoId = result.Driver.driverId;
        }
        });
    });

    if (!pilotoId) {
        edadElem.textContent = 'No encontrado';
        nacionalidadElem.textContent = 'No encontrado';
        return;
    }

    // Datos del piloto
    fetch(`https://api.jolpi.ca/ergast/f1/drivers/${pilotoId}.json`)
        .then(res => res.json())
        .then(driverData => {
        const driver = driverData.MRData.DriverTable.Drivers[0];
        const birthDate = new Date(driver.dateOfBirth);
        nacionalidadElem.textContent = driver.nationality;
        wikiElem.href = driver.url;

        // Obtener la foto de Wikipedia
        const wikiTitle = driver.url.split('/').pop();
        fetch(`https://en.wikipedia.org/w/api.php?action=query&format=json&origin=*&prop=pageimages|pageprops&titles=${wikiTitle}&piprop=original`)
            .then(res => res.json())
            .then(wikiData => {
            const pages = wikiData.query.pages;
            const pageId = Object.keys(pages)[0];
            const page = pages[pageId];
            const imageUrl = page.original ? page.original.source : '../Images/SinPerfil.jpg';
            pilotoFotoElem.src = imageUrl;

            // Q-ID para Wikidata
            const qid = page.pageprops && page.pageprops.wikibase_item;
            if (qid) {
                fetch(`https://www.wikidata.org/w/api.php?action=wbgetclaims&entity=${qid}&property=P570&format=json&origin=*`)
                .then(res => res.json())
                .then(wikidata => {
                    const claims = wikidata.claims && wikidata.claims.P570;
                    if (claims && claims.length > 0) {
                    const deathTime = claims[0].mainsnak.datavalue.value.time.replace('+', '');
                    const deathDate = new Date(deathTime);
                    const ageAtDeath = deathDate.getFullYear() - birthDate.getFullYear();
                    edadElem.textContent = `Fallecido a los ${ageAtDeath} años`;
                    } else {
                    const today = new Date();
                    let age = today.getFullYear() - birthDate.getFullYear();
                    if (today.getMonth() < birthDate.getMonth() ||
                        (today.getMonth() === birthDate.getMonth() && today.getDate() < birthDate.getDate())) {
                        age--;
                    }
                    edadElem.textContent = `${age} años`;
                    }
                });
            } else {
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                if (today.getMonth() < birthDate.getMonth() ||
                (today.getMonth() === birthDate.getMonth() && today.getDate() < birthDate.getDate())) {
                age--;
                }
                edadElem.textContent = `${age} años`;
            }
            });
        });

    // Temporadas
    fetch(`https://api.jolpi.ca/ergast/f1/drivers/${pilotoId}/seasons.json`)
        .then(res => res.json())
        .then(seasonsData => {
        const seasons = seasonsData.MRData.SeasonTable.Seasons;
        temporadasElem.textContent = seasons.length;
        if (seasons.length > 0) {
            const primerAnio = Math.min(...seasons.map(s => parseInt(s.season)));
            inicioElem.textContent = primerAnio;
        } else {
            inicioElem.textContent = 'N/A';
        }
        });

    // Estadísticas del piloto
    fetch(`https://api.jolpi.ca/ergast/f1/drivers/${pilotoId}/results.json?limit=1000`)
        .then(res => res.json())
        .then(resultsData => {
        const results = resultsData.MRData.RaceTable.Races;
        let victorias = 0;
        let podios = 0;
        let mejorPos = 99;
        const escuderias = new Set();

        results.forEach(race => {
            race.Results.forEach(result => {
            if (result.Driver.driverId === pilotoId) {
                escuderias.add(result.Constructor.name);
                const pos = parseInt(result.position);
                if (pos === 1) victorias++;
                if (pos <= 3) podios++;
                if (pos < mejorPos) mejorPos = pos;
            }
            });
        });

        escuderiasElem.textContent = [...escuderias].join(", ");
        victoriasElem.textContent = victorias;
        podiosElem.textContent = podios;
        mejorResultadoElem.textContent = mejorPos === 99 ? "N/A" : mejorPos;
        });

    })
    .catch(error => {
    console.error(error);
    });

document.getElementById("btn-volver").addEventListener("click", e => {
    e.preventDefault();
    window.history.back();
});