<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AlumnoTutorEmpresa extends Model
{
    use HasFactory;

    protected $table = "alumno_tutoresempresa";

    protected $fillable = ["alumno_id", "tutorempresa_id", "fecha_inicio", "fecha_fin"];
}
