<?php

namespace App\Http\Controllers;

use App\Models\TutorInstituto;
use Illuminate\Http\Request;

class TutorInstitutoController extends Controller
{
    public function listar(){
        $tutoresInstituto = TutorInstituto::paginate(env("PAG"));
        $page = "Tutores de Instituto";
        return view("tutoresInstituto", compact("tutoresInstituto", "page"));
    }

    public function crear(){
        $page = "Crear tutor de instituto";
        return view("tutorInstitutoCrear", compact("page"));
    }

    public function guardar(Request $datosFormulario){
        $datosFormulario->validate([
            "nombre" => "required|min:2|max:255",
            "apellidos" => "max:255",
            "email" => "required|unique:alumnos"
        ]);

        TutorInstituto::create($datosFormulario->all());
        return redirect()->route("tutoresInstituto")->with("mensaje", "Tutor de instituto creado correctamente");
    }

    public function editar($id){
        $tutor = TutorInstituto::find($id);
        $page = "Editar tutor de instituto";
        return view("tutorInstitutoEditar", compact("tutor", "page"));
    }

    public function actualizar(Request $datosFormulario, $id){
        $datosFormulario->validate([
            "nombre" => "required|min:2|max:255",
            "apellidos" => "max:255",
            "email" => "required|unique:tutoresinstitutos,email," . $id
        ]);

        $tutor = TutorInstituto::find($id);
        $tutor->update($datosFormulario->all());

        return redirect()->route("tutoresInstituto")->with("mensaje", "Tutor de instituto actualizado correctamente");
    }

    public function eliminar($id){
        TutorInstituto::find($id)->delete();
        return redirect()->route("tutoresInstituto")->with("mensaje", "Tutor de instituto eliminado correctamente");
    }


}
