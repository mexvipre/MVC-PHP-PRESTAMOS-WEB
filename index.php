<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ultima Tarea</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 200px;
            background-color:rgb(129, 134, 139);
            color: white;
            display: flex;
            flex-direction: column;
            padding: 1rem;
        }

        .sidebar h2 {
            margin-bottom: 2rem;
            font-size: 1.2rem;
        }

        .sidebar button {
            margin-bottom: 1rem;
            padding: 0.8rem;
            background-color:rgb(177, 185, 192);
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            text-align: left;
        }

        .sidebar button:hover {
            background-color:rgb(58, 57, 57);
        }

        /* Contenido */
        .main {
            flex: 1;
            padding: 1rem;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Ultima Tarea 🦖</h2>
        <button onclick="cargarContenido('http://localhost/rest-api-prestamos/app/views/beneficiario/listar.php')">👫 Beneficiarios</button>
        <button onclick="cargarContenido('http://localhost/rest-api-prestamos/app/views/contrato/index.php')">🧾 Contratos</button>
    </div>

    <div class="main">
        <iframe id="contenedor"></iframe>
    </div>

    <script>
        function cargarContenido(ruta) {
            document.getElementById("contenedor").src = ruta;
        }

        // Cargar por defecto el primer botón
        window.onload = function() {
            cargarContenido('http://localhost/rest-api-prestamos/app/views/beneficiario/listar.php');
        }
    </script>

</body>
</html>
