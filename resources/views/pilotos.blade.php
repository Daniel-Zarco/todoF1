<!-- //06-05-2025// -->

<!DOCTYPE html>
<html>
<head>
    <title>Pilotos desde API</title>
</head>
<body>
    
    <h1>Pilotos desde la API</h1>
    
    <ul id="lista-pilotos"></ul>
    <h3>LLego</h3>
    <script>
        
        fetch('/api/pilotos')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta de la API');
                }
                return response.json();
            })
            .then(data => {
                const lista = document.getElementById('lista-pilotos');
                data.forEach(piloto => {
                    const li = document.createElement('li');
                    li.textContent = `${piloto.nombre} (${piloto.nacionalidad})`;
                    lista.appendChild(li);
                });
            })
            .catch(error => {
                console.error('Error al cargar los pilotos:', error);
            });
    </script>
</body>
</html>


