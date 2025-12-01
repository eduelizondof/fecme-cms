<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('microchip')->unique();
            $table->string('registration_number')->unique();
            $table->string('name');
            $table->string('breed')->nullable();
            $table->string('variety')->nullable();
            $table->string('sex')->nullable();
            $table->string('color')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('image')->nullable();
            $table->boolean('valid')->default(true);
            $table->string('certificate_number')->nullable();
            $table->date('certificate_date')->nullable();
            $table->string('breeder')->nullable();
            $table->string('owner')->nullable();
            $table->string('co_owner')->nullable();
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city')->nullable();
            $table->string('phone')->nullable();
            $table->json('titles')->nullable();
            $table->text('observations')->nullable();
            $table->string('status')->default('VIGENTE');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};


