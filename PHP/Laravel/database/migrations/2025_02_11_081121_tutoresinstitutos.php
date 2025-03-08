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
        Schema::create("tutoresinstitutos", function(Blueprint $table){
            $table->id();
            $table->string("nombre", 255);
            $table->string("apellidos", 255)->nullable();
            $table->string("email", 255)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("tutoresinstitutos");
    }
};
