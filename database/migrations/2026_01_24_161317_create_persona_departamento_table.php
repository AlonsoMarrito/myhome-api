<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('persona_departamento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_persona')->constrained('personas');
            $table->foreignId('id_rol')->constrained('roles');
            $table->foreignId('id_depa')->constrained('departamentos');
            $table->boolean('residente');
            $table->string('codigo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persona_departamento');
    }
};
