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
            $table->json('atletas')->nullable(); // ou após outro campo se preferir
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('corridas', function (Blueprint $table) {
            $table->dropColumn('atletas');
        });
    }
};
