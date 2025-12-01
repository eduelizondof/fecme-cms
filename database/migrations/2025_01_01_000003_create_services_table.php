<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('type')->nullable(); // tramite, servicio
            $table->text('short_description')->nullable();
            $table->string('main_image')->nullable();
            $table->string('image')->nullable();
            $table->boolean('show_in_services')->default(true);
            $table->boolean('show_in_pricing')->default(false);
            $table->string('pricing_category')->nullable();
            $table->json('pricing_features')->nullable();
            $table->text('description')->nullable();
            $table->json('featured')->nullable();
            $table->json('gallery')->nullable();
            $table->json('requirements')->nullable();
            $table->json('cost')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};



