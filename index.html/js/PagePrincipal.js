const select = document.getElementById("anio");
for (let y = 1950; y <= 2025; y++) {
    const opt = document.createElement("option");
    opt.value = y;
    opt.textContent = y;
    select.appendChild(opt);
}

const params = new URLSearchParams(window.location.search);
const year = params.get("year");
if (year) {
    select.value = year;
    fetchTop3(year);
    updateRankingTitle(year);
}

select.addEventListener("change", function() {
    const selectedYear = this.value;
    fetchTop3(selectedYear);
    updateRankingTitle(selectedYear);
});

function updateRankingTitle(year) {
    const rankingTitle = document.getElementById("ranking-title");
    rankingTitle.textContent = `Ranking del ${year}`;
    document.getElementById("ranking-lists").style.display = "grid";
}

function redirigirConAño(tipo) {
    const año = document.getElementById("anio").value;
    if (!año) {
        alert("Por favor selecciona un año.");
        return;
    }
    const rutas = {
        Pilotos: `/TodoF1/todoF1/index.html/PagePilotos.php?year=${año}`,
        Escuderia: `/TodoF1/todoF1/index.html/PageEscuderias.php?year=${año}`,
        Circuitos: `/TodoF1/todoF1/index.html/PageCircuitos.php?year=${año}`,
    };
    window.location.href = rutas[tipo] || "/";
}

async function fetchTop3(year) {
    const pilotosList = document.getElementById("top3-pilotos");
    const escuderiasList = document.getElementById("top3-escuderias");

    pilotosList.innerHTML = "<li>Cargando...</li>";
    escuderiasList.innerHTML = "<li>Cargando...</li>";

    try {
        const response = await fetch(`https://api.jolpi.ca/ergast/f1/${year}/driverStandings.json`);
        const data = await response.json();
        const drivers = data.MRData.StandingsTable.StandingsLists[0]?.DriverStandings || [];
        pilotosList.innerHTML = "";
        drivers.slice(0, 3).forEach(driver => {
            const name = `${driver.Driver.givenName} ${driver.Driver.familyName}`;
            const points = driver.points;
            const li = document.createElement("li");
            li.innerHTML = `<span>${name}</span> - ${points} puntos`;
            pilotosList.appendChild(li);
        });

        const responseConstructors = await fetch(`https://api.jolpi.ca/ergast/f1/${year}/constructorStandings.json`);
        const dataConstructors = await responseConstructors.json();
        const constructors = dataConstructors.MRData.StandingsTable.StandingsLists[0]?.ConstructorStandings || [];
        escuderiasList.innerHTML = "";
        constructors.slice(0, 3).forEach(team => {
            const name = team.Constructor.name;
            const points = team.points;
            const li = document.createElement("li");
            li.innerHTML = `<span>${name}</span> - ${points} puntos`;
            escuderiasList.appendChild(li);
        });
    } catch (error) {
        console.error("Error al cargar el Top 3:", error);
        pilotosList.innerHTML = "<li>Error al cargar datos.</li>";
        escuderiasList.innerHTML = "<li>Error al cargar datos.</li>";
    }
}