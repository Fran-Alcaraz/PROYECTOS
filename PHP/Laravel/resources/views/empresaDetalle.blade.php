@extends("layout.plantillafct")

@section("title", "Detalle de la Empresa")

@section("content")
    <h2>{{ $empresa->nombre }}</h2>
    <p><strong>Localidad:</strong> {{ $empresa->localidad }}</p>

    <h3>Tutores de la Empresa</h3>
    @forelse($empresa->tutoresEmpresa as $tutor)
        <div style="border: 1px solid gray; padding: 10px; margin-bottom: 10px;">
            <h4>{{ $tutor->nombre }} {{ $tutor->apellidos }}</h4>
            <p><strong>Correo:</strong> {{ $tutor->email }}</p>

            <h4>Alumnos Tutorizados</h4>
            <ul>
                @forelse($tutor->alumnos as $alumno)
                    <li>{{ $alumno->nombre }} {{ $alumno->apellidos }} ({{ $alumno->pivot->fecha_inicio }} - {{ $alumno->pivot->fecha_fin }})</li>
                @empty
                    <li>No tiene alumnos asignados.</li>
                @endforelse
            </ul>
        </div>
    @empty
        <p>No hay tutores en esta empresa.</p>
    @endforelse
@endsection