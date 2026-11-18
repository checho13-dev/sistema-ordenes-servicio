<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') · Servicio técnico</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<header>
    <nav aria-label="Principal" class="container py-3 d-flex gap-3 flex-wrap align-items-center">
        <strong class="text-white me-auto">Servicio técnico</strong>
        @auth
            @foreach(['ordenes' => 'Órdenes', 'equipos' => 'Equipos', 'clientes' => 'Clientes'] as $ruta => $nombre)
                <a @class(['active' => request()->routeIs($ruta.'.*')]) href="{{ route($ruta.'.index') }}">{{ $nombre }}</a>
            @endforeach
            <form method="post" action="{{ route('logout') }}">@csrf<button class="btn btn-sm btn-outline-light">Salir</button></form>
        @endauth
    </nav>
</header>
<main class="container py-5">
    @foreach(['success' => 'success', 'error' => 'danger'] as $key => $color)
        @if(session($key))<div role="alert" class="alert alert-{{ $color }}">{{ session($key) }}</div>@endif
    @endforeach
    @if($errors->any())
        <div role="alert" class="alert alert-danger"><ul class="mb-0">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul></div>
    @endif
    @yield('content')
</main>
</body>
</html>
