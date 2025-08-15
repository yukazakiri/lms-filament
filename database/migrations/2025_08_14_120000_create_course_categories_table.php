<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_categories', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreignId('organization_id')->nullable()->constrained('organizations')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('icon', 255)->nullable();
            $table->string('color', 7)->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parent_id')->references('id')->on('course_categories')->nullOnDelete();
            $table->index('parent_id', 'idx_course_categories_parent_id');
            $table->index('organization_id', 'idx_course_categories_organization_id');
            $table->index('slug', 'idx_course_categories_slug');
            $table->index('sort_order', 'idx_course_categories_sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_categories');
    }
};
