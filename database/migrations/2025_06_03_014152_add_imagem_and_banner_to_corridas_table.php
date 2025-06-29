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
        $table->string('imagem')->nullable()->after('name'); // imagem do card
        $table->string('banner')->nullable()->after('imagem'); // banner do evento
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('corridas', function (Blueprint $table) {
        $table->dropColumn(['imagem', 'banner']);
    });
 }
};
