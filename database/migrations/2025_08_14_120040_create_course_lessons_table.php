<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_lessons', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('module_id')->constrained('course_modules')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->enum('content_type', ['text','video','audio','document','presentation','interactive','external'])->default('text');
            $table->string('content_url', 500)->nullable();
            $table->json('content_metadata')->nullable();
            $table->integer('estimated_duration')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_required')->default(true);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_preview')->default(false);
            $table->json('unlock_conditions')->nullable();
            $table->json('completion_criteria')->nullable();
            $table->json('resources')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('module_id', 'idx_course_lessons_module_id');
            $table->index('content_type', 'idx_course_lessons_content_type');
            $table->index('sort_order', 'idx_course_lessons_sort_order');
            $table->index('is_preview', 'idx_course_lessons_is_preview');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_lessons');
    }
};
