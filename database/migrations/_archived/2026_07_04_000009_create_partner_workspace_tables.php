<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partner_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('company_name')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('tax_id', 50)->nullable();
            $table->string('business_type', 50)->nullable();
            $table->unsignedSmallInteger('years_of_experience')->nullable();
            $table->unsignedSmallInteger('team_size')->nullable();
            $table->string('website')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->text('bio')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });

        Schema::create('partner_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('sponsor_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('assigned_at')->nullable();
            $table->string('role', 50)->nullable();
            $table->string('status', 20)->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['partner_id', 'sponsor_id']);
        });

        Schema::create('partner_leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('sponsor_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('event_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('source', 50)->default('marketplace');
            $table->string('stage', 30)->default('new');
            $table->decimal('value', 12, 2)->nullable();
            $table->unsignedTinyInteger('probability')->nullable();
            $table->string('priority', 20)->default('medium');
            $table->date('expected_close_date')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('converted_at')->nullable();
            $table->string('lost_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('partner_deals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('lead_id')->nullable()->constrained('partner_leads')->nullOnDelete();
            $table->foreignId('sponsor_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('event_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('stage', 30)->default('qualification');
            $table->decimal('deal_value', 12, 2)->nullable();
            $table->decimal('commission_rate', 5, 2)->nullable();
            $table->date('expected_close_date')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->string('lost_reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('partner_meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('sponsor_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('deal_id')->nullable()->constrained('partner_deals')->nullOnDelete();
            $table->foreignId('lead_id')->nullable()->constrained('partner_leads')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type', 30)->default('online');
            $table->string('location')->nullable();
            $table->string('meeting_link')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('timezone', 50)->default('UTC');
            $table->string('status', 30)->default('scheduled');
            $table->text('notes')->nullable();
            $table->longText('minutes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('partner_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('deal_id')->nullable()->constrained('partner_deals')->nullOnDelete();
            $table->decimal('amount', 12, 2);
            $table->decimal('rate', 5, 2)->nullable();
            $table->string('status', 30)->default('pending');
            $table->text('description')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('disputed_reason')->nullable();
            $table->timestamps();
        });

        Schema::create('partner_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('users')->cascadeOnDelete();
            $table->morphs('notable');
            $table->text('content');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('partner_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('sponsor_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('deal_id')->nullable()->constrained('partner_deals')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('due_date')->nullable();
            $table->string('priority', 20)->default('medium');
            $table->string('status', 30)->default('pending');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('partner_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('causer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->nullableMorphs('subject');
            $table->string('event', 50);
            $table->json('properties')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['partner_id', 'created_at']);
        });

        Schema::create('partner_campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('deal_id')->nullable()->constrained('partner_deals')->nullOnDelete();
            $table->foreignId('sponsor_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('event_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('status', 30)->default('planning');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('budget', 12, 2)->nullable();
            $table->json('deliverables')->nullable();
            $table->json('branding')->nullable();
            $table->json('media_assets')->nullable();
            $table->unsignedInteger('attendance')->nullable();
            $table->decimal('engagement', 8, 2)->nullable();
            $table->text('media_coverage')->nullable();
            $table->json('roi_metrics')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partner_campaigns');
        Schema::dropIfExists('partner_activity_logs');
        Schema::dropIfExists('partner_tasks');
        Schema::dropIfExists('partner_notes');
        Schema::dropIfExists('partner_commissions');
        Schema::dropIfExists('partner_meetings');
        Schema::dropIfExists('partner_deals');
        Schema::dropIfExists('partner_leads');
        Schema::dropIfExists('partner_assignments');
        Schema::dropIfExists('partner_profiles');
    }
};
