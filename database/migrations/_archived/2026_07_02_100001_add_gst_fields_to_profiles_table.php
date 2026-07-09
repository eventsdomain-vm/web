<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * GST fields on the per-user profile. `gst_number` is the 15-char GSTIN;
 * `gst_verified*` capture the result of the live verification API, and
 * `gst_legal_name` stores the registered name the API returns (used on invoices).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('gst_number', 15)->nullable()->after('country');
            $table->boolean('gst_verified')->default(false)->after('gst_number');
            $table->timestamp('gst_verified_at')->nullable()->after('gst_verified');
            $table->string('gst_legal_name')->nullable()->after('gst_verified_at');

            $table->index('gst_number', 'idx_profiles_gst_number');
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropIndex('idx_profiles_gst_number');
            $table->dropColumn(['gst_number', 'gst_verified', 'gst_verified_at', 'gst_legal_name']);
        });
    }
};
