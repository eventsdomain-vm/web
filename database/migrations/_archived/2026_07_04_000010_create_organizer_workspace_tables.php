<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('organization_name')->nullable();
            $table->string('organization_logo')->nullable();
            $table->string('business_type', 50)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('tax_id', 50)->nullable();
            $table->string('website')->nullable();
            $table->text('bio')->nullable();
            $table->unsignedSmallInteger('founded_year')->nullable();
            $table->unsignedSmallInteger('team_size')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });

        Schema::create('organizer_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('locale', 10)->default('en');
            $table->string('timezone', 50)->default('UTC');
            $table->string('currency', 3)->default('INR');
            $table->json('notification_preferences')->nullable();
            $table->json('reporting_preferences')->nullable();
            $table->json('marketplace_preferences')->nullable();
            $table->timestamps();
        });

        Schema::create('organizer_sponsor_relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sponsor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('event_id')->nullable()->constrained()->nullOnDelete();
            $table->string('relationship_type', 50)->default('sponsor');
            $table->string('status', 30)->default('active');
            $table->unsignedTinyInteger('health_score')->nullable();
            $table->timestamp('last_engagement_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'sponsor_id']);
        });

        Schema::create('organizer_renewals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sponsor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('contract_id')->nullable()->constrained('sponsorship_contracts')->nullOnDelete();
            $table->string('status', 30)->default('pending');
            $table->decimal('proposed_value', 12, 2)->nullable();
            $table->unsignedTinyInteger('probability')->nullable();
            $table->date('expected_close_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('renewed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('organizer_post_event_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('total_attendance')->nullable();
            $table->unsignedInteger('sponsor_booth_visits')->nullable();
            $table->unsignedInteger('lead_generated')->nullable();
            $table->decimal('sponsor_satisfaction', 3, 1)->nullable();
            $table->decimal('roi_percentage', 5, 1)->nullable();
            $table->decimal('revenue_generated', 12, 2)->nullable();
            $table->decimal('expenses_incurred', 12, 2)->nullable();
            $table->json('deliverable_fulfillment')->nullable();
            $table->json('media_coverage')->nullable();
            $table->json('feedback_data')->nullable();
            $table->text('lessons_learned')->nullable();
            $table->text('improvement_notes')->nullable();
            $table->string('status', 30)->default('draft');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'event_id']);
        });

        Schema::create('organizer_check_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sponsor_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('type', 30)->default('sponsor');
            $table->string('status', 30)->default('pending');
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('checked_out_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organizer_check_ins');
        Schema::dropIfExists('organizer_post_event_reports');
        Schema::dropIfExists('organizer_renewals');
        Schema::dropIfExists('organizer_sponsor_relationships');
        Schema::dropIfExists('organizer_settings');
        Schema::dropIfExists('organizer_profiles');
    }
};
