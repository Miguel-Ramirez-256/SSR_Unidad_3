<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Título del curso
            $table->string('instructor'); // Nombre del instructor o creador del curso
            $table->text('description')->nullable(); // Descripción opcional
            $table->string('video_url')->nullable(); // URL del video (YouTube, etc.)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relación con el usuario creador
            $table->timestamps(); // created_at y updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
