<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('asistencia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_persona')->constrained('personas');
            $table->foreignId('id_evento')->constrained('eventos');
            $table->time('hora');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencia');
    }
};
