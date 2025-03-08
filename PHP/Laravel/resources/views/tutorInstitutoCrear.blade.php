@extends("layout.plantillafct")

@section("title", "Crear Tutor de Instituto")

@section("content")
    <div style="margin-left: 10px;">
        <form action="{{ route('tutoresInstituto.guardar') }}" method="POST">
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

            <label>Correo:</label>
            <input type="email" name="email" value="{{ old('email') }}">
            @error("email")
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror
            <br><br>

            <button type="submit">Guardar</button>
        </form>
    </div>
@endsection