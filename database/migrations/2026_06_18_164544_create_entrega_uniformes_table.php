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
       Schema::create('entrega_uniformes', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('corrida_id');
        $table->string('cpf');
        $table->timestamp('entregue_em')->nullable();
        $table->timestamps();
        $table->unique(['corrida_id', 'cpf']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrega_uniformes');
    }
};
