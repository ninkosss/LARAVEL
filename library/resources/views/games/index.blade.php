<!DOCTYPE html>
<html>
<head>
    <title>Ігри</title>
</head>
<body>
    <h1>Список ігор</h1>
    <ul>
        @foreach($games as $game)
            <li>
                <strong>{{ $game->name }}</strong> -
                Жанр: {{ $game->genre }} -
                Рік: {{ $game->release_year }}
            </li>
        @endforeach
    </ul>
</body>
</html>
