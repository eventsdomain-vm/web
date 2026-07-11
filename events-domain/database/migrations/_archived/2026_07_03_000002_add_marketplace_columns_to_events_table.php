<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Audience targeting
            $table->string('target_age_group', 20)->nullable()->after('expected_audience');
            $table->string('target_gender', 10)->nullable()->after('target_age_group');

            // Social / online presence
            $table->unsignedInteger('instagram_reach')->nullable()->after('video_url');
            $table->unsignedInteger('youtube_reach')->nullable()->after('instagram_reach');
            $table->unsignedInteger('website_traffic')->nullable()->after('youtube_reach');

            // Event quality signals
            $table->boolean('has_celebrity')->default(false)->after('website_traffic');
            $table->boolean('has_govt_support')->default(false)->after('has_celebrity');
            $table->boolean('has_media_coverage')->default(false)->after('has_govt_support');
            $table->string('venue_type', 100)->nullable()->after('has_media_coverage');
            $table->decimal('ticket_price_min', 10, 2)->nullable()->after('venue_type');
            $table->decimal('ticket_price_max', 10, 2)->nullable()->after('ticket_price_min');
            $table->text('previous_sponsors')->nullable()->after('ticket_price_max');

            // Cached health score
            $table->decimal('health_score', 5, 2)->nullable()->after('previous_sponsors');
            $table->timestamp('health_score_updated_at')->nullable()->after('health_score');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'target_age_group',
                'target_gender',
                'instagram_reach',
                'youtube_reach',
                'website_traffic',
                'has_celebrity',
                'has_govt_support',
                'has_media_coverage',
                'venue_type',
                'ticket_price_min',
                'ticket_price_max',
                'previous_sponsors',
                'health_score',
                'health_score_updated_at',
            ]);
        });
    }
};
