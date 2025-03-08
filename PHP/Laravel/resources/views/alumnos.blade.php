@extends("layout.plantillafct")

@section("title", "Lista de Alumnos")

@section("content")
    <div>
        <a href="{{ route('alumnos.crear') }}" class="btn btn-verde">Nuevo Alumno</a>
    </div>

    @forelse($alumnos as $alumno)
        @component("components.tarjeta")
            @slot("cabecera")
                <h4>{{ $alumno->nombre }} {{ $alumno->apellidos }}</h4>
            @endslot

            @slot("cuerpo")
                <p><strong>NIF:</strong> {{ $alumno->NIF }}</p>
                <p><strong>NUSS:</strong> {{ $alumno->NUSS }}</p>
                <p><strong>Correo:</strong> {{ $alumno->email }}</p>
                <p><strong>Móvil:</strong> {{ $alumno->movil }}</p>
                <p><strong>Fecha de nacimiento:</strong> {{ $alumno->fecha_nacimiento }}</p>
                <p><strong>Tutor de instituto:</strong> {{ $alumno->tutorInstituto->nombre }}</p>
            @endslot

            @slot("footer")
                <a href="{{ route('alumnos.editar', $alumno->id) }}" class="btn btn-amarillo">Editar</a>
                <form action="{{ route('alumnos.eliminar', $alumno->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method("DELETE")
                    <button type="submit" class="btn btn-rojo">Eliminar</button>
                </form>
            @endslot
        @endcomponent
    @empty
        <p>No hay alumnos registrados</p>
    @endforelse

    @if(session("mensaje"))
        <div style="background-color: moccasin;">
            {{ session("mensaje") }}
        </div>
    @endif
    {{ $alumnos->links('pagination::bootstrap-5') }}
@endsection