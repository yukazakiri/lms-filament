<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Core identifiers
            $table->uuid('uuid')->unique()->after('id');
            $table->string('username', 100)->nullable()->unique()->after('uuid');

            // Profile fields
            $table->string('first_name', 100)->nullable()->after('name');
            $table->string('last_name', 100)->nullable()->after('first_name');
            $table->string('middle_name', 100)->nullable()->after('last_name');
            $table->string('display_name', 255)->nullable()->after('middle_name');
            $table->string('avatar_url', 500)->nullable()->after('display_name');
            $table->string('phone', 20)->nullable()->after('avatar_url');
            $table->string('mobile', 20)->nullable()->after('phone');
            $table->date('date_of_birth')->nullable()->after('mobile');
            $table->enum('gender', ['male','female','other','prefer_not_to_say'])->nullable()->after('date_of_birth');
            $table->string('timezone', 50)->default('UTC')->after('gender');
            $table->string('locale', 10)->default('en')->after('timezone');
            $table->enum('status', ['active','inactive','suspended','pending'])->default('pending')->after('locale');

            // Security and activity
            $table->timestamp('last_login_at')->nullable()->after('email_verified_at');
            $table->timestamp('last_activity_at')->nullable()->after('last_login_at');
            $table->timestamp('password_changed_at')->nullable()->after('last_activity_at');
            $table->boolean('must_change_password')->default(false)->after('password_changed_at');
            $table->boolean('two_factor_enabled')->default(false)->after('must_change_password');
            $table->string('two_factor_secret', 255)->nullable()->after('two_factor_enabled');
            $table->softDeletes();

            // Helpful indexes
            $table->index('email', 'idx_users_email');
            $table->index('username', 'idx_users_username');
            $table->index('status', 'idx_users_status');
            $table->index('last_activity_at', 'idx_users_last_activity');
            $table->index('created_at', 'idx_users_created_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_email');
            $table->dropIndex('idx_users_username');
            $table->dropIndex('idx_users_status');
            $table->dropIndex('idx_users_last_activity');
            $table->dropIndex('idx_users_created_at');

            $table->dropColumn([
                'uuid','username','first_name','last_name','middle_name','display_name','avatar_url','phone','mobile','date_of_birth','gender','timezone','locale','status','last_login_at','last_activity_at','password_changed_at','must_change_password','two_factor_enabled','two_factor_secret','deleted_at',
            ]);
        });
    }
};
