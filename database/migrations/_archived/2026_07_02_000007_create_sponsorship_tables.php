<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Sponsorship domain: a sponsor brand master, per-event packages (tiers) with
 * their benefits, open sponsorship opportunities (ad spaces / food / content
 * add-ons from the import source), and the request → contract workflow.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Sponsor brand/company, distinct from the sponsor user account.
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo', 500)->nullable();
            $table->string('website', 500)->nullable();
            $table->string('industry', 120)->nullable();
            $table->text('description')->nullable();
            $table->json('social_links')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->index('user_id', 'idx_sponsors_user_id');
            if (Schema::getConnection()->getDriverName() !== 'sqlite') {
                $table->fullText(['name', 'description'], 'ft_sponsors_search');
            }
        });

        // Per-event sponsorship tiers with slot tracking.
        Schema::create('sponsor_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('level', 120)->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 15, 2)->default(0);
            $table->char('currency', 3)->default('INR');
            $table->string('budget_range_label', 80)->nullable();
            $table->unsignedInteger('slots_available')->default(1);
            $table->unsignedInteger('slots_filled')->default(0);
            $table->json('benefits')->nullable(); // fast-path; structured rows below
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('event_id', 'idx_sponsor_packages_event_id');
            $table->index(['event_id', 'is_active'], 'idx_sponsor_packages_active');
            if (Schema::getConnection()->getDriverName() !== 'sqlite') {
                $table->fullText(['title', 'description'], 'ft_sponsor_packages_search');
            }
        });

        Schema::create('sponsorship_benefits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('sponsor_packages')->cascadeOnDelete();
            $table->string('benefit_text', 500);
            $table->timestamps();

            $table->index('package_id', 'idx_sponsorship_benefits_package_id');
        });

        // Open inventory a sponsor can buy into (maps import ad/food/content sections).
        Schema::create('sponsorship_opportunities', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->unique();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sponsor_package_id')->nullable()
                ->constrained('sponsor_packages')->nullOnDelete();
            $table->string('title');
            $table->enum('type', [
                'advertising_space', 'food_partnership', 'content_addon',
                'naming_rights', 'booth', 'other',
            ]);
            $table->text('description')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->char('currency', 3)->default('INR');
            $table->enum('availability', ['available', 'limited', 'sold_out'])->default('available');
            $table->unsignedInteger('slots_total')->nullable();
            $table->unsignedInteger('slots_filled')->default(0);
            $table->json('metadata')->nullable();
            $table->integer('sort_order')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->index('event_id', 'idx_opportunities_event');
            $table->index(['type', 'availability'], 'idx_opportunities_type_avail');
        });

        Schema::create('sponsorship_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sponsor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('package_id')->nullable()
                ->constrained('sponsor_packages')->nullOnDelete();
            $table->enum('status', ['pending', 'accepted', 'rejected', 'negotiating'])->default('pending');
            $table->text('custom_proposal')->nullable();
            $table->decimal('budget_offer', 15, 2)->nullable();
            $table->text('message')->nullable();
            $table->timestamps();

            $table->index('event_id', 'idx_sponsorship_requests_event_id');
            $table->index('sponsor_id', 'idx_sponsorship_requests_sponsor_id');
            $table->index('package_id', 'idx_sponsorship_requests_package_id');
            $table->index('status', 'idx_sponsorship_requests_status');
        });

        Schema::create('sponsorship_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('sponsorship_requests')->cascadeOnDelete();
            $table->enum('status', ['active', 'completed', 'terminated'])->default('active');
            $table->text('terms')->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();

            $table->index('request_id', 'idx_sponsorship_contracts_request_id');
            $table->index('status', 'idx_sponsorship_contracts_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sponsorship_contracts');
        Schema::dropIfExists('sponsorship_requests');
        Schema::dropIfExists('sponsorship_opportunities');
        Schema::dropIfExists('sponsorship_benefits');
        Schema::dropIfExists('sponsor_packages');
        Schema::dropIfExists('sponsors');
    }
};
