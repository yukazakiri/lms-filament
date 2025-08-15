<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->string('id', 40)->primary();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device_type', 50)->nullable();
            $table->string('browser', 100)->nullable();
            $table->string('platform', 100)->nullable();
            $table->string('location', 255)->nullable();
            $table->boolean('is_mobile')->default(false);
            $table->timestamp('last_activity')->useCurrent();
            $table->timestamps();

            $table->index('user_id', 'idx_sessions_user_id');
            $table->index('last_activity', 'idx_sessions_last_activity');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_sessions');
    }
};
