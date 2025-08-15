<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->text('description')->nullable();
            $table->string('category', 100)->nullable();
            $table->string('resource', 100)->nullable();
            $table->string('action', 100)->nullable();
            $table->boolean('is_system')->default(false);
            $table->timestamps();

            $table->index('category', 'idx_permissions_category');
            $table->index('resource', 'idx_permissions_resource');
            $table->index('action', 'idx_permissions_action');
            $table->index('is_system', 'idx_permissions_is_system');
        });

        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
            $table->boolean('granted')->default(true);
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['role_id','permission_id'], 'unique_role_permission');
            $table->index('role_id', 'idx_role_permissions_role_id');
            $table->index('permission_id', 'idx_role_permissions_permission_id');
        });

        Schema::create('user_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
            $table->string('context_type', 100)->nullable();
            $table->unsignedBigInteger('context_id')->nullable();
            $table->boolean('granted')->default(true);
            $table->unsignedBigInteger('assigned_by')->nullable();
            $table->timestamp('assigned_at')->useCurrent();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('revoked_at')->nullable();
            $table->unsignedBigInteger('revoked_by')->nullable();
            $table->timestamps();

            $table->foreign('assigned_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('revoked_by')->references('id')->on('users')->nullOnDelete();
            $table->index(['context_type','context_id'], 'idx_user_permissions_context');
            $table->index('expires_at', 'idx_user_permissions_expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_permissions');
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('permissions');
    }
};
