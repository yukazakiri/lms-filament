<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_activities', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('lesson_id')->nullable()->constrained('course_lessons')->cascadeOnDelete();
            $table->foreignId('module_id')->nullable()->constrained('course_modules')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('instructions')->nullable();
            $table->enum('activity_type', ['quiz','assignment','discussion','survey','scorm','xapi','external']);
            $table->json('activity_data')->nullable();
            $table->integer('max_attempts')->default(1);
            $table->integer('time_limit')->nullable();
            $table->decimal('passing_score', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->default(1.00);
            $table->boolean('is_graded')->default(false);
            $table->boolean('is_required')->default(true);
            $table->boolean('is_active')->default(true);
            $table->json('unlock_conditions')->nullable();
            $table->json('completion_criteria')->nullable();
            $table->json('feedback_settings')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamp('due_date')->nullable();
            $table->timestamp('available_from')->nullable();
            $table->timestamp('available_until')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('lesson_id', 'idx_course_activities_lesson_id');
            $table->index('module_id', 'idx_course_activities_module_id');
            $table->index('course_id', 'idx_course_activities_course_id');
            $table->index('activity_type', 'idx_course_activities_type');
            $table->index('due_date', 'idx_course_activities_due_date');
            $table->index('sort_order', 'idx_course_activities_sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_activities');
    }
};
