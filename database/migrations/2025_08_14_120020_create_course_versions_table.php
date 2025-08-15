<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->string('version_number', 20);
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('content_hash', 64)->nullable();
            $table->boolean('is_current')->default(false);
            $table->boolean('is_published')->default(false);
            $table->text('change_log')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('published_by')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->restrictOnDelete();
            $table->foreign('published_by')->references('id')->on('users')->nullOnDelete();
            $table->unique(['course_id','version_number'], 'unique_course_version');
            $table->index('course_id', 'idx_course_versions_course_id');
            $table->index('is_current', 'idx_course_versions_is_current');
            $table->index('published_at', 'idx_course_versions_published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_versions');
    }
};
