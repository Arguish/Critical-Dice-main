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
        Schema::create('characters', function (Blueprint $table) {
            // Columna ID autoincrementable (Primary Key)
            $table->id();

            // Relación con el usuario
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Sistema de juego (D&D, Pathfinder, etc.)
            $table->string('system');

            // Información del Jugador
            $table->string('player_name');

            // Información del Personaje
            $table->string('character_name');
            $table->string('race');
            $table->string('class');
            $table->string('background');

            // Stats principales (INT porque son números)
            $table->integer('strength');
            $table->integer('dexterity');
            $table->integer('constitution');
            $table->integer('intelligence');
            $table->integer('wisdom');
            $table->integer('charisma');

            // Modificadores aplicados
            $table->string('applied_modifiers')->nullable(); // Puede ser null si no hay

            // Timestamps automáticos: created_at y updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
