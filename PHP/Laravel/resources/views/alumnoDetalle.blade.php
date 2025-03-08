@extends("layout.plantillafct")

@section("title", "Detalle del Alumno")

@section("content")
    <h2>{{ $alumno->nombre }} {{ $alumno->apellidos }}</h2>
    <p><strong>NIF:</strong> {{ $alumno->NIF }}</p>
    <p><strong>NUSS:</strong> {{ $alumno->NUSS }}</p>
    <p><strong>Correo:</strong> {{ $alumno->email }}</p>
    <p><strong>Móvil:</strong> {{ $alumno->movil }}</p>
    <p><strong>Fecha de nacimiento:</strong> {{ $alumno->fecha_nacimiento }}</p>
    <p><strong>Tutor de instituto:</strong> {{ $alumno->tutorInstituto->nombre }}</p>

    <h3>Empresas donde ha realizado prácticas</h3>
    <ul>
        @foreach($alumno->tutoresEmpresas as $tutorEmpresa)
            <li>
                <strong>Empresa:</strong> {{ $tutorEmpresa->empresa->nombre }} - {{ $tutorEmpresa->empresa->localidad }}<br>
                <strong>Fechas:</strong> {{ $tutorEmpresa->pivot->fecha_inicio }} a {{ $tutorEmpresa->pivot->fecha_fin }}
            </li><br>
        @endforeach
    </ul>
@endsection