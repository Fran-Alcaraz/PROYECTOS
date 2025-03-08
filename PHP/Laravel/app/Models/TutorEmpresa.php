<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TutorEmpresa extends Model
{
    use HasFactory;

    protected $table = "tutoresempresas";

    protected $fillable = ["nombre", "apellidos", "email", "empresa_id"];

    public function empresa(){
        return $this->belongsTo(Empresa::class, "empresa_id");
    }

    public function alumnos(){
        return $this->belongsToMany(Alumno::class, "alumno_tutoresempresa", "tutorempresa_id", "alumno_id")
                    ->withPivot("fecha_inicio", "fecha_fin")
                    ->withTimestamps();
    }
}
