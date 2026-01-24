<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('preguntas', function (Blueprint $table) {
            $table->id();
            $table->string('pregunta');
            $table->foreignId('id_evento')->constrained('eventos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('preguntas');
    }
};
