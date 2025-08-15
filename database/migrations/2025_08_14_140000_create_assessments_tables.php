<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('activity_id')->nullable()->constrained('course_activities')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('instructions')->nullable();
            $table->enum('assessment_type', ['quiz','exam','assignment','project','survey','peer_review','self_assessment']);
            $table->integer('question_count')->default(0);
            $table->decimal('max_score', 8, 2)->default(0);
            $table->decimal('passing_score', 8, 2)->nullable();
            $table->decimal('weight', 5, 2)->default(1.00);
            $table->integer('time_limit')->nullable();
            $table->integer('max_attempts')->default(1);
            $table->integer('attempt_delay')->default(0);
            $table->boolean('randomize_questions')->default(false);
            $table->boolean('randomize_answers')->default(false);
            $table->enum('show_results', ['immediately','after_submission','after_due_date','never'])->default('after_submission');
            $table->boolean('show_correct_answers')->default(true);
            $table->boolean('allow_review')->default(true);
            $table->boolean('require_lockdown_browser')->default(false);
            $table->boolean('require_webcam')->default(false);
            $table->boolean('auto_grade')->default(true);
            $table->boolean('is_practice')->default(false);
            $table->boolean('is_required')->default(true);
            $table->timestamp('available_from')->nullable();
            $table->timestamp('available_until')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->boolean('late_submission_allowed')->default(false);
            $table->decimal('late_penalty_percentage', 5, 2)->default(0);
            $table->json('settings')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users')->restrictOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->index('course_id', 'idx_assessments_course_id');
            $table->index('activity_id', 'idx_assessments_activity_id');
            $table->index('assessment_type', 'idx_assessments_type');
            $table->index('due_date', 'idx_assessments_due_date');
            $table->index('available_from', 'idx_assessments_available_from');
            $table->index('created_by', 'idx_assessments_created_by');
        });

        Schema::create('assessment_questions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('assessment_id')->constrained('assessments')->cascadeOnDelete();
            $table->string('question_type', 50);
            $table->text('question_text');
            $table->text('question_html')->nullable();
            $table->integer('points')->default(1);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_required')->default(true);
            $table->integer('time_limit')->nullable();
            $table->json('question_data')->nullable();
            $table->json('media_files')->nullable();
            $table->timestamps();

            $table->index('assessment_id', 'idx_assessment_questions_assessment_id');
            $table->index('question_type', 'idx_assessment_questions_type');
            $table->index('sort_order', 'idx_assessment_questions_sort_order');
        });

        Schema::create('question_banks', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('subject', 255)->nullable();
            $table->string('category', 255)->nullable();
            $table->enum('difficulty_level', ['mixed','easy','medium','hard'])->default('mixed');
            $table->json('tags')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->restrictOnDelete();
            $table->index('subject', 'idx_question_banks_subject');
            $table->index('category', 'idx_question_banks_category');
            $table->index('created_by', 'idx_question_banks_created_by');
        });

        Schema::create('assessment_attempts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('assessment_id')->constrained('assessments')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('enrollment_id')->nullable()->constrained('course_enrollments')->cascadeOnDelete();
            $table->integer('attempt_number')->default(1);
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('graded_at')->nullable();
            $table->integer('duration')->nullable();
            $table->decimal('score', 8, 2)->default(0);
            $table->decimal('max_score', 8, 2)->default(0);
            $table->boolean('passed')->default(false);
            $table->enum('status', ['in_progress','submitted','graded','reviewed','cancelled','expired'])->default('in_progress');
            $table->json('answers')->nullable();
            $table->json('feedback')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->unique(['assessment_id','user_id','attempt_number'], 'unique_assessment_user_attempt');
            $table->index('user_id', 'idx_assessment_attempts_user_id');
            $table->index('status', 'idx_assessment_attempts_status');
        });

        Schema::create('assessment_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('assessment_attempts')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('assessment_questions')->cascadeOnDelete();
            $table->json('answer_data')->nullable();
            $table->decimal('score', 8, 2)->nullable();
            $table->boolean('is_correct')->nullable();
            $table->text('feedback')->nullable();
            $table->timestamps();

            $table->unique(['attempt_id','question_id'], 'unique_attempt_question');
            $table->index('attempt_id', 'idx_assessment_responses_attempt_id');
            $table->index('question_id', 'idx_assessment_responses_question_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_responses');
        Schema::dropIfExists('assessment_attempts');
        Schema::dropIfExists('question_banks');
        Schema::dropIfExists('assessment_questions');
        Schema::dropIfExists('assessments');
    }
};
