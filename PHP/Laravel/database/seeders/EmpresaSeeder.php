<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Empresa;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Empresa::create([
            "id" => 1,
            "nombre" => "Tech Solutions",
            "localidad" => "Madrid"
        ]);

        Empresa::create([
            "id" => 2,
            "nombre" => "Soft Innovations",
            "localidad" => "Barcelona"
        ]);

        Empresa::create([
            "id" => 3,
            "nombre" => "DataCorp",
            "localidad" => "Valencia"
        ]);
    }
}
