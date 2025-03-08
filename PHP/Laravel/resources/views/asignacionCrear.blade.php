@extends("layout.plantillafct")

@section("title", "Asignar Prácticas")

@section("content")
    <form action="{{ route('asignaciones.guardar') }}" method="POST">
        @csrf

        &nbsp;
        <label>Alumno:</label>
        <select name="alumno_id">
            <option value="">--Seleccione un alumno--</option>
            @foreach($alumnos as $alumno)
                <option value="{{ $alumno->id }}" {{ old("alumno_id") == $alumno->id ? "selected" : "" }}>{{ $alumno->nombre }} {{ $alumno->apellidos }}</option>
            @endforeach
        </select>
        @error("alumno_id")
            <div style="color:red">
                &nbsp;&nbsp;{{ $message }}
            </div>
        @enderror

        &nbsp;
        <label>Tutor de Empresa:</label>
        <select name="tutorempresa_id">
            <option value="">--Seleccione un tutor de empresa--</option>
            @foreach($tutores as $tutor)
                <option value="{{ $tutor->id }}" {{ old("tutorempresa_id") == $tutor->id ? "selected" : "" }}>{{ $tutor->nombre }} {{ $tutor->apellidos }}</option>
            @endforeach
        </select>
        @error("tutorempresa_id")
            <div style="color:red">
                &nbsp;&nbsp;{{ $message }}
            </div>
        @enderror

        &nbsp;
        <label>Fecha de Inicio:</label>
        <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio') }}">
        @error("fecha_inicio")
            <div style="color:red">
                &nbsp;&nbsp;{{ $message }}
            </div>
        @enderror

        &nbsp;
        <label>Fecha de Fin:</label>
        <input type="date" name="fecha_fin" value="{{ old('fecha_fin') }}">
        @error("fecha_fin")
            <div style="color:red">
                &nbsp;&nbsp;{{ $message }}
            </div>
        @enderror

        &nbsp;
        <button type="submit">Asignar</button>
    </form>
@endsection