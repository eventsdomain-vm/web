<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organizer_profiles', function (Blueprint $table) {
            $table->string('pincode', 20)->nullable()->after('country');
            $table->string('pan_no', 20)->nullable()->after('tax_id');
            $table->string('designation', 100)->nullable()->after('business_type');
            $table->string('gst_number', 20)->nullable()->after('pan_no');
            $table->boolean('gst_verified')->default(false)->after('gst_number');
            $table->string('gst_legal_name')->nullable()->after('gst_verified');
            $table->timestamp('gst_verified_at')->nullable()->after('gst_legal_name');
            $table->boolean('pan_verified')->default(false)->after('gst_verified_at');
            $table->timestamp('pan_verified_at')->nullable()->after('pan_verified');
            $table->string('official_email')->nullable()->after('website');
            $table->string('social_media_link', 500)->nullable()->after('official_email');
            $table->json('client_references')->nullable()->after('social_media_link');
        });

        Schema::table('partner_profiles', function (Blueprint $table) {
            $table->string('pincode', 20)->nullable()->after('country');
            $table->string('pan_no', 20)->nullable()->after('tax_id');
            $table->string('designation', 100)->nullable()->after('business_type');
            $table->string('gst_number', 20)->nullable()->after('pan_no');
            $table->boolean('gst_verified')->default(false)->after('gst_number');
            $table->string('gst_legal_name')->nullable()->after('gst_verified');
            $table->timestamp('gst_verified_at')->nullable()->after('gst_legal_name');
            $table->boolean('pan_verified')->default(false)->after('gst_verified_at');
            $table->timestamp('pan_verified_at')->nullable()->after('pan_verified');
            $table->string('official_email')->nullable()->after('website');
            $table->string('social_media_link', 500)->nullable()->after('official_email');
            $table->json('client_references')->nullable()->after('social_media_link');
        });
    }

    public function down(): void
    {
        $columns = [
            'pincode', 'pan_no', 'designation', 'gst_number', 'gst_verified',
            'gst_legal_name', 'gst_verified_at', 'pan_verified', 'pan_verified_at',
            'official_email', 'social_media_link', 'client_references',
        ];

        Schema::table('organizer_profiles', fn (Blueprint $t) => $t->dropColumn($columns));
        Schema::table('partner_profiles', fn (Blueprint $t) => $t->dropColumn($columns));
    }
};
