<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_modules', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('course_version_id')->nullable()->constrained('course_versions')->cascadeOnDelete();
            $table->unsignedBigInteger('parent_module_id')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('objectives')->nullable();
            $table->integer('estimated_duration')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_required')->default(true);
            $table->boolean('is_active')->default(true);
            $table->json('unlock_conditions')->nullable();
            $table->json('completion_criteria')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parent_module_id')->references('id')->on('course_modules')->cascadeOnDelete();
            $table->index('course_id', 'idx_course_modules_course_id');
            $table->index('course_version_id', 'idx_course_modules_course_version_id');
            $table->index('parent_module_id', 'idx_course_modules_parent_module_id');
            $table->index('sort_order', 'idx_course_modules_sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_modules');
    }
};
