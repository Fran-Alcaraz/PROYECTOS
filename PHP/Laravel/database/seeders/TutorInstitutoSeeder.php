<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TutorInstituto;

class TutorInstitutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TutorInstituto::create([
            "id" => 1,
            "nombre" => "Juan",
            "apellidos" => "Pérez Gómez",
            "email" => "juan.perez@instituto.com"
        ]);

        TutorInstituto::create([
            "id" => 2,
            "nombre" => "María",
            "apellidos" => "Fernández López",
            "email" => "maria.fernandez@instituto.com"
        ]);

        TutorInstituto::create([
            "id" => 3,
            "nombre" => "Antonio",
            "apellidos" => "Ruiz Martínez",
            "email" => "antonio.ruiz@instituto.com"
        ]);
    }
}
