@extends("layout.plantillafct")

@section("title", "Lista de Empresas")

@section("content")
    <div>
        <a href="{{ route('empresas.crear') }}" class="btn btn-verde">Nueva Empresa</a>
    </div>

    @forelse($empresas as $empresa)
        @component("components.tarjeta")
            @slot("cabecera")
                <h4>{{ $empresa->nombre }}</h4>
            @endslot

            @slot("cuerpo")
                <p><strong>Localidad:</strong> {{ $empresa->localidad }}</p>
                <a href="{{ route('empresas.detalle', $empresa->id) }}" class="btn btn-azul">Detalles</a>
            @endslot

            @slot("footer")
                <a href="{{ route('empresas.editar', $empresa->id) }}" class="btn btn-amarillo">Editar</a>
                <form action="{{ route('empresas.eliminar', $empresa->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method("DELETE")
                    <button type="submit" class="btn btn-rojo">Eliminar</button>
                </form>
            @endslot
        @endcomponent
    @empty
        <p>No hay empresas registradas</p>
    @endforelse

    @if(session("mensaje"))
        <div style="background-color: moccasin;">
            {{ session("mensaje") }}
        </div>
    @endif
    {{ $empresas->links('pagination::bootstrap-5') }}
@endsection