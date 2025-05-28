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
        Schema::create('z_stats_carrera', function (Blueprint $table) {
            $table->id();
            $table->foreignId('piloto_id')->constrained('z_pilotos')->onDelete('cascade');
            $table->foreignId('escuderia_id')->constrained('z_escuderias')->onDelete('cascade');
            $table->foreignId('gran_premio_id')->constrained('z_gp')->onDelete('cascade');
            $table->integer('posicion')->nullable();
            $table->string('tiempo_total')->nullable();
            $table->integer('puntos')->nullable();
            $table->boolean('vuelta_rapida')->default(false);
            $table->boolean('pole_position')->default(false);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('z_stats_carrera');
    }
};
