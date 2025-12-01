<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('features_area_content', function (Blueprint $table) {
            $table->id();
            $table->string('working_hours_background')->nullable();
            $table->string('working_hours_title')->default('Horario');
            $table->string('working_hours_description')->nullable();
            $table->boolean('is_open_now')->default(true);
            $table->string('subtitle')->default('Contacto');
            $table->string('title')->default('Información de Contacto');
            $table->text('description')->nullable();
            $table->string('slogan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('features_area_content');
    }
};

