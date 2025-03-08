<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Alumno;
use App\Models\TutorInstituto;

class AlumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Alumno::create([
            "id" => 1,
            "nombre" => "Carlos",
            "apellidos" => "López Fernández",
            "NIF" => "12345678A",
            "NUSS" => "123456789012",
            "email" => "carlos.lopez@alumno.com",
            "movil" => "600123456",
            "fecha_nacimiento" => "2005-06-15",
            "tutoresinstituto_id" => 1
        ]);

        Alumno::create([
            "id" => 2,
            "nombre" => "David",
            "apellidos" => "Martínez Rodríguez",
            "NIF" => "87654321B",
            "NUSS" => "987654321098",
            "email" => "david.martinez@alumno.com",
            "movil" => "600654321",
            "fecha_nacimiento" => "2004-07-21",
            "tutoresinstituto_id" => 2
        ]);

        Alumno::create([
            "id" => 3,
            "nombre" => "Elena",
            "apellidos" => "Torres López",
            "NIF" => "56781234C",
            "NUSS" => "567812349876",
            "email" => "elena.torres@alumno.com",
            "movil" => "600987654",
            "fecha_nacimiento" => "2003-11-30",
            "tutoresinstituto_id" => 3
        ]);
    }
}
