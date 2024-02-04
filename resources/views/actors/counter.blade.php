<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('css/styles.css') }}"> --}}

    <style>
        body {
            padding: 20px;
        }

        p {
            font-size: 18px;
            color: #28a745;
        }
    </style>
</head>

<body>
    @include('layout.layoutHeader')

    <div class="container">
        <h1>{{ $title }}</h1>
        <p>Total Number of Actors: {{ $total_actors }}</p>
    </div>
    @include('layout.layoutFooter')
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>