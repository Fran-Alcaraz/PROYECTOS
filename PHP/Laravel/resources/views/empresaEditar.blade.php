@extends("layout.plantillafct")

@section("title", "Editar Empresa")

@section("content")
    <div style="margin-left: 10px;">
        <form action="{{ route('empresas.actualizar', $empresa->id) }}" method="POST">
            @csrf
            @method("PUT")

            <label>Nombre:</label>
            <input type="text" name="nombre" value="{{ old('nombre', $empresa->nombre) }}">
            @error("nombre")
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror
            <br><br>

            <label>Localidad:</label>
            <input type="text" name="apellidos" value="{{ old('localidad', $empresa->localidad) }}">
            @error("localidad")
                <div style="color:red">
                    {{ $message }}
                </div>
            @enderror
            <br><br>

            <button type="submit">Actualizar</button>
        </form>
    </div>
@endsection