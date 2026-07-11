<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Sponsor fiscal budget tracking
        Schema::create('sponsor_budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('users')->cascadeOnDelete();
            $table->year('fiscal_year');
            $table->decimal('total_budget', 15, 2)->default(0);
            $table->decimal('allocated', 15, 2)->default(0);
            $table->decimal('spent', 15, 2)->default(0);
            $table->char('currency', 3)->default('INR');
            $table->timestamps();

            $table->unique(['sponsor_id', 'fiscal_year'], 'uk_sponsor_budget_year');
            $table->index('sponsor_id', 'idx_sponsor_budgets_sponsor_id');
        });

        // Sponsor proposals (replaces simple sponsorship_requests with full state machine)
        Schema::create('sponsor_proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sponsor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('package_id')->nullable()->constrained('sponsor_packages')->nullOnDelete();
            $table->enum('status', [
                'draft', 'submitted', 'viewed', 'shortlisted', 'negotiating',
                'counter_offer', 'agreed', 'contracted', 'payment_pending',
                'active', 'completed', 'rejected', 'withdrawn',
            ])->default('draft');
            $table->text('message')->nullable();
            $table->decimal('budget_offer', 15, 2)->nullable();
            $table->text('additional_benefits')->nullable();
            $table->text('internal_note')->nullable();
            $table->text('organizer_note')->nullable();
            $table->decimal('counter_amount', 15, 2)->nullable();
            $table->text('counter_message')->nullable();
            $table->timestamp('viewed_at')->nullable();
            $table->timestamp('agreed_at')->nullable();
            $table->timestamp('contracted_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index('event_id', 'idx_sponsor_proposals_event');
            $table->index('sponsor_id', 'idx_sponsor_proposals_sponsor');
            $table->index('package_id', 'idx_sponsor_proposals_package');
            $table->index('status', 'idx_sponsor_proposals_status');
            $table->index(['sponsor_id', 'status'], 'idx_sponsor_proposals_sponsor_status');
        });

        // Sponsor watchlist with private notes
        Schema::create('sponsor_saved_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->text('note')->nullable();
            $table->json('tags')->nullable();
            $table->timestamps();

            $table->unique(['sponsor_id', 'event_id'], 'uk_sponsor_saved_event');
            $table->index('sponsor_id', 'idx_sponsor_saved_sponsor');
            $table->index('event_id', 'idx_sponsor_saved_event');
        });

        // Comparison sets
        Schema::create('sponsor_comparisons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('users')->cascadeOnDelete();
            $table->string('name', 100)->nullable();
            $table->timestamps();

            $table->index('sponsor_id', 'idx_sponsor_comparisons_sponsor');
        });

        Schema::create('sponsor_comparison_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comparison_id')->constrained('sponsor_comparisons')->cascadeOnDelete();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['comparison_id', 'event_id'], 'uk_comparison_item');
            $table->index('comparison_id', 'idx_comparison_items_comparison');
            $table->index('event_id', 'idx_comparison_items_event');
        });

        // Active sponsorship campaigns
        Schema::create('sponsor_campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('sponsor_proposals')->cascadeOnDelete();
            $table->foreignId('sponsor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['planning', 'active', 'paused', 'completed', 'cancelled'])->default('planning');
            $table->decimal('budget', 15, 2)->nullable();
            $table->decimal('spent', 15, 2)->default(0);
            $table->unsignedInteger('target_reach')->nullable();
            $table->unsignedInteger('actual_reach')->nullable();
            $table->unsignedInteger('leads_generated')->nullable();
            $table->unsignedInteger('brand_mentions')->nullable();
            $table->decimal('roi', 5, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();

            $table->index('proposal_id', 'idx_campaigns_proposal');
            $table->index('sponsor_id', 'idx_campaigns_sponsor');
            $table->index('event_id', 'idx_campaigns_event');
            $table->index('status', 'idx_campaigns_status');
        });

        // Campaign deliverable checklist
        Schema::create('sponsor_campaign_deliverables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('sponsor_campaigns')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->date('due_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index('campaign_id', 'idx_deliverables_campaign');
            $table->index('status', 'idx_deliverables_status');
        });

        // Sponsor team member roles
        Schema::create('sponsor_team_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('role', ['admin', 'editor', 'viewer', 'approver', 'finance'])->default('viewer');
            $table->timestamps();

            $table->unique(['sponsor_id', 'user_id'], 'uk_sponsor_team_member');
            $table->index('sponsor_id', 'idx_team_sponsor');
            $table->index('user_id', 'idx_team_user');
        });

        // Sponsor internal notes (private team notes per event/campaign)
        Schema::create('sponsor_internal_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('event_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('campaign_id')->nullable()->constrained('sponsor_campaigns')->nullOnDelete();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->text('content');
            $table->json('attachments')->nullable();
            $table->timestamps();

            $table->index('sponsor_id', 'idx_notes_sponsor');
            $table->index('event_id', 'idx_notes_event');
            $table->index('campaign_id', 'idx_notes_campaign');
            $table->index('author_id', 'idx_notes_author');
        });

        // Partner daily availability
        Schema::create('partner_availability', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('users')->cascadeOnDelete();
            $table->date('date');
            $table->enum('status', ['available', 'booked', 'blocked'])->default('available');
            $table->foreignId('event_id')->nullable()->constrained()->nullOnDelete();
            $table->string('note', 255)->nullable();
            $table->timestamps();

            $table->unique(['partner_id', 'date'], 'uk_partner_availability_date');
            $table->index('partner_id', 'idx_availability_partner');
            $table->index('status', 'idx_availability_status');
            $table->index('date', 'idx_availability_date');
        });

        // Partner portfolio showcase
        Schema::create('partner_portfolio_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('event_name', 255)->nullable();
            $table->date('event_date')->nullable();
            $table->string('location', 255)->nullable();
            $table->json('images')->nullable();
            $table->string('video_url', 500)->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            $table->index('partner_id', 'idx_portfolio_partner');
            $table->index('is_featured', 'idx_portfolio_featured');
        });

        // Partner payouts / revenue tracking
        Schema::create('partner_payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->string('payment_method', 50)->nullable();
            $table->string('transaction_id', 255)->nullable();
            $table->string('invoice_number', 50)->nullable();
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index('partner_id', 'idx_payouts_partner');
            $table->index('status', 'idx_payouts_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partner_payouts');
        Schema::dropIfExists('partner_portfolio_items');
        Schema::dropIfExists('partner_availability');
        Schema::dropIfExists('sponsor_internal_notes');
        Schema::dropIfExists('sponsor_team_members');
        Schema::dropIfExists('sponsor_campaign_deliverables');
        Schema::dropIfExists('sponsor_campaigns');
        Schema::dropIfExists('sponsor_comparison_items');
        Schema::dropIfExists('sponsor_comparisons');
        Schema::dropIfExists('sponsor_saved_events');
        Schema::dropIfExists('sponsor_proposals');
        Schema::dropIfExists('sponsor_budgets');
    }
};
