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
        Schema::create("alumnos", function(Blueprint $table){
            $table->id();
            $table->string("nombre", 255);
            $table->string("apellidos", 255);
            $table->string("NIF", 9)->unique();
            $table->string("NUSS", 12)->unique();
            $table->string("email", 255)->unique();
            $table->string("movil", 15);
            $table->date("fecha_nacimiento");
            $table->foreignId("tutoresinstituto_id")->constrained("tutoresinstitutos")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("alumnos");
    }
};
