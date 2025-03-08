<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TutorInstitutoSeeder::class,
            AlumnoSeeder::class,
            EmpresaSeeder::class,
            TutorEmpresaSeeder::class,
            AlumnoTutorEmpresaSeeder::class
        ]);
    }
}
