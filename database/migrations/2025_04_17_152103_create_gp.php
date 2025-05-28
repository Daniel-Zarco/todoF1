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
        Schema::create('z_gp', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('circuito');
            $table->string('pais');
            $table->date('fecha');
            $table->year('temporada');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('z_gp');
    }
};
