<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learning_notes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('module_id')->nullable()->constrained('course_modules')->cascadeOnDelete();
            $table->foreignId('lesson_id')->nullable()->constrained('course_lessons')->cascadeOnDelete();
            $table->foreignId('activity_id')->nullable()->constrained('course_activities')->cascadeOnDelete();
            $table->enum('content_type', ['course','module','lesson','activity']);
            $table->unsignedBigInteger('content_id');
            $table->string('title')->nullable();
            $table->longText('content');
            $table->longText('content_html')->nullable();
            $table->boolean('is_private')->default(true);
            $table->boolean('is_shared')->default(false);
            $table->json('tags')->nullable();
            $table->json('attachments')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id', 'idx_notes_user_id');
            $table->index('course_id', 'idx_notes_course_id');
            $table->index(['content_type','content_id'], 'idx_notes_content');
            $table->index('created_at', 'idx_notes_created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learning_notes');
    }
};
