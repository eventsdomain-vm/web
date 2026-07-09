<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Partner marketplace: service listings, reviews, organizer requests, and bids.
 * Ported from the SQL dump into reproducible migrations.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partner_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 15, 2)->default(0);
            $table->enum('price_type', ['fixed', 'hourly', 'negotiable'])->default('fixed');
            $table->enum('pricing_model', ['cost', 'barter', 'hybrid'])->default('cost');
            $table->boolean('is_available')->default(true);
            $table->json('availability_calendar')->nullable();
            $table->unsignedInteger('min_notice_days')->default(7);
            $table->json('portfolio_images')->nullable();
            $table->timestamps();

            $table->index('partner_id', 'idx_partner_services_partner_id');
            $table->index('category_id', 'idx_partner_services_category_id');
            $table->index('is_available', 'idx_partner_services_is_available');
            if (Schema::getConnection()->getDriverName() !== 'sqlite') {
                $table->fullText(['title', 'description'], 'ft_partner_services_search');
            }
        });

        Schema::create('partner_service_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('partner_services')->cascadeOnDelete();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('organizer_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('rating');
            $table->text('review')->nullable();
            $table->timestamps();

            $table->unique(['service_id', 'event_id'], 'uk_partner_reviews_service_event');
            $table->index('event_id', 'idx_partner_reviews_event_id');
            $table->index('organizer_id', 'idx_partner_reviews_organizer_id');
        });

        Schema::create('partner_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('organizer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('partner_services')->cascadeOnDelete();
            $table->enum('pricing_model', ['cost', 'barter', 'hybrid'])->default('cost');
            $table->decimal('budget', 15, 2)->nullable();
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'quoted', 'accepted', 'rejected', 'completed'])->default('pending');
            $table->timestamps();

            $table->index('event_id', 'idx_partner_requests_event_id');
            $table->index('organizer_id', 'idx_partner_requests_organizer_id');
            $table->index('service_id', 'idx_partner_requests_service_id');
            $table->index('status', 'idx_partner_requests_status');
        });

        Schema::create('partner_bids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('partner_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('partner_services')->cascadeOnDelete();
            $table->decimal('quote_amount', 15, 2);
            $table->text('quote_note')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected', 'withdrawn'])->default('pending');
            $table->timestamps();

            $table->index('event_id', 'idx_partner_bids_event_id');
            $table->index('partner_id', 'idx_partner_bids_partner_id');
            $table->index('service_id', 'idx_partner_bids_service_id');
            $table->index('status', 'idx_partner_bids_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partner_bids');
        Schema::dropIfExists('partner_requests');
        Schema::dropIfExists('partner_service_reviews');
        Schema::dropIfExists('partner_services');
    }
};
