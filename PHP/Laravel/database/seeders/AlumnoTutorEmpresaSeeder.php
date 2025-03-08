<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Alumno;
use App\Models\TutorEmpresa;

class AlumnoTutorEmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Alumno::find(1)->tutoresEmpresa()->attach(1, [
            "fecha_inicio" => "2024-02-01",
            "fecha_fin" => "2024-06-30"
        ]);

        Alumno::find(2)->tutoresEmpresa()->attach(2, [
            "fecha_inicio" => "2024-03-01",
            "fecha_fin" => "2024-07-30"
        ]);

        Alumno::find(3)->tutoresEmpresa()->attach(3, [
            "fecha_inicio" => "2024-04-01",
            "fecha_fin" => "2024-08-30"
        ]);
    }
}
