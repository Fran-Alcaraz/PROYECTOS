<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>
        @yield('title')
    </title>
</head>
<body>
    <header style="background-color: salmon;">
    @include('layout._partials.cabecera')
    <h1>{{$page}}</h1>   
    
    @include('layout._partials.menu')
    </header>
    <br>

    <!-- CONTENIDO DINÁMICO EN FUNCIÓN DE LA SECCIÓN QUE SE VISITA -->
    <div>
        @yield('content')
    </div>

    <br>
    @include('layout._partials.footer')
   
</body>
</html>