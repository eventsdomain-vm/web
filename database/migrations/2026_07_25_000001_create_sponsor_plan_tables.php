<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Sponsor Objectives
        Schema::create('sponsor_objectives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('objective_type', ['brand_awareness', 'lead_generation', 'sales_conversion', 'csr', 'product_launch', 'market_entry', 'other'])->default('brand_awareness');
            $table->decimal('target_kpi_value', 15, 2)->nullable();
            $table->string('kpi_unit')->nullable();
            $table->decimal('estimated_cost', 15, 2)->nullable();
            $table->decimal('estimated_roi', 15, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->index('sponsor_id', 'idx_sponsor_objectives_sponsor_id');
            $table->index('objective_type', 'idx_sponsor_objectives_type');
        });

        // Sponsor Preferences / Targeting
        Schema::create('sponsor_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained()->cascadeOnDelete();
            $table->json('target_audience_demographics')->nullable();
            $table->json('category_preferences')->nullable();
            $table->json('event_types')->nullable();
            $table->json('geographic_preferences')->nullable();
            $table->json('budget_range')->nullable();
            $table->enum('formats_preferred', ['title', 'presenting', 'booth', 'digital', 'virtual', 'sponsorship_rights'])->nullable();
            $table->json('industry_targets')->nullable();
            $table->integer('min_audience_size')->nullable();
            $table->integer('max_audience_size')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['sponsor_id'], 'uk_sponsor_preferences_sponsor_id');
        });

        // Sponsor Budget Allocations
        Schema::create('sponsor_budget_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained()->cascadeOnDelete();
            $table->string('fiscal_year');
            $table->json('category_allocations')->nullable();
            $table->decimal('total_budget', 15, 2);
            $table->decimal('allocated_so_far', 15, 2)->default(0);
            $table->enum('status', ['draft', 'approved', 'active', 'closed'])->default('draft');
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_to')->nullable();
            $table->timestamps();
            $table->unique(['sponsor_id', 'fiscal_year'], 'uk_budget_allocations_year');
            $table->index(['sponsor_id', 'status'], 'idx_budget_allocations_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sponsor_budget_allocations');
        Schema::dropIfExists('sponsor_preferences');
        Schema::dropIfExists('sponsor_objectives');
    }
};
