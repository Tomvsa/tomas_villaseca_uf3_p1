<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 100px;
            max-height: 120px;
            display: block;
            margin: 0 auto;
        }

        .no-films {
            color: red;
            font-size: 18px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    @include('layout.layoutHeader')
    <h1>{{ $title }}</h1>

    @if(empty($actors))
    <p class="no-films">No se ha encontrado ningun actor</p>
    @else
    <table>
        <tr>
            @foreach($actors[0] as $key => $value)
            <th>{{ $key }}</th>
            @endforeach
        </tr>

        @foreach($actors as $actor)
        <tr>
            <td>{{ $actor['id'] }}</td>
            <td>{{ $actor['name'] }}</td>
            <td>{{ $actor['surname'] }}</td>
            <td>{{ $actor['birthdate'] }}</td>
            <td>{{ $actor['country'] }}</td>
            <td><img src="{{ $actor['img_url'] }}" alt="{{ $actor['name'] }}"></td>
            <td>{{ $actor['created_at'] }}</td>
            <td>{{ $actor['updated_at'] }}</td>
        </tr>
        @endforeach
    </table>
    @endif
    @include('layout.layoutFooter')
</body>

</html>