<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\AlumnoTutorEmpresaController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TutorEmpresaController;
use App\Http\Controllers\TutorInstitutoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get("/alumnos", [AlumnoController::class, "listar"])->name("alumnos")->middleware('auth');
Route::get("/alumnos/crear", [AlumnoController::class, "crear"])->name("alumnos.crear")->middleware('auth');
Route::post("/alumnos/guardar", [AlumnoController::class, "guardar"])->name("alumnos.guardar");
Route::get("/alumnos/editar/{id}", [AlumnoController::class, "editar"])->name("alumnos.editar")->middleware('auth');
Route::put("/alumnos/actualizar/{id}", [AlumnoController::class, "actualizar"])->name("alumnos.actualizar");
Route::delete("/alumnos/eliminar/{id}", [AlumnoController::class, "eliminar"])->name("alumnos.eliminar");

Route::get("/asignaciones/crear", [AlumnoTutorEmpresaController::class, "crear"])->name("asignaciones.crear")->middleware('auth');
Route::post("/asignaciones/guardar", [AlumnoTutorEmpresaController::class, "guardar"])->name("asignaciones.guardar");

Route::get("/tutoresInstituto", [TutorInstitutoController::class, "listar"])->name("tutoresInstituto")->middleware('auth');
Route::get("/tutoresInstituto/crear", [TutorInstitutoController::class, "crear"])->name("tutoresInstituto.crear")->middleware('auth');
Route::post("/tutoresInstituto/guardar", [TutorInstitutoController::class, "guardar"])->name("tutoresInstituto.guardar");
Route::get("/tutoresInstituto/editar/{id}", [TutorInstitutoController::class, "editar"])->name("tutoresInstituto.editar")->middleware('auth');
Route::put("/tutoresInstituto/actualizar/{id}", [TutorInstitutoController::class, "actualizar"])->name("tutoresInstituto.actualizar");
Route::delete("/tutoresInstituto/eliminar/{id}", [TutorInstitutoController::class, "eliminar"])->name("tutoresInstituto.eliminar");

Route::get("/empresas", [EmpresaController::class, "listar"])->name("empresas")->middleware('auth');
Route::get("/empresas/crear", [EmpresaController::class, "crear"])->name("empresas.crear")->middleware('auth');
Route::post("/empresas/guardar", [EmpresaController::class, "guardar"])->name("empresas.guardar");
Route::get("/empresas/editar/{id}", [EmpresaController::class, "editar"])->name("empresas.editar")->middleware('auth');
Route::put("/empresas/actualizar/{id}", [EmpresaController::class, "actualizar"])->name("empresas.actualizar");
Route::delete("/empresas/eliminar/{id}", [EmpresaController::class, "eliminar"])->name("empresas.eliminar");

Route::get('/alumnos/{id}', [AlumnoController::class, 'detalle'])->name('alumnos.detalle')->middleware('auth');

Route::get("/tutoresEmpresas", [TutorEmpresaController::class, "listar"])->name("tutoresEmpresas")->middleware('auth');
Route::get("/tutoresEmpresa/crear", [TutorEmpresaController::class, "crear"])->name("tutoresEmpresa.crear")->middleware('auth');
Route::post("/tutoresEmpresa/guardar", [TutorEmpresaController::class, "guardar"])->name("tutoresEmpresa.guardar");
Route::get("/tutoresEmpresa/editar/{id}", [TutorEmpresaController::class, "editar"])->name("tutoresEmpresa.editar")->middleware('auth');
Route::put("/tutoresEmpresa/actualizar/{id}", [TutorEmpresaController::class, "actualizar"])->name("tutoresEmpresa.actualizar");
Route::delete("/tutoresEmpresa/eliminar/{id}", [TutorEmpresaController::class, "eliminar"])->name("tutoresEmpresa.eliminar");

Route::get("/empresas/{id}", [EmpresaController::class, "detalle"])->name("empresas.detalle")->middleware('auth');

require __DIR__.'/auth.php';
