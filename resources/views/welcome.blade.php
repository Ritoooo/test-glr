<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        
    </head>
    <body>
        <form action="{{ route('json') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="json" id="json">
            <input type="submit" value="enviar">
        </form>
    </body>
</html>
