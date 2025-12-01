<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('feature_image')->nullable();
            $table->json('programs_list')->nullable();
            $table->json('location')->nullable();
            $table->string('member_since')->nullable();
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('total_reviews')->default(0);
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->json('social_links')->nullable();
            $table->json('certifications')->nullable();
            $table->json('features')->nullable();
            $table->json('responsible')->nullable();
            $table->json('about')->nullable();
            $table->json('programs')->nullable();
            $table->json('facilities')->nullable();
            $table->json('awards')->nullable();
            $table->json('gallery')->nullable();
            $table->json('reviews')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};


