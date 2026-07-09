<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Redesigned events core. Dates, venues and participants are normalized into
 * child tables (see later migrations) which are the source of truth. This table
 * keeps identity, taxonomy, workflow, money bounds and media, PLUS lightweight
 * denormalized SUMMARY columns (start_date, end_date, city, state, country,
 * venue, next_occurrence_at, primary lat/long) that observers keep in sync so
 * public listing queries stay single-table and existing controllers/views that
 * read $event->city / $event->start_date keep working unchanged.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->unique();

            // Identity & taxonomy
            $table->foreignId('organizer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->foreignId('subcategory_id')->nullable()
                ->constrained('categories')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('tagline', 500)->nullable();
            $table->text('description');

            // Format & workflow
            $table->enum('event_type', ['physical', 'virtual', 'hybrid'])->default('physical');
            $table->enum('visibility', ['public', 'unlisted', 'private'])->default('public');
            $table->enum('approval_status', [
                'draft', 'pending', 'approved', 'rejected', 'changes_requested',
            ])->default('draft');
            $table->enum('status', [
                'draft', 'pending', 'approved', 'rejected', 'live', 'completed', 'cancelled',
            ])->default('draft');
            $table->text('rejection_reason')->nullable();

            // Locale & money
            $table->string('timezone', 64)->default('Asia/Kolkata');
            $table->char('currency', 3)->default('INR');
            $table->decimal('budget_min', 15, 2)->nullable();
            $table->decimal('budget_max', 15, 2)->nullable();
            $table->decimal('minimum_sponsorship', 15, 2)->nullable();
            $table->decimal('maximum_sponsorship', 15, 2)->nullable();
            $table->enum('sponsorship_type', ['paid', 'barter', 'hybrid'])->default('paid');

            // Audience & registration
            $table->unsignedInteger('expected_audience')->nullable();
            $table->text('audience_description')->nullable();
            $table->date('registration_deadline')->nullable();
            $table->string('registration_url', 500)->nullable();
            $table->string('website_url', 500)->nullable();
            $table->string('video_url', 500)->nullable();

            // Legacy media fallbacks (Spatie Media Library is primary)
            $table->string('logo', 500)->nullable();
            $table->string('cover_image', 500)->nullable();
            $table->string('banner_image', 500)->nullable();

            // Flexible JSON
            $table->json('previous_edition_stats')->nullable();
            $table->json('tags')->nullable();

            // Flags & lifecycle
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('views_count')->default(0);

            // -----------------------------------------------------------------
            // SUMMARY / CACHE columns (kept in sync by EventDate/EventVenue
            // observers). Legacy names reused so existing code is untouched.
            // -----------------------------------------------------------------
            $table->dateTime('start_date')->nullable();          // MIN(event_dates)
            $table->dateTime('end_date')->nullable();            // MAX(event_dates)
            $table->dateTime('next_occurrence_at')->nullable();  // next future occurrence
            $table->string('venue')->nullable();                 // primary venue name
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->decimal('primary_latitude', 10, 7)->nullable();
            $table->decimal('primary_longitude', 10, 7)->nullable();

            $table->softDeletes();
            $table->timestamps();

            // Indexes -----------------------------------------------------------
            $table->index('organizer_id', 'idx_events_organizer_id');
            $table->index('category_id', 'idx_events_category_id');
            $table->index('subcategory_id', 'idx_events_subcategory_id');
            $table->index('approval_status', 'idx_events_approval_status');
            $table->index('status', 'idx_events_status');
            $table->index('city', 'idx_events_city');
            $table->index('next_occurrence_at', 'idx_events_next_occurrence');
            // Primary public-listing covering index (published + featured + date sort)
            $table->index(['approval_status', 'is_published', 'is_featured', 'start_date'], 'idx_events_listing');
            // Category + location browse
            $table->index(['category_id', 'city', 'start_date'], 'idx_events_cat_city_date');
            // Facet filters
            $table->index(['event_type', 'sponsorship_type'], 'idx_events_type_sponsorship');
            if (Schema::getConnection()->getDriverName() !== 'sqlite') {
                $table->fullText(['title', 'tagline', 'description'], 'ft_events_search');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
