<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empresa extends Model
{
    use HasFactory;

    protected $table = "empresas";

    protected $fillable = ["nombre", "localidad"];

    public function tutoresEmpresa(){
        return $this->hasMany(TutorEmpresa::class, "empresa_id");
    }
}
