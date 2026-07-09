<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // =========================================================================
        // ORGANIZATION & BRAND
        // =========================================================================

        // Brand profiles (a sponsor org can have multiple brands)
        Schema::create('sponsor_brands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tagline', 300)->nullable();
            $table->string('logo', 500)->nullable();
            $table->json('brand_colors')->nullable();
            $table->json('brand_guidelines')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->index('sponsor_id', 'idx_sponsor_brands_sponsor_id');
        });

        // =========================================================================
        // CAMPAIGN MANAGEMENT (advanced)
        // =========================================================================

        // Milestones on a campaign
        Schema::create('sponsor_campaign_milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('sponsor_campaigns')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('due_date')->nullable();
            $table->date('completed_at')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('campaign_id', 'idx_sp_campaign_milestones_campaign_id');
            $table->index(['campaign_id', 'completed_at'], 'idx_sp_campaign_milestones_progress');
        });

        // Brand assets with version control
        Schema::create('sponsor_brand_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('sponsor_brands')->cascadeOnDelete();
            $table->foreignId('campaign_id')->nullable()->constrained('sponsor_campaigns')->nullOnDelete();
            $table->string('name');
            $table->string('type', 50); // logo, banner, video, document, social_post, other
            $table->string('file_path', 500);
            $table->string('mime_type', 100)->nullable();
            $table->unsignedInteger('file_size')->nullable();
            $table->string('thumbnail_path', 500)->nullable();
            $table->text('tags')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();

            $table->index('brand_id', 'idx_sp_brand_assets_brand_id');
            $table->index('campaign_id', 'idx_sp_brand_assets_campaign_id');
            $table->index('type', 'idx_sp_brand_assets_type');
            if (Schema::getConnection()->getDriverName() !== 'sqlite') {
                $table->fullText(['name', 'tags'], 'ft_sp_brand_assets_search');
            }
        });

        // Asset version history
        Schema::create('sponsor_asset_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('sponsor_brand_assets')->cascadeOnDelete();
            $table->unsignedSmallInteger('version_number');
            $table->string('file_path', 500);
            $table->string('mime_type', 100)->nullable();
            $table->unsignedInteger('file_size')->nullable();
            $table->text('change_notes')->nullable();
            $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['asset_id', 'version_number'], 'uq_sp_asset_versions');
            $table->index('asset_id', 'idx_sp_asset_versions_asset_id');
        });

        // =========================================================================
        // NEGOTIATION & DEAL PIPELINE
        // =========================================================================

        // Negotiation sessions (formal multi-round deal-making)
        Schema::create('sponsor_negotiations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->unique();
            $table->foreignId('request_id')->constrained('sponsorship_requests')->cascadeOnDelete();
            $table->foreignId('initiated_by')->constrained('users')->cascadeOnDelete();
            $table->string('status', 30)->default('open'); // open, countering, accepted, declined, expired
            $table->decimal('current_offer', 15, 2)->nullable();
            $table->char('currency', 3)->default('INR');
            $table->text('terms_summary')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();

            $table->index('request_id', 'idx_sp_negotiations_request_id');
            $table->index('status', 'idx_sp_negotiations_status');
        });

        // Individual negotiation rounds / messages
        Schema::create('sponsor_negotiation_rounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('negotiation_id')->constrained('sponsor_negotiations')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('message');
            $table->decimal('offer', 15, 2)->nullable();
            $table->json('terms')->nullable();
            $table->timestamps();

            $table->index('negotiation_id', 'idx_sp_nego_rounds_negotiation_id');
        });

        // =========================================================================
        // CONTRACTS (advanced replacement for existing sponsorship_contracts)
        // =========================================================================

        // Augment sponsorship_contracts with versioning and amendments
        Schema::create('sponsor_contract_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('sponsorship_contracts')->cascadeOnDelete();
            $table->unsignedSmallInteger('version_number');
            $table->text('terms');
            $table->decimal('amount', 15, 2)->nullable();
            $table->json('clauses')->nullable();
            $table->text('change_summary')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['contract_id', 'version_number'], 'uq_sp_contract_versions');
            $table->index('contract_id', 'idx_sp_contract_versions_contract_id');
        });

        Schema::create('sponsor_contract_amendments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('sponsorship_contracts')->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('type', 50)->default('amendment'); // amendment, addendum, termination
            $table->string('status', 30)->default('draft'); // draft, signed, effective, expired
            $table->json('changed_clauses')->nullable();
            $table->decimal('amount_adjustment', 15, 2)->default(0);
            $table->date('effective_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->timestamp('signed_at')->nullable();
            $table->foreignId('signed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('contract_id', 'idx_sp_contract_amendments_contract_id');
            $table->index('status', 'idx_sp_contract_amendments_status');
        });

        // =========================================================================
        // FINANCIAL MANAGEMENT
        // =========================================================================

        // Invoices
        Schema::create('sponsor_invoices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->unique();
            $table->foreignId('contract_id')->nullable()->constrained('sponsorship_contracts')->nullOnDelete();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->foreignId('event_id')->nullable()->constrained('events')->nullOnDelete();
            $table->string('invoice_number', 50)->unique();
            $table->string('status', 30)->default('draft');
            // draft, sent, viewed, partially_paid, paid, overdue, cancelled, refunded
            $table->date('issue_date');
            $table->date('due_date');
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->decimal('amount_paid', 15, 2)->default(0);
            $table->char('currency', 3)->default('INR');
            $table->text('notes')->nullable();
            $table->text('terms')->nullable();
            $table->string('pdf_path', 500)->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('contract_id', 'idx_sp_invoices_contract_id');
            $table->index('sponsor_id', 'idx_sp_invoices_sponsor_id');
            $table->index('event_id', 'idx_sp_invoices_event_id');
            $table->index('status', 'idx_sp_invoices_status');
        });

        // Invoice line items
        Schema::create('sponsor_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('sponsor_invoices')->cascadeOnDelete();
            $table->string('description');
            $table->string('type', 50)->nullable(); // sponsorship, service, addon, etc.
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('unit_price', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->timestamps();

            $table->index('invoice_id', 'idx_sp_invoice_items_invoice_id');
        });

        // Payment schedules (for installment plans)
        Schema::create('sponsor_payment_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('sponsorship_contracts')->cascadeOnDelete();
            $table->unsignedTinyInteger('installment_number');
            $table->decimal('amount', 15, 2);
            $table->char('currency', 3)->default('INR');
            $table->date('due_date');
            $table->string('status', 30)->default('pending'); // pending, paid, overdue, cancelled
            $table->timestamp('paid_at')->nullable();
            $table->foreignId('invoice_id')->nullable()->constrained('sponsor_invoices')->nullOnDelete();
            $table->timestamps();

            $table->index('contract_id', 'idx_sp_payment_schedules_contract_id');
            $table->index('status', 'idx_sp_payment_schedules_status');
        });

        // Payment transaction records
        Schema::create('sponsor_payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->unique();
            $table->foreignId('invoice_id')->nullable()->constrained('sponsor_invoices')->nullOnDelete();
            $table->foreignId('schedule_id')->nullable()->constrained('sponsor_payment_schedules')->nullOnDelete();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->string('transaction_id', 200)->nullable();
            $table->string('gateway', 50)->nullable(); // razorpay, stripe, paypal, bank_transfer
            $table->string('type', 30)->default('payment'); // payment, refund, chargeback
            $table->decimal('amount', 15, 2);
            $table->char('currency', 3)->default('INR');
            $table->string('status', 30)->default('pending'); // pending, success, failed, refunded
            $table->json('gateway_response')->nullable();
            $table->text('failure_reason')->nullable();
            $table->timestamp('settled_at')->nullable();
            $table->timestamps();

            $table->index('invoice_id', 'idx_sp_payment_tx_invoice_id');
            $table->index('sponsor_id', 'idx_sp_payment_tx_sponsor_id');
            $table->index('status', 'idx_sp_payment_tx_status');
        });

        // Tax documents
        Schema::create('sponsor_tax_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->foreignId('invoice_id')->nullable()->constrained('sponsor_invoices')->nullOnDelete();
            $table->string('type', 50); // gst_invoice, tax_receipt, tds_certificate, etc.
            $table->string('document_number', 100)->nullable();
            $table->string('file_path', 500);
            $table->date('document_date')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('status', 30)->default('generated');
            $table->timestamps();

            $table->index('sponsor_id', 'idx_sp_tax_docs_sponsor_id');
            $table->index('type', 'idx_sp_tax_docs_type');
        });

        // Financial audit trail
        Schema::create('sponsor_financial_audit_trails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->morphs('auditable');
            $table->string('event_type', 50); // created, updated, paid, refunded, cancelled
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('sponsor_id', 'idx_sp_fin_audit_sponsor_id');
            $table->index(['auditable_type', 'auditable_id'], 'idx_sp_fin_audit_auditable');
            $table->index('event_type', 'idx_sp_fin_audit_event_type');
        });

        // =========================================================================
        // COLLABORATION & TASK MANAGEMENT
        // =========================================================================

        // Teams (groups within a sponsor org)
        Schema::create('sponsor_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('lead_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('sponsor_id', 'idx_sp_teams_sponsor_id');
            $table->index('lead_id', 'idx_sp_teams_lead_id');
        });

        // Add team_id to existing sponsor_team_members (via another migration)
        // Task management
        Schema::create('sponsor_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->foreignId('campaign_id')->nullable()->constrained('sponsor_campaigns')->nullOnDelete();
            $table->foreignId('contract_id')->nullable()->constrained('sponsorship_contracts')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('priority', 20)->default('medium'); // low, medium, high, urgent
            $table->string('status', 30)->default('todo'); // todo, in_progress, review, done, cancelled
            $table->date('due_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('sponsor_id', 'idx_sp_tasks_sponsor_id');
            $table->index('campaign_id', 'idx_sp_tasks_campaign_id');
            $table->index('status', 'idx_sp_tasks_status');
            $table->index('priority', 'idx_sp_tasks_priority');
        });

        // Task assignees
        Schema::create('sponsor_task_assignees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('sponsor_tasks')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['task_id', 'user_id'], 'uq_sp_task_assignees');
            $table->index('user_id', 'idx_sp_task_assignees_user_id');
        });

        // =========================================================================
        // APPROVAL WORKFLOWS
        // =========================================================================

        // Approval workflow configuration
        Schema::create('sponsor_approval_workflows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->string('name');
            $table->string('entity_type', 100); // proposal, contract, invoice, campaign, asset
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedTinyInteger('steps_required')->default(1);
            $table->timestamps();

            $table->index('sponsor_id', 'idx_sp_approval_wf_sponsor_id');
        });

        // Individual approval steps
        Schema::create('sponsor_approval_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workflow_id')->constrained('sponsor_approval_workflows')->cascadeOnDelete();
            $table->foreignId('approver_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('step_order');
            $table->string('action', 30)->default('approve'); // approve, review, verify
            $table->timestamps();

            $table->unique(['workflow_id', 'step_order'], 'uq_sp_approval_steps_order');
            $table->index('approver_id', 'idx_sp_approval_steps_approver_id');
        });

        // Active approval requests
        Schema::create('sponsor_approval_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workflow_id')->constrained('sponsor_approval_workflows')->cascadeOnDelete();
            $table->morphs('approvable');
            $table->foreignId('requested_by')->constrained('users')->cascadeOnDelete();
            $table->string('status', 30)->default('pending'); // pending, approved, rejected, cancelled
            $table->text('notes')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index('workflow_id', 'idx_sp_approval_req_workflow_id');
            $table->index(['approvable_type', 'approvable_id'], 'idx_sp_approval_req_approvable');
            $table->index('status', 'idx_sp_approval_req_status');
        });

        // Individual approvals within a request
        Schema::create('sponsor_approval_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('approval_request_id')->constrained('sponsor_approval_requests')->cascadeOnDelete();
            $table->foreignId('step_id')->constrained('sponsor_approval_steps')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('decision', 20); // approved, rejected, needs_changes
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->unique(['approval_request_id', 'step_id', 'user_id'], 'uq_sp_approval_responses');
            $table->index('user_id', 'idx_sp_approval_responses_user_id');
        });

        // =========================================================================
        // SHARED DOCUMENTS
        // =========================================================================

        Schema::create('sponsor_documents', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->unique();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->foreignId('campaign_id')->nullable()->constrained('sponsor_campaigns')->nullOnDelete();
            $table->foreignId('contract_id')->nullable()->constrained('sponsorship_contracts')->nullOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type', 50); // contract, proposal, report, creative, legal, other
            $table->string('file_path', 500);
            $table->string('mime_type', 100)->nullable();
            $table->unsignedInteger('file_size')->nullable();
            $table->string('status', 30)->default('draft'); // draft, final, archived
            $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();

            $table->index('sponsor_id', 'idx_sp_documents_sponsor_id');
            $table->index('campaign_id', 'idx_sp_documents_campaign_id');
            $table->index('type', 'idx_sp_documents_type');
        });

        Schema::create('sponsor_document_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('sponsor_documents')->cascadeOnDelete();
            $table->unsignedSmallInteger('version_number');
            $table->string('file_path', 500);
            $table->unsignedInteger('file_size')->nullable();
            $table->text('change_notes')->nullable();
            $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['document_id', 'version_number'], 'uq_sp_document_versions');
        });

        // =========================================================================
        // COMMUNICATION
        // =========================================================================

        // Announcements (internal to sponsor org or to event organizers)
        Schema::create('sponsor_announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('body');
            $table->string('type', 50)->default('general'); // general, campaign_update, contract, team, urgent
            $table->string('audience_type', 50)->default('internal'); // internal, cross_org, public
            $table->string('status', 30)->default('draft'); // draft, published, archived
            $table->timestamp('published_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();

            $table->index('sponsor_id', 'idx_sp_announcements_sponsor_id');
            $table->index('status', 'idx_sp_announcements_status');
        });

        // Read receipts for announcements
        Schema::create('sponsor_announcement_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('announcement_id')->constrained('sponsor_announcements')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('read_at');

            $table->unique(['announcement_id', 'user_id'], 'uq_sp_announcement_receipts');
            $table->index('user_id', 'idx_sp_announcement_receipts_user_id');
        });

        // =========================================================================
        // ADMINISTRATION & INTEGRATIONS
        // =========================================================================

        // Integration configurations
        Schema::create('sponsor_integrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->string('provider', 100); // zapier, hubspot, salesforce, slack, google_analytics
            $table->string('name')->nullable();
            $table->string('type', 50); // crm, analytics, communication, automation, payment
            $table->json('config')->nullable();
            $table->json('credentials')->nullable();
            $table->string('status', 30)->default('disconnected'); // connected, disconnected, error
            $table->timestamp('last_synced_at')->nullable();
            $table->text('last_error')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('sponsor_id', 'idx_sp_integrations_sponsor_id');
            $table->index('provider', 'idx_sp_integrations_provider');
        });

        // Integration sync logs
        Schema::create('sponsor_integration_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('integration_id')->constrained('sponsor_integrations')->cascadeOnDelete();
            $table->string('event', 100); // sync_started, sync_completed, sync_failed, webhook_received
            $table->text('details')->nullable();
            $table->string('status', 30)->default('success'); // success, error, warning
            $table->unsignedInteger('records_processed')->default(0);
            $table->timestamps();

            $table->index('integration_id', 'idx_sp_integration_logs_integration_id');
        });

        // Audit logs
        Schema::create('sponsor_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action', 100); // created, updated, deleted, viewed, exported, logged_in
            $table->morphs('auditable');
            $table->text('description')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index('sponsor_id', 'idx_sp_audit_logs_sponsor_id');
            $table->index('user_id', 'idx_sp_audit_logs_user_id');
            $table->index('action', 'idx_sp_audit_logs_action');
            $table->index(['auditable_type', 'auditable_id'], 'idx_sp_audit_logs_auditable');
            $table->index('created_at', 'idx_sp_audit_logs_created_at');
        });
    }

    public function down(): void
    {
        $tables = [
            'sponsor_audit_logs',
            'sponsor_integration_logs',
            'sponsor_integrations',
            'sponsor_announcement_receipts',
            'sponsor_announcements',
            'sponsor_document_versions',
            'sponsor_documents',
            'sponsor_approval_responses',
            'sponsor_approval_requests',
            'sponsor_approval_steps',
            'sponsor_approval_workflows',
            'sponsor_task_assignees',
            'sponsor_tasks',
            'sponsor_teams',
            'sponsor_financial_audit_trails',
            'sponsor_tax_documents',
            'sponsor_payment_transactions',
            'sponsor_payment_schedules',
            'sponsor_invoice_items',
            'sponsor_invoices',
            'sponsor_contract_amendments',
            'sponsor_contract_versions',
            'sponsor_negotiation_rounds',
            'sponsor_negotiations',
            'sponsor_asset_versions',
            'sponsor_brand_assets',
            'sponsor_campaign_milestones',
            'sponsor_brands',
        ];

        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }
    }
};
