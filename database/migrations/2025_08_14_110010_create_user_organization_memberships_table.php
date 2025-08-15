<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_organization_memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->string('role', 100)->default('member');
            $table->string('title', 255)->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamp('joined_at')->useCurrent();
            $table->timestamp('left_at')->nullable();
            $table->enum('status', ['active','inactive','pending'])->default('active');
            $table->timestamps();

            $table->unique(['user_id','organization_id','status'], 'unique_user_org_active');
            $table->index('user_id', 'idx_user_org_user_id');
            $table->index('organization_id', 'idx_user_org_organization_id');
            $table->index('role', 'idx_user_org_role');
            $table->index('status', 'idx_user_org_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_organization_memberships');
    }
};
