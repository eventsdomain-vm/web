<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'two_factor_enabled')) {
                $table->boolean('two_factor_enabled')->default(false)->after('is_verified');
            }
        });

        Schema::table('sponsors', function (Blueprint $table) {
            if (! Schema::hasColumn('sponsors', 'sso_provider')) {
                $table->string('sso_provider', 50)->nullable()->after('is_verified');
                $table->string('sso_client_id', 500)->nullable()->after('sso_provider');
                $table->text('sso_client_secret')->nullable()->after('sso_client_id');
                $table->boolean('sso_enabled')->default(false)->after('sso_client_secret');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('two_factor_enabled');
        });

        Schema::table('sponsors', function (Blueprint $table) {
            $table->dropColumn(['sso_provider', 'sso_client_id', 'sso_client_secret', 'sso_enabled']);
        });
    }
};
