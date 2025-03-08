@extends("layout.plantillafct")

@section("title", "Crear Alumno")

@section("content")
    <div style="margin-left: 10px;">
        <form action="{{ route('alumnos.guardar') }}" method="POST">
            @csrf

            <label>Nombre:</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}">
            @error("nombre")
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror
            <br><br>

            <label>Apellidos:</label>
            <input type="text" name="apellidos" value="{{ old('apellidos') }}">
            @error("apellidos")
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror
            <br><br>

            <label>NIF:</label>
            <input type="text" name="NIF" value="{{ old('NIF') }}">
            @error("NIF")
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror
            <br><br>

            <label>NUSS:</label>
            <input type="text" name="NUSS" value="{{ old('NUSS') }}">
            @error("NUSS")
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror
            <br><br>

            <label>Correo:</label>
            <input type="email" name="email" value="{{ old('email') }}">
            @error("email")
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror
            <br><br>

            <label>Móvil:</label>
            <input type="text" name="movil" value="{{ old('movil') }}">
            @error("movil")
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror
            <br><br>

            <label>Fecha de Nacimiento:</label>
            <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}">
            @error("fecha_nacimiento")
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror
            <br><br>

            <label>Tutor Instituto:</label>
            <select name="tutoresinstituto_id">
                <option value="">--Seleccione un tutor--</option>
                @foreach($tutores as $tutor)
                    <option value="{{ $tutor->id }}" {{ old("tutoresinstituto_id") == $tutor->id ? "selected" : "" }}>{{ $tutor->nombre }}</option>
                @endforeach
            </select>
            @error("tutoresinstituto_id")
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror
            <br><br>

            <button type="submit">Guardar</button>
        </form>
    </div>
@endsection