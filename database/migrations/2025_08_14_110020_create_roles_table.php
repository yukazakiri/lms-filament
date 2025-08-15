<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('organization_id')->nullable()->constrained('organizations')->cascadeOnDelete();
            $table->string('name', 100);
            $table->string('slug', 100);
            $table->text('description')->nullable();
            $table->enum('type', ['system','organization','course','custom'])->default('custom');
            $table->integer('level')->default(0);
            $table->unsignedBigInteger('parent_role_id')->nullable();
            $table->boolean('is_default')->default(false);
            $table->boolean('is_system')->default(false);
            $table->json('permissions')->nullable();
            $table->json('settings')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parent_role_id')->references('id')->on('roles')->nullOnDelete();
            $table->unique(['organization_id','slug'], 'unique_role_org_slug');
            $table->index('organization_id', 'idx_roles_organization_id');
            $table->index('type', 'idx_roles_type');
            $table->index('parent_role_id', 'idx_roles_parent_role_id');
            $table->index('is_system', 'idx_roles_is_system');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
