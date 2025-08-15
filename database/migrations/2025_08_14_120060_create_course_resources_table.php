<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_resources', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('module_id')->nullable()->constrained('course_modules')->cascadeOnDelete();
            $table->foreignId('lesson_id')->nullable()->constrained('course_lessons')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('resource_type', ['document','video','audio','image','link','file','tool']);
            $table->string('file_path', 500)->nullable();
            $table->string('file_url', 500)->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->string('mime_type', 100)->nullable();
            $table->boolean('is_downloadable')->default(true);
            $table->boolean('is_required')->default(false);
            $table->enum('access_level', ['public','enrolled','premium'])->default('enrolled');
            $table->integer('sort_order')->default(0);
            $table->json('metadata')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users')->restrictOnDelete();
            $table->index('course_id', 'idx_course_resources_course_id');
            $table->index('module_id', 'idx_course_resources_module_id');
            $table->index('lesson_id', 'idx_course_resources_lesson_id');
            $table->index('resource_type', 'idx_course_resources_type');
            $table->index('sort_order', 'idx_course_resources_sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_resources');
    }
};
