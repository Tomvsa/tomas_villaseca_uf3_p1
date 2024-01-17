<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('css/styles.css') }}"> --}}

</head>

<body class="container mt-4">

    @include('layout.layoutHeader')

    <div class="row">
        <div class="col-md-6">
            <h2>Add Film</h2>
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('createFilm') }}" method="POST">
                @csrf
                <div class="form-group">
                    <i class="bi bi-camera-reels-fill"></i>
                    <input type="text" class="form-control" name="name" placeholder="Film Name" required>
                </div>
                <div class="form-group">
                    <i class="bi bi-calendar-date"></i>
                    <input type="number" class="form-control" name="year" placeholder="Year" required>
                </div>
                <div class="form-group">
                    <i class="bi bi-dice-4-fill"></i>
                    <input type="text" class="form-control" name="genre" placeholder="Genre" required>
                </div>
                <div class="form-group">
                    <i class="bi bi-suitcase2-fill"></i>
                    <input type="text" class="form-control" name="country" placeholder="Country" required>
                </div>
                <div class="form-group">
                    <i class="bi bi-clock-history"></i>
                    <input type="number" class="form-control" name="duration" placeholder="Duration" required>
                </div>
                <div class="form-group">
                    <i class="bi bi-image"></i>
                    <input type="text" class="form-control" name="img_url" placeholder="Image URL" required>
                </div>
                <button type="submit" class="btn btn-primary">Create Film</button>
            </form>
        </div>
    </div>

    @include('layout.layoutFooter')

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>