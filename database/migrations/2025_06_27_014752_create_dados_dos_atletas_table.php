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
          Schema::create('dados_dos_atletas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('distancia');
            $table->date('data_nascimento');
            $table->enum('sexo', ['M', 'F']);
            $table->string('equipe')->nullable();
            $table->foreignId('corrida_id')->nullable()->constrained('corridas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dados_dos_atletas');
    }
};
