<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_content_id')->constrained('about_content')->onDelete('cascade');
            $table->string('icon', 100);
            $table->enum('color', ['red', 'green', 'orange', 'blues'])->default('orange');
            $table->string('label');
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_features');
    }
};

