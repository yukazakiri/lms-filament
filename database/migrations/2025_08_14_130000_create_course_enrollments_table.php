<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_enrollments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('course_version_id')->nullable()->constrained('course_versions')->nullOnDelete();
            $table->enum('enrollment_type', ['self','admin','manager','automatic','invitation'])->default('self');
            $table->enum('status', ['enrolled','in_progress','completed','failed','withdrawn','expired','suspended'])->default('enrolled');
            $table->decimal('progress_percentage', 5, 2)->default(0);
            $table->decimal('completion_percentage', 5, 2)->default(0);
            $table->decimal('grade', 5, 2)->nullable();
            $table->string('grade_letter', 5)->nullable();
            $table->integer('points_earned')->default(0);
            $table->integer('points_possible')->default(0);
            $table->timestamp('enrolled_at')->useCurrent();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('last_accessed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamp('withdrawn_at')->nullable();
            $table->text('withdrawal_reason')->nullable();
            $table->unsignedBigInteger('enrolled_by')->nullable();
            $table->json('completion_criteria_met')->nullable();
            $table->json('custom_fields')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('enrolled_by')->references('id')->on('users')->nullOnDelete();
            $table->unique(['user_id','course_id'], 'unique_user_course_enrollment');
            $table->index('user_id', 'idx_enrollments_user_id');
            $table->index('course_id', 'idx_enrollments_course_id');
            $table->index('status', 'idx_enrollments_status');
            $table->index('enrolled_at', 'idx_enrollments_enrolled_at');
            $table->index('completed_at', 'idx_enrollments_completed_at');
            $table->index('last_accessed_at', 'idx_enrollments_last_accessed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_enrollments');
    }
};
