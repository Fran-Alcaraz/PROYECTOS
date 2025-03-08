@extends("layout.plantillafct")

@section("title", "Editar Alumno")

@section("content")
    <div style="margin-left: 10px;">
        <form action="{{ route('alumnos.actualizar', $alumno->id) }}" method="POST">
            @csrf
            @method("PUT")

            <label>Nombre:</label>
            <input type="text" name="nombre" value="{{ old('nombre', $alumno->nombre) }}">
            @error("nombre")
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror
            <br><br>

            <label>Apellidos:</label>
            <input type="text" name="apellidos" value="{{ old('apellidos', $alumno->apellidos) }}">
            @error("apellidos")
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror
            <br><br>

            <label>NIF:</label>
            <input type="text" name="NIF" value="{{ old('NIF', $alumno->NIF) }}">
            @error("NIF")
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror
            <br><br>

            <label>NUSS:</label>
            <input type="text" name="NUSS" value="{{ old('NUSS', $alumno->NUSS) }}">
            @error("NUSS")
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror
            <br><br>

            <label>Correo:</label>
            <input type="email" name="email" value="{{ old('email', $alumno->email) }}">
            @error("email")
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror
            <br><br>

            <label>Móvil:</label>
            <input type="text" name="movil" value="{{ old('movil', $alumno->movil) }}">
            @error("movil")
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror
            <br><br>

            <label>Fecha de Nacimiento:</label>
            <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $alumno->fecha_nacimiento) }}">
            @error("fecha_nacimiento")
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror
            <br><br>

            <label>Tutor Instituto:</label>
            <select name="tutoresinstituto_id">
                @foreach($tutores as $tutor)
                    <option value="{{ $tutor->id }}" {{ old("tutoresinstituto_id", $alumno->tutoresinstituto_id) == $tutor->id ? "selected" : "" }}>
                        {{ $tutor->nombre }}
                    </option>
                @endforeach
            </select>
            @error("tutoresinstituto_id")
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror
            <br><br>

            <button type="submit">Actualizar</button>
        </form>
    </div>
@endsection