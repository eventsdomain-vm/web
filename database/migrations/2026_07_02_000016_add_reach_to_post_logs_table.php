<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('post_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('reach_impressions')->nullable()->after('error_message');
            $table->unsignedBigInteger('reach_reach')->nullable()->after('reach_impressions');
            $table->unsignedBigInteger('engagement_likes')->default(0)->after('reach_reach');
            $table->unsignedBigInteger('engagement_comments')->default(0)->after('engagement_likes');
            $table->unsignedBigInteger('engagement_shares')->default(0)->after('engagement_comments');
        });
    }

    public function down(): void
    {
        Schema::table('post_logs', function (Blueprint $table) {
            $table->dropColumn([
                'reach_impressions',
                'reach_reach',
                'engagement_likes',
                'engagement_comments',
                'engagement_shares',
            ]);
        });
    }
};
