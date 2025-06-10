<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: /TodoF1/todof1/index.html/login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Datos Registrados - Estilo F1</title>

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="/TodoF1/todoF1/index.html/css/PageInfo.css" />
</head>

<body>

    <a href="../index.html/PagePrincipal.php" class="back-button">← Volver</a>

    <h1>Datos Registrados</h1>
    <div class="total-users">
        <h2>Total de Usuarios: <span id="totalUsuarios"></span></h2>
    </div>


    <div class="charts-container">
        <div class="chart-box">
            <h2>Distribución de Género</h2>
            <canvas id="genderChart"></canvas>
        </div>
        <div class="chart-box">
            <h2>Distribución de Países</h2>
            <canvas id="countryChart"></canvas>
        </div>
        <div class="chart-box">
            <h2>Distribución de Edades</h2>
            <canvas id="ageChart"></canvas>
        </div>
    </div>

    <script>
        // Datos PHP inyectados en JS
        const generos = <?= $generos_json ?>;
        const paises = <?= $paises_json ?>;
        const edades = <?= $edades_json ?>;
        const totalUsuarios = <?= $totalUsuarios_json ?>;

        // Muestra el total de usuarios
        document.getElementById('totalUsuarios').textContent = totalUsuarios;

        // Gráfico de Género (Pie chart)
        const ctxGen = document.getElementById('genderChart').getContext('2d');
        new Chart(ctxGen, {
            type: 'pie',
            data: {
                labels: Object.keys(generos),
                datasets: [{
                    data: Object.values(generos),
                    backgroundColor: ['#ff0000', '#0050ff', '#ffb400', '#00ff94', '#aa00ff']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#ff3b3b',
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });

        // Gráfico de País (Bar chart)
        const ctxPais = document.getElementById('countryChart').getContext('2d');
        new Chart(ctxPais, {
            type: 'bar',
            data: {
                labels: Object.keys(paises),
                datasets: [{
                    label: 'Número de personas',
                    data: Object.values(paises),
                    backgroundColor: '#e10600'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0,
                        ticks: {
                            color: '#ff3b3b',
                            font: {
                                weight: 'bold'
                            }
                        }
                    },
                    x: {
                        ticks: {
                            color: '#ff3b3b',
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Agrupar edades en rangos de 10 años
        function agruparEdades(edades) {
            const bins = {};
            edades.forEach(age => {
                const rango = Math.floor(age / 10) * 10;
                const label = `${rango} - ${rango + 9}`;
                bins[label] = (bins[label] || 0) + 1;
            });
            return bins;
        }

        const edadesAgrupadas = agruparEdades(edades);

        const ctxEdad = document.getElementById('ageChart').getContext('2d');
        new Chart(ctxEdad, {
            type: 'bar',
            data: {
                labels: Object.keys(edadesAgrupadas),
                datasets: [{
                    label: 'Número de personas',
                    data: Object.values(edadesAgrupadas),
                    backgroundColor: '#ff3b3b'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0,
                        ticks: {
                            color: '#ff3b3b',
                            font: {
                                weight: 'bold'
                            }
                        }
                    },
                    x: {
                        ticks: {
                            color: '#ff3b3b',
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>

</body>

</html>