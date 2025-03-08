<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("alumno_tutoresempresa", function(Blueprint $table){
            $table->id();
            $table->foreignId("alumno_id")->constrained("alumnos")->onDelete("cascade");
            $table->foreignId("tutorempresa_id")->constrained("tutoresempresas")->onDelete("cascade");
            $table->date("fecha_inicio");
            $table->date("fecha_fin");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("alumno_tutoresempresa");
    }
};
