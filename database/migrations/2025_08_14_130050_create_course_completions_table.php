<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_completions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('enrollment_id')->constrained('course_enrollments')->cascadeOnDelete();
            $table->enum('completion_type', ['automatic','manual','admin_override'])->default('automatic');
            $table->timestamp('completion_date')->useCurrent();
            $table->decimal('final_grade', 5, 2)->nullable();
            $table->string('final_grade_letter', 5)->nullable();
            $table->integer('total_points_earned')->default(0);
            $table->integer('total_points_possible')->default(0);
            $table->integer('completion_time')->nullable();
            $table->json('criteria_met')->nullable();
            $table->boolean('certificate_issued')->default(false);
            $table->string('certificate_id', 100)->nullable();
            $table->string('certificate_url', 500)->nullable();
            $table->timestamp('certificate_issued_at')->nullable();
            $table->unsignedBigInteger('completed_by')->nullable();
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->foreign('completed_by')->references('id')->on('users')->nullOnDelete();
            $table->unique(['user_id','course_id'], 'unique_user_course_completion');
            $table->index('user_id', 'idx_completions_user_id');
            $table->index('course_id', 'idx_completions_course_id');
            $table->index('completion_date', 'idx_completions_completion_date');
            $table->index('certificate_issued', 'idx_completions_certificate_issued');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_completions');
    }
};
