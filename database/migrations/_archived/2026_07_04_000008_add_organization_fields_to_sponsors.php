<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sponsors', function (Blueprint $table) {
            if (! Schema::hasColumn('sponsors', 'org_type')) {
                $table->string('org_type', 100)->nullable()->after('industry');
                $table->string('registration_number', 100)->nullable()->after('org_type');
                $table->string('tax_id', 100)->nullable()->after('registration_number');
                $table->string('headquarters', 255)->nullable()->after('tax_id');
                $table->string('business_email', 255)->nullable()->after('headquarters');
                $table->string('business_phone', 50)->nullable()->after('business_email');
                $table->string('timezone', 100)->nullable()->after('business_phone');
                $table->string('default_currency', 10)->default('INR')->after('timezone');
                $table->string('fiscal_year', 20)->nullable()->after('default_currency');
                $table->string('org_status', 50)->default('active')->after('fiscal_year');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->dropColumn([
                'org_type', 'registration_number', 'tax_id', 'headquarters',
                'business_email', 'business_phone', 'timezone', 'default_currency',
                'fiscal_year', 'org_status',
            ]);
        });
    }
};
