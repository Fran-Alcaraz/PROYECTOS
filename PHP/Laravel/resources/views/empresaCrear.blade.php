@extends("layout.plantillafct")

@section("title", "Crear Empresa")

@section("content")
    <div style="margin-left: 10px;">
        <form action="{{ route('empresas.guardar') }}" method="POST">
            @csrf

            <label>Nombre:</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}">
            @error("nombre")
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror
            <br><br>

            <label>Localidad:</label>
            <input type="text" name="localidad" value="{{ old('localidad') }}">
            @error("localidad")
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror
            <br><br>

            <button type="submit">Guardar</button>
        </form>
    </div>
@endsection