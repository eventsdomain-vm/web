<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('company_name', 255)->nullable()->after('phone');
            $table->string('company_logo', 500)->nullable()->after('company_name');
            $table->string('company_website', 500)->nullable()->after('company_logo');
            $table->text('company_description')->nullable()->after('company_website');
            $table->string('industry', 100)->nullable()->after('company_description');
            $table->string('company_size', 50)->nullable()->after('industry');
            $table->year('year_established')->nullable()->after('company_size');
            $table->string('gst_number', 50)->nullable()->after('year_established');
            $table->string('pan_number', 50)->nullable()->after('gst_number');
            $table->boolean('verified')->default(false)->after('pan_number');
            $table->timestamp('verified_at')->nullable()->after('verified');
            $table->boolean('is_featured')->default(false)->after('verified_at');
            $table->json('badges')->nullable()->after('is_featured');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'company_name', 'company_logo', 'company_website',
                'company_description', 'industry', 'company_size',
                'year_established', 'gst_number', 'pan_number',
                'verified', 'verified_at', 'is_featured', 'badges',
            ]);
        });
    }
};
