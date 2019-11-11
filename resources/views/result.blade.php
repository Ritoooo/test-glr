<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Resultados</title>
</head>
<body>
    <h3>Resultado</h3>
    @forelse ($result as $item)
        <li>No se puedo copiar -> {{$item}}: <a href="{{ route('storage.specific', ['path'=>$item, 'dest' => $dest]) }}">Copiar</a></li>
    @empty
        Todas las imágenes fueron copiadas satisfactoriamente!!!
    @endforelse
</body>
</html>