<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\TutorInstituto;
use App\Rules\MovilValido;

class AlumnoController extends Controller
{
    public function listar(){
        $alumnos = Alumno::paginate(env("PAG"));
        $page = "Alumnos";
        return view("alumnos", compact("alumnos", "page"));
    }

    public function crear(){
        $tutores = TutorInstituto::all();
        $page = "Crear alumno";
        return view("alumnoCrear", compact("tutores","page"));
    }

    public function guardar(Request $datosFormulario){
        $datosFormulario->validate([
            "nombre" => "required|min:2|max:255",
            "apellidos" => "required|min:2|max:255",
            "NIF" => "required|min:9|max:9|unique:alumnos",
            "NUSS" => "required|min:12|max:12|unique:alumnos",
            "email" => "required|unique:alumnos",
            "movil" => ["required", new MovilValido],
            "fecha_nacimiento" => "required",
            "tutoresinstituto_id" => "required"
        ]);

        Alumno::create($datosFormulario->all());
        return redirect()->route("alumnos")->with("mensaje", "Alumno creado correctamente");
    }

    public function editar($id){
        $alumno = Alumno::find($id);
        $tutores = TutorInstituto::all();
        $page = "Editar alumno";
        return view("alumnoEditar", compact("alumno", "tutores", "page"));
    }

    public function actualizar(Request $datosFormulario, $id){
        $datosFormulario->validate([
            "nombre" => "required|min:2|max:255",
            "apellidos" => "required|min:2|max:255",
            "NIF" => "required|min:9|max:9|unique:alumnos,NIF," . $id ,
            "NUSS" => "required|min:12|max:12|unique:alumnos,NUSS," . $id ,
            "email" => "required|unique:alumnos,email," . $id ,
            "movil" => ["required", new MovilValido],
            "fecha_nacimiento" => "required",
            "tutoresinstituto_id" => "required"
        ]);

        $alumno = Alumno::find($id);
        $alumno->update($datosFormulario->all());

        return redirect()->route("alumnos")->with("mensaje", "Alumno actualizado correctamente");
    }

    public function eliminar($id){
        Alumno::find($id)->delete();
        return redirect()->route("alumnos")->with("mensaje", "Alumno eliminado correctamente");
    }

    public function detalle($id)
    {
        $alumno = Alumno::with('tutoresEmpresas.empresa')->findOrFail($id);
        $page = "Detalle del alumno";
        return view('alumnoDetalle', compact('alumno', "page"));
    }



}
