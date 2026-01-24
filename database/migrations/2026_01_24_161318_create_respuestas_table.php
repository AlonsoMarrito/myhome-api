<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pregunta')->constrained('preguntas');
            $table->foreignId('id_asistente')->constrained('asistencia');
            $table->string('respuesta');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('respuestas');
    }
};
