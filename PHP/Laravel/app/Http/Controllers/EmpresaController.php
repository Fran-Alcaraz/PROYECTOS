<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function listar(){
        $empresas = Empresa::paginate(env("PAG"));
        $page = "Empresas";
        return view("empresas", compact("empresas", "page"));
    }

    public function crear(){
        $page = "Crear empresa";
        return view("empresaCrear", compact("page"));
    }

    public function guardar(Request $datosFormulario){
        $datosFormulario->validate([
            "nombre" => "required|min:2|max:255|unique:empresas",
            "localidad" => "max:255"
        ]);

        Empresa::create($datosFormulario->all());
        return redirect()->route("empresas")->with("mensaje", "Empresa creada correctamente");
    }

    public function editar($id){
        $empresa = Empresa::find($id);
        $page = "Editar empresa";
        return view("empresaEditar", compact("empresa", "page"));
    }

    public function actualizar(Request $datosFormulario, $id){
        $datosFormulario->validate([
            "nombre" => "required|min:2|max:255|unique:empresas,nombre," . $id,
            "localidad" => "max:255",
        ]);

        $empresa = Empresa::find($id);
        $empresa->update($datosFormulario->all());

        return redirect()->route("empresas")->with("mensaje", "Empresa actualizada correctamente");
    }

    public function eliminar($id){
        Empresa::find($id)->delete();
        return redirect()->route("empresas")->with("mensaje", "Empresa eliminada correctamente");
    }

    public function detalle($id){
        $empresa = Empresa::find($id);
        $page = "Detalle de la empresa";
        return view("empresaDetalle", compact("empresa", "page"));
    }


}
