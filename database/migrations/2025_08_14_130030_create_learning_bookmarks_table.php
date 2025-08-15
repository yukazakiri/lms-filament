<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learning_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('module_id')->nullable()->constrained('course_modules')->cascadeOnDelete();
            $table->foreignId('lesson_id')->nullable()->constrained('course_lessons')->cascadeOnDelete();
            $table->foreignId('activity_id')->nullable()->constrained('course_activities')->cascadeOnDelete();
            $table->enum('content_type', ['course','module','lesson','activity']);
            $table->unsignedBigInteger('content_id');
            $table->string('title')->nullable();
            $table->text('notes')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_private')->default(true);
            $table->timestamps();

            $table->unique(['user_id','content_type','content_id'], 'unique_user_content_bookmark');
            $table->index('user_id', 'idx_bookmarks_user_id');
            $table->index('course_id', 'idx_bookmarks_course_id');
            $table->index(['content_type','content_id'], 'idx_bookmarks_content');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learning_bookmarks');
    }
};
