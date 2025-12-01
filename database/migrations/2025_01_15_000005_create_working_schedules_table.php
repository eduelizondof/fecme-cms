<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('working_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('features_area_content_id')->constrained('features_area_content')->onDelete('cascade');
            $table->string('day', 20);
            $table->string('hours', 100);
            $table->boolean('is_holiday')->default(false);
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('working_schedules');
    }
};

