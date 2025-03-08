<?php

namespace App\Rules;

use App\Models\AlumnoTutorEmpresa;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PeriodoNoSolapado implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $fecha_inicio = request()->input('fecha_inicio');
        $fecha_fin = request()->input('fecha_fin');
        $alumno_id = request()->input('alumno_id');

        $periodosSolapados = AlumnoTutorEmpresa::where('alumno_id', $alumno_id)
            ->where(function ($query) use ($fecha_inicio, $fecha_fin) {
                $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])
                    ->orWhereBetween('fecha_fin', [$fecha_inicio, $fecha_fin])
                    ->orWhere(function ($query) use ($fecha_inicio, $fecha_fin) {
                        $query->where('fecha_inicio', '<=', $fecha_inicio)
                              ->where('fecha_fin', '>=', $fecha_fin);
                    });
            })
            ->exists();

        if ($periodosSolapados) {
            $fail('El periodo seleccionado se solapa con otro periodo del mismo alumno.');
        }
    }
}
