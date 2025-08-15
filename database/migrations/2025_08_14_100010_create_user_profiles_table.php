<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('employee_id', 50)->nullable();
            $table->string('job_title', 255)->nullable();
            $table->string('department', 255)->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->date('hire_date')->nullable();
            $table->string('location', 255)->nullable();
            $table->string('address_line_1', 255)->nullable();
            $table->string('address_line_2', 255)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state_province', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('emergency_contact_name', 255)->nullable();
            $table->string('emergency_contact_phone', 20)->nullable();
            $table->string('emergency_contact_relationship', 100)->nullable();
            $table->text('bio')->nullable();
            $table->json('skills')->nullable();
            $table->json('interests')->nullable();
            $table->json('social_links')->nullable();
            $table->json('custom_fields')->nullable();
            $table->timestamps();

            $table->foreign('manager_id')->references('id')->on('users')->nullOnDelete();
            $table->index('user_id', 'idx_user_profiles_user_id');
            $table->index('employee_id', 'idx_user_profiles_employee_id');
            $table->index('manager_id', 'idx_user_profiles_manager_id');
            $table->index('department', 'idx_user_profiles_department');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
