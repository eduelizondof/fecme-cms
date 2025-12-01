<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('features_area_content_id')->constrained('features_area_content')->onDelete('cascade');
            $table->string('icon_class', 100);
            $table->string('title');
            $table->string('description');
            $table->string('link', 500)->nullable();
            $table->boolean('is_external')->default(false);
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_info');
    }
};

