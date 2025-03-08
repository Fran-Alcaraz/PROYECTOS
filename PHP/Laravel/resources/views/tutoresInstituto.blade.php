@extends("layout.plantillafct")

@section("title", "Lista de Tutores de Instituto")

@section("content")
    <div>
        <a href="{{ route('tutoresInstituto.crear') }}" class="btn btn-verde">Nuevo Tutor de Instituto</a>
    </div>

    @forelse($tutoresInstituto as $tutor)
        @component("components.tarjeta")
            @slot("cabecera")
                <h4>{{ $tutor->nombre }} {{ $tutor->apellidos }}</h4>
            @endslot

            @slot("cuerpo")
                <p><strong>Correo:</strong> {{ $tutor->email }}</p>
                <strong>Alumnos que tutoriza:</strong><br>
                    @forelse($tutor->alumnos as $alumno)
                            <a href="{{ route('alumnos.detalle', $alumno->id) }}">
                                {{ $alumno->nombre }} {{ $alumno->apellidos }}
                            </a>
                    @empty
                        No tiene alumnos asignados.
                    @endforelse
            @endslot

            @slot("footer")
                <br>
                <a href="{{ route('tutoresInstituto.editar', $tutor->id) }}" class="btn btn-amarillo">Editar</a>
                <form action="{{ route('tutoresInstituto.eliminar', $tutor->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method("DELETE")
                    <button type="submit" class="btn btn-rojo">Eliminar</button>
                </form>
            @endslot
        @endcomponent
    @empty
        <p>No hay tutores de instituto registrados</p>
    @endforelse

    @if(session("mensaje"))
        <div style="background-color: moccasin;">
            {{ session("mensaje") }}
        </div>
    @endif
    {{ $tutoresInstituto->links('pagination::bootstrap-5') }}
@endsection