<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_audience', function (Blueprint $table) {
            $table->string('geographic_reach')->nullable()->after('income_level');
            $table->text('target_market_summary')->nullable()->after('geographic_reach');
        });
    }

    public function down(): void
    {
        Schema::table('event_audience', function (Blueprint $table) {
            $table->dropColumn(['geographic_reach', 'target_market_summary']);
        });
    }
};
