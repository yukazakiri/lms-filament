<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->foreignId('organization_id')->nullable()->constrained('organizations')->cascadeOnDelete();
            $table->string('context_type', 100)->nullable();
            $table->unsignedBigInteger('context_id')->nullable();
            $table->unsignedBigInteger('assigned_by')->nullable();
            $table->timestamp('assigned_at')->useCurrent();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('revoked_at')->nullable();
            $table->unsignedBigInteger('revoked_by')->nullable();
            $table->text('revoke_reason')->nullable();
            $table->timestamps();

            $table->foreign('assigned_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('revoked_by')->references('id')->on('users')->nullOnDelete();
            $table->index(['context_type','context_id'], 'idx_user_roles_context');
            $table->index('organization_id', 'idx_user_roles_organization_id');
            $table->index('assigned_at', 'idx_user_roles_assigned_at');
            $table->index('expires_at', 'idx_user_roles_expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
