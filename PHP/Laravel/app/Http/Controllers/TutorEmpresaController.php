<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TutorEmpresa;
use App\Models\Empresa;

class TutorEmpresaController extends Controller
{
    public function listar(){
        $tutoresEmpresas = TutorEmpresa::paginate(env("PAG"));
        $page = "Tutores de Empresas";
        return view("tutoresEmpresas", compact("tutoresEmpresas", "page"));
    }

    public function crear(){
        $empresas = Empresa::all();
        $page = "Crear tutor de empresa";
        return view("tutorEmpresaCrear", compact("empresas","page"));
    }

    public function guardar(Request $datosFormulario){
        $datosFormulario->validate([
            "nombre" => "required|min:2|max:255",
            "apellidos" => "max:255",
            "email" => "required|unique:tutoresempresas",
            "empresa_id" => "required"
        ]);

        TutorEmpresa::create($datosFormulario->all());
        return redirect()->route("tutoresEmpresas")->with("mensaje", "Tutor de empresa creado correctamente");
    }

    public function editar($id){
        $tutor = TutorEmpresa::find($id);
        $empresas = Empresa::all();
        $page = "Editar tutor de empresa";
        return view("tutorEmpresaEditar", compact("tutor", "empresas", "page"));
    }

    public function actualizar(Request $datosFormulario, $id){
        $datosFormulario->validate([
            "nombre" => "required|min:2|max:255",
            "apellidos" => "max:255",
            "email" => "required|unique:tutoresempresas,email," . $id ,
            "empresa_id" => "required"
        ]);

        $tutor = TutorEmpresa::find($id);
        $tutor->update($datosFormulario->all());

        return redirect()->route("tutoresEmpresas")->with("mensaje", "Tutor de empresa actualizado correctamente");
    }

    public function eliminar($id){
        TutorEmpresa::find($id)->delete();
        return redirect()->route("tutoresEmpresas")->with("mensaje", "Tutor de empresa eliminado correctamente");
    }

}
