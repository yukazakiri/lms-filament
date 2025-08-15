<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('type', ['company','division','department','team','group'])->default('company');
            $table->string('logo_url', 500)->nullable();
            $table->string('website', 255)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('address_line_1', 255)->nullable();
            $table->string('address_line_2', 255)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state_province', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('timezone', 50)->default('UTC');
            $table->string('locale', 10)->default('en');
            $table->json('settings')->nullable();
            $table->enum('status', ['active','inactive','suspended'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parent_id')->references('id')->on('organizations')->nullOnDelete();
            $table->index('parent_id', 'idx_organizations_parent_id');
            $table->index('slug', 'idx_organizations_slug');
            $table->index('type', 'idx_organizations_type');
            $table->index('status', 'idx_organizations_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
