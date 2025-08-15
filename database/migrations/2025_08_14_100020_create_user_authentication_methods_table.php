<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_authentication_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('provider', 50);
            $table->string('provider_id', 255);
            $table->string('provider_email', 255)->nullable();
            $table->json('provider_data')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->unique(['provider', 'provider_id'], 'unique_provider_user');
            $table->index('user_id', 'idx_auth_methods_user_id');
            $table->index('provider', 'idx_auth_methods_provider');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_authentication_methods');
    }
};
