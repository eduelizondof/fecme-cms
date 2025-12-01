<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_content', function (Blueprint $table) {
            $table->id();
            $table->string('background_image')->nullable();
            $table->string('main_image')->nullable();
            $table->string('main_image_alt')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('experience_from')->default(400);
            $table->integer('experience_to')->default(416);
            $table->integer('experience_speed')->default(5000);
            $table->integer('experience_initial_value')->default(416);
            $table->string('experience_label')->default('+e Razas');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_content');
    }
};

