<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TutorEmpresa;
use App\Models\Empresa;

class TutorEmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TutorEmpresa::create([
            "id" => 1,
            "nombre" => "Laura",
            "apellidos" => "Martínez Ruiz",
            "email" => "laura.martinez@empresa.com",
            "empresa_id" => 1
        ]);

        TutorEmpresa::create([
            "id" => 2,
            "nombre" => "Laura",
            "apellidos" => "Gómez Pérez",
            "email" => "laura.gomez@empresa.com",
            "empresa_id" => 2
        ]);

        TutorEmpresa::create([
            "id" => 3,
            "nombre" => "Pablo",
            "apellidos" => "Fernández Sánchez",
            "email" => "pablo.fernandez@empresa.com",
            "empresa_id" => 3
        ]);
    }
}
