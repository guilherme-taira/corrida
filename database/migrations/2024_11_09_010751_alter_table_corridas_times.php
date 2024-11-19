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
        Schema::table('corridas', function (Blueprint $table) {
            $table->boolean('exibir_tempo_liquido')->default(false);
            $table->boolean('exibir_gap')->default(false);
            $table->boolean('exibir_tempo_bruto')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('corridas', function (Blueprint $table) {
            $table->dropColumn(['exibir_tempo_liquido', 'exibir_gap', 'exibir_tempo_bruto']);
        });
    }
};
