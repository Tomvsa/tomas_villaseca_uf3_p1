<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi Sitio')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<body>

    <div class="jumbotron">
        <a href="{{ url('/') }}"><img src="https://cdn-icons-png.flaticon.com/512/11321/11321267.png" width="100px" alt="Header Image" class="img-fluid"></a>
        <h1 class="display-4">Lista de Peliculas</h1>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="{{ url('/filmout/films') }}">Pelis</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/filmout/oldFilms') }}">Pelis antiguas</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/filmout/newFilms') }}">Pelis nuevas</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/filmout/countFilms') }}">Count films</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/filmout/sortFilms') }}">Sort films</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
            </ul>
        </nav>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>