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
        Schema::table('site_settings', function (Blueprint $table) {
            // Eliminar el índice único de 'key'
            $table->dropUnique(['key']);
            // Crear un índice único compuesto de 'key' + 'group'
            $table->unique(['key', 'group']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            // Eliminar el índice único compuesto
            $table->dropUnique(['key', 'group']);
            // Restaurar el índice único solo en 'key'
            $table->unique('key');
        });
    }
};
