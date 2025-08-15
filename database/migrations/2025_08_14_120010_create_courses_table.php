<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('course_categories')->nullOnDelete();
            $table->string('code', 50)->nullable()->unique();
            $table->string('title');
            $table->string('slug');
            $table->string('subtitle', 500)->nullable();
            $table->text('description')->nullable();
            $table->text('objectives')->nullable();
            $table->text('prerequisites')->nullable();
            $table->text('target_audience')->nullable();
            $table->enum('difficulty_level', ['beginner','intermediate','advanced','expert'])->default('beginner');
            $table->integer('estimated_duration')->nullable();
            $table->string('language', 10)->default('en');
            $table->string('thumbnail_url', 500)->nullable();
            $table->string('trailer_url', 500)->nullable();
            $table->enum('status', ['draft','review','published','archived','suspended'])->default('draft');
            $table->enum('type', ['self_paced','instructor_led','blended','webinar','workshop'])->default('self_paced');
            $table->enum('delivery_method', ['online','classroom','hybrid'])->default('online');
            $table->integer('max_enrollments')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('currency', 3)->default('USD');
            $table->boolean('is_free')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_public')->default(true);
            $table->boolean('requires_approval')->default(false);
            $table->unsignedBigInteger('certificate_template_id')->nullable();
            $table->json('completion_criteria')->nullable();
            $table->json('tags')->nullable();
            $table->json('metadata')->nullable();
            $table->string('seo_title', 255)->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users')->restrictOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->index('organization_id', 'idx_courses_organization_id');
            $table->index('category_id', 'idx_courses_category_id');
            $table->index('code', 'idx_courses_code');
            $table->index('slug', 'idx_courses_slug');
            $table->index('status', 'idx_courses_status');
            $table->index('type', 'idx_courses_type');
            $table->index('created_by', 'idx_courses_created_by');
            $table->index('published_at', 'idx_courses_published_at');
            // For FULLTEXT, use a separate migration or raw statement if MySQL
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
