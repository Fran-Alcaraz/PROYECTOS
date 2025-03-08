<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlumnoTutorEmpresa;
use App\Models\Alumno;
use App\Models\TutorEmpresa;
use App\Rules\PeriodoNoSolapado;

class AlumnoTutorEmpresaController extends Controller
{
    public function crear(){
        $alumnos = Alumno::all();
        $tutores = TutorEmpresa::all();
        $page = "Asignar prácticas";
        return view("asignacionCrear", compact("alumnos", "tutores", "page"));
    }

    public function guardar(Request $datosFormulario){
        $datosFormulario->validate([
            "alumno_id" => "required",
            "tutorempresa_id" => "required",
            "fecha_inicio" => "required|after_or_equal:today",
            "fecha_fin" => "required|after:fecha_inicio"
        ]);

        AlumnoTutorEmpresa::create($datosFormulario->all());
        return redirect()->route("alumnos")->with("mensaje", "Tutor de empresa asignado correctamente");
    }


}
