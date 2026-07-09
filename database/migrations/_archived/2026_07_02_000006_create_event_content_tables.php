<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Event content children: gallery, documents, FAQs, amenities pivot, team,
 * ticket types, per-event statistics, organizer contacts, and a polymorphic
 * social-links table shared by events/participants/sponsors.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_gallery', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('media_id')->nullable()->constrained('media')->nullOnDelete();
            $table->string('image_url', 500);
            $table->string('caption')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('event_id', 'idx_event_gallery_event_id');
            $table->index('sort_order', 'idx_event_gallery_sort_order');
        });

        Schema::create('event_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('file_path', 500);
            $table->string('file_type', 50)->nullable();
            $table->unsignedInteger('file_size')->nullable();
            $table->enum('visibility', ['public', 'sponsors_only', 'private'])->default('public');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('event_id', 'idx_event_documents_event');
        });

        Schema::create('event_faqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('question', 500);
            $table->text('answer');
            $table->boolean('is_published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('event_id', 'idx_event_faqs_event');
        });

        Schema::create('event_amenities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('amenity_id')->constrained()->cascadeOnDelete();
            $table->string('notes')->nullable();
            $table->timestamps();

            $table->unique(['event_id', 'amenity_id'], 'uk_event_amenities');
            $table->index('amenity_id', 'idx_event_amenities_amenity');
        });

        Schema::create('event_team', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('role', 100)->default('member');
            $table->timestamps();

            $table->unique(['event_id', 'user_id'], 'uk_event_team_event_user');
            $table->index('user_id', 'idx_event_team_user_id');
        });

        Schema::create('ticket_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('name', 150);
            $table->text('description')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->char('currency', 3)->default('INR');
            $table->unsignedInteger('quantity_total')->nullable();
            $table->unsignedInteger('quantity_sold')->default(0);
            $table->dateTime('sales_start')->nullable();
            $table->dateTime('sales_end')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('event_id', 'idx_ticket_types_event');
        });

        // 1:1 denormalized engagement stats for cheap "trending" sorts.
        Schema::create('event_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->unique()->constrained()->cascadeOnDelete();
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('unique_views')->default(0);
            $table->unsignedInteger('saves')->default(0);
            $table->unsignedInteger('shares')->default(0);
            $table->unsignedInteger('sponsor_requests_count')->default(0);
            $table->unsignedInteger('enquiries_count')->default(0);
            $table->unsignedInteger('packages_count')->default(0);
            $table->timestamp('last_viewed_at')->nullable();
            $table->timestamps();

            $table->index('views', 'idx_event_statistics_views');
        });

        Schema::create('organizer_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name')->nullable();
            $table->string('designation', 150)->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('whatsapp', 30)->nullable();
            $table->boolean('is_primary')->default(false);
            $table->boolean('is_public')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('event_id', 'idx_org_contacts_event');
            $table->index(['event_id', 'is_primary'], 'idx_org_contacts_primary');
        });

        // Polymorphic social links (events, participants, sponsors, ...).
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->morphs('linkable'); // creates idx on (linkable_type, linkable_id)
            $table->string('platform', 50);
            $table->string('url', 500);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('organizer_contacts');
        Schema::dropIfExists('event_statistics');
        Schema::dropIfExists('ticket_types');
        Schema::dropIfExists('event_team');
        Schema::dropIfExists('event_amenities');
        Schema::dropIfExists('event_faqs');
        Schema::dropIfExists('event_documents');
        Schema::dropIfExists('event_gallery');
    }
};
