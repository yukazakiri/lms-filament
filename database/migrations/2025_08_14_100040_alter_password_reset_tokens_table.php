<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('password_reset_tokens')) {
            return; // leave default migration as-is if not present
        }

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            // Recreate table for SQLite to add PK and new columns
            Schema::create('password_reset_tokens_tmp', function (Blueprint $table) {
                $table->id();
                $table->string('email')->unique();
                $table->string('token');
                $table->timestamp('created_at')->nullable();

                $table->unsignedBigInteger('user_id')->nullable();
                $table->timestamp('expires_at')->nullable();
                $table->timestamp('used_at')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();

                $table->index('token', 'idx_password_reset_token');
                $table->index('user_id', 'idx_password_reset_user_id');
                $table->index('expires_at', 'idx_password_reset_expires');

                $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            });

            DB::statement('INSERT INTO password_reset_tokens_tmp (email, token, created_at) SELECT email, token, created_at FROM password_reset_tokens');
            Schema::drop('password_reset_tokens');
            Schema::rename('password_reset_tokens_tmp', 'password_reset_tokens');
        } else {
            // Non-SQLite: drop primary and add the new columns
            Schema::table('password_reset_tokens', function (Blueprint $table) {
                $table->dropPrimary(['email']);
            });
            Schema::table('password_reset_tokens', function (Blueprint $table) {
                $table->id()->first();
                $table->unsignedBigInteger('user_id')->nullable()->after('email');
                $table->timestamp('expires_at')->nullable()->after('token');
                $table->timestamp('used_at')->nullable()->after('expires_at');
                $table->string('ip_address', 45)->nullable()->after('used_at');
                $table->text('user_agent')->nullable()->after('ip_address');

                $table->index('token', 'idx_password_reset_token');
                $table->index('user_id', 'idx_password_reset_user_id');
                $table->index('expires_at', 'idx_password_reset_expires');

                $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('password_reset_tokens')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            Schema::create('password_reset_tokens_tmp', function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });
            DB::statement('INSERT INTO password_reset_tokens_tmp (email, token, created_at) SELECT email, token, created_at FROM password_reset_tokens');
            Schema::drop('password_reset_tokens');
            Schema::rename('password_reset_tokens_tmp', 'password_reset_tokens');
        } else {
            Schema::table('password_reset_tokens', function (Blueprint $table) {
                // Best-effort rollback: drop newly added FKs/indexes/columns
                $table->dropForeign(['user_id']);
                $table->dropIndex('idx_password_reset_token');
                $table->dropIndex('idx_password_reset_user_id');
                $table->dropIndex('idx_password_reset_expires');
                $table->dropColumn(['id','user_id','expires_at','used_at','ip_address','user_agent']);
                $table->primary('email');
            });
        }
    }
};
