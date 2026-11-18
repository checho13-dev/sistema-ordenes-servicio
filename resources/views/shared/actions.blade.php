<div class="d-flex flex-wrap gap-2">
    <a class="btn btn-outline-primary" href="{{ route($ruta.'.edit', $registro) }}">Editar</a>
    <form method="post" action="{{ route($ruta.'.destroy', $registro) }}" data-confirm="¿Eliminar este registro de forma permanente?">
        @csrf @method('DELETE')
        <button class="btn btn-outline-danger">Eliminar</button>
    </form>
</div>
