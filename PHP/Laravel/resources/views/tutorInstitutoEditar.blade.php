@extends("layout.plantillafct")

@section("title", "Editar Tutor de Instituto")

@section("content")
    <div style="margin-left: 10px;">
        <form action="{{ route('tutoresInstituto.actualizar', $tutor->id) }}" method="POST">
            @csrf
            @method("PUT")

            <label>Nombre:</label>
            <input type="text" name="nombre" value="{{ old('nombre', $tutor->nombre) }}">
            @error("nombre")
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror
            <br><br>

            <label>Apellidos:</label>
            <input type="text" name="apellidos" value="{{ old('apellidos', $tutor->apellidos) }}">
            @error("apellidos")
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror
            <br><br>

            <label>Correo:</label>
            <input type="email" name="email" value="{{ old('email', $tutor->email) }}">
            @error("email")
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror
            <br><br>

            <button type="submit">Actualizar</button>
        </form>
    </div>
@endsection