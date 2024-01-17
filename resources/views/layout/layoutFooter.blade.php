<!-- layoutFooter.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi Sitio')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            padding-bottom: 60px; /* Ajusta el espacio para el pie de página fijo */
        }

        footer {
            bottom: 0;
            width: 100%;
            background-color: #f8f9fa; /* Agrega un fondo de color claro al pie de página */
            padding: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <footer>
        @yield('footer')
        <p>&copy; {{ date('Y') }} Mi Sitio Web</p>
        <p>Correo de contacto: stucom@gmail.com</p>
        <p>Número de contacto: +34 604654678</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>
