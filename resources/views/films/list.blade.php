<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title }}</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
  <div class="container">
    <h1>{{ $title }}</h1>

    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Year</th>
          <th>Genre</th>
          <th>Country</th>
          <th>duration</th>
          <th>img</th>
          <th>created_at</th>
          <th>updated_at</th>
        </tr>
      </thead>
      <tbody>
        @forelse($paginatedFilms as $film)
          <tr>
            <td>{{ $film['id'] ?? '' }}</td>
            <td>{{ $film['name'] }}</td>
            <td>{{ $film['year'] }}</td>
            <td>{{ $film['genre'] }}</td>
            <td>{{ $film['country'] }}</td>
            <td>{{ $film['duration'] }} minutos</td>
            <td><img width="100px" src="{{ $film['img_url'] }}" alt="{{ $film['name'] }}"></td>
            <td>{{ $film['created_at'] ?? '' }}</td>
            <td>{{ $film['updated_at'] ?? '' }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="5">No films found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
        @if ($currentPage > 1)
          <li class="page-item">
            <a class="page-link" href="?page={{ $currentPage - 1 }}">Anterior</a>
          </li>
        @endif

        @for ($i = 1; $i <= $totalPages; $i++)
          <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
            <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
          </li>
        @endfor

        @if ($currentPage < $totalPages)
          <li class="page-item">
            <a class="page-link" href="?page={{ $currentPage + 1 }}">Siguiente</a>
          </li>
        @endif
      </ul>
    </nav>
  </div>
</body>

</html>