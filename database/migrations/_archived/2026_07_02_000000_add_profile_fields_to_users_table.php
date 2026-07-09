<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The stock create_users_table migration ships Laravel's default columns only.
 * The application's User model (and OAuth/OTP flows) rely on additional profile
 * and verification columns that previously existed only in the SQL dump. This
 * additive migration brings `migrate:fresh` in line with the model.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('mobile', 20)->nullable()->after('password');
            $table->timestamp('mobile_verified_at')->nullable()->after('mobile');
            $table->boolean('is_verified')->default(false)->after('mobile_verified_at');
            $table->string('avatar', 500)->nullable()->after('is_verified');
            $table->string('phone', 20)->nullable()->after('avatar');
            $table->string('provider', 50)->nullable()->after('phone');
            $table->string('provider_id')->nullable()->after('provider');
            $table->text('provider_token')->nullable()->after('provider_id');
            $table->text('provider_refresh_token')->nullable()->after('provider_token');

            $table->index(['provider', 'provider_id'], 'idx_users_provider');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_provider');
            $table->dropColumn([
                'mobile', 'mobile_verified_at', 'is_verified', 'avatar', 'phone',
                'provider', 'provider_id', 'provider_token', 'provider_refresh_token',
            ]);
        });
    }
};
