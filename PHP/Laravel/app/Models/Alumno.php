<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alumno extends Model
{
    use HasFactory;

    protected $table = "alumnos";

    protected $fillable = ["nombre", "apellidos", "NIF", "NUSS", "email", "movil", "fecha_nacimiento", "tutoresinstituto_id"];

    public function tutorInstituto(){
        return $this->belongsTo(TutorInstituto::class, "tutoresinstituto_id");
    }

    public function tutoresEmpresas()
    {
        return $this->belongsToMany(TutorEmpresa::class, 'alumno_tutoresempresa', 'alumno_id', 'tutorempresa_id')
                    ->withPivot('fecha_inicio', 'fecha_fin')
                    ->withTimestamps();
    }
}
