<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('learning_sessions')) {
            return;
        }

        Schema::create('learning_sessions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('enrollment_id')->constrained('course_enrollments')->cascadeOnDelete();
            $table->string('session_token', 255)->nullable();
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('ended_at')->nullable();
            $table->integer('duration')->default(0);
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device_type', 50)->nullable();
            $table->string('browser', 100)->nullable();
            $table->string('platform', 100)->nullable();
            $table->string('location', 255)->nullable();
            $table->integer('activities_completed')->default(0);
            $table->integer('lessons_viewed')->default(0);
            $table->integer('interactions_count')->default(0);
            $table->integer('idle_time')->default(0);
            $table->json('session_data')->nullable();
            $table->timestamps();

            $table->index('user_id', 'idx_learning_sessions_user_id');
            $table->index('course_id', 'idx_learning_sessions_course_id');
            $table->index('enrollment_id', 'idx_learning_sessions_enrollment_id');
            $table->index('started_at', 'idx_learning_sessions_started_at');
            $table->index('duration', 'idx_learning_sessions_duration');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learning_sessions');
    }
};
