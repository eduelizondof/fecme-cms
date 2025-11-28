<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('short_description')->nullable();
            $table->string('main_image')->nullable();
            $table->date('date')->nullable();
            $table->string('author')->nullable();
            $table->string('author_url')->nullable();
            $table->json('tags')->nullable();
            $table->string('tags_url')->nullable();
            $table->text('excerpt')->nullable();
            $table->json('content')->nullable();
            $table->json('related_posts')->nullable();
            $table->json('gallery')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};

