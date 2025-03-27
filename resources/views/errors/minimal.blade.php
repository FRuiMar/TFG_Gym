<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <style>
        /* Estilos generales */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-image: url('/storage/fondos/Fondo4.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            text-align: center;
        }

        /* Contenedor del mensaje */
        .error-container {
            background: rgba(0, 0, 0, 0.7);
            /* Fondo semitransparente */
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        /* Título */
        h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #ff6b6b;
            /* Color rojo pastel */
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #ff6b6b;
            /* Color rojo pastel */
        }

        /* Texto */
        p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        /* Botón de regreso */
        .btn {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
            color: #fff;
            background: #ff6b6b;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s ease;
            cursor: pointer;
        }

        .btn:hover {
            background: #ff4c4c;
            /* Color más oscuro al pasar el mouse */
        }
    </style>
</head>

<body>
    <div class="error-container">
        <h1>ERROR @yield('code')</h1>
        <h2>@yield('title')</h2>
        <p>@yield('message')</p>
        <!-- Botón para volver atrás -->
        <button onclick="goBack()" class="btn">Volver atrás</button>
    </div>

    <script>
        // Función para volver a la página anterior
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>
