<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TutorInstituto extends Model
{
    use HasFactory;

    protected $table = "tutoresinstitutos";

    protected $fillable = ["nombre", "apellidos", "email"];

    public function alumnos(){
        return $this->hasMany(Alumno::class, "tutoresinstituto_id");
    }
}
