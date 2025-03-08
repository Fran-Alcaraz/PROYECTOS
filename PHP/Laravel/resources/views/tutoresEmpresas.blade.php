@extends("layout.plantillafct")

@section("title", "Lista de Tutores de Empresas")

@section("content")
    <div>
        <a href="{{ route('tutoresEmpresa.crear') }}" class="btn btn-verde">Nuevo Tutor de Empresa</a>
    </div>

    @forelse($tutoresEmpresas as $tutor)
        @component("components.tarjeta")
            @slot("cabecera")
                <h4>{{ $tutor->nombre }} {{ $tutor->apellidos }}</h4>
            @endslot

            @slot("cuerpo")
                <p><strong>Correo:</strong> {{ $tutor->email }}</p>
                <p><strong>Empresa:</strong> {{ $tutor->empresa->nombre }}</p>
            @endslot

            @slot("footer")
                <a href="{{ route('tutoresEmpresa.editar', $tutor->id) }}" class="btn btn-amarillo">Editar</a>
                <form action="{{ route('tutoresEmpresa.eliminar', $tutor->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method("DELETE")
                    <button type="submit" class="btn btn-rojo">Eliminar</button>
                </form>
            @endslot
        @endcomponent
    @empty
        <p>No hay tutores de empresa registrados</p>
    @endforelse

    @if(session("mensaje"))
        <div style="background-color: moccasin;">
            {{ session("mensaje") }}
        </div>
    @endif
    {{ $tutoresEmpresas->links('pagination::bootstrap-5') }}
@endsection