<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learning_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('module_id')->nullable()->constrained('course_modules')->cascadeOnDelete();
            $table->foreignId('lesson_id')->nullable()->constrained('course_lessons')->cascadeOnDelete();
            $table->foreignId('activity_id')->nullable()->constrained('course_activities')->cascadeOnDelete();
            $table->enum('content_type', ['course','module','lesson','activity']);
            $table->unsignedBigInteger('content_id');
            $table->enum('status', ['not_started','in_progress','completed','failed','skipped'])->default('not_started');
            $table->decimal('progress_percentage', 5, 2)->default(0);
            $table->integer('time_spent')->default(0);
            $table->integer('attempts_count')->default(0);
            $table->integer('max_attempts')->nullable();
            $table->decimal('score', 5, 2)->nullable();
            $table->decimal('max_score', 5, 2)->nullable();
            $table->boolean('passed')->nullable();
            $table->timestamp('first_accessed_at')->nullable();
            $table->timestamp('last_accessed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->json('data')->nullable();
            $table->timestamps();

            $table->unique(['user_id','content_type','content_id'], 'unique_user_content_progress');
            $table->index('user_id', 'idx_progress_user_id');
            $table->index('course_id', 'idx_progress_course_id');
            $table->index(['content_type','content_id'], 'idx_progress_content');
            $table->index('status', 'idx_progress_status');
            $table->index('last_accessed_at', 'idx_progress_last_accessed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learning_progress');
    }
};
