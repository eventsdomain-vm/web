<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Per-user domain tables: role-scoped profile, OTP verification records, and
 * connected social-posting accounts (OAuth tokens).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('role_type', ['organizer', 'sponsor', 'partner']);
            $table->string('company_name')->nullable();
            $table->text('description')->nullable();
            $table->string('website', 500)->nullable();
            $table->json('social_links')->nullable();
            $table->string('location')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();

            $table->index('user_id', 'idx_profiles_user_id');
            $table->index('role_type', 'idx_profiles_role_type');
        });

        Schema::create('otp_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('otp_code');
            $table->enum('channel', ['sms', 'whatsapp', 'email']);
            $table->timestamp('expires_at');
            $table->integer('attempts')->default(0);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->index('user_id', 'idx_otp_user_id');
            $table->index('expires_at', 'idx_otp_expires_at');
        });

        Schema::create('social_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('provider', ['linkedin', 'facebook', 'instagram', 'youtube']);
            $table->string('provider_id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('avatar', 500)->nullable();
            $table->text('access_token');
            $table->text('refresh_token')->nullable();
            $table->timestamp('token_expires_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'provider', 'provider_id'], 'uk_social_accounts_provider_user');
            $table->index('provider', 'idx_social_accounts_provider');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_accounts');
        Schema::dropIfExists('otp_verifications');
        Schema::dropIfExists('profiles');
    }
};
