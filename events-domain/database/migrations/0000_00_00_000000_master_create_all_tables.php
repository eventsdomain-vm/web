<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * MASTER MIGRATION — Single-file schema for migrate:fresh.
 *
 * Consolidates all 68 individual migrations into their final state.
 * Resolves: duplicate partner systems, duplicate profiles, empty stubs,
 * identical-structure tables, dead columns, and FK inconsistencies.
 *
 * Dropped vs original:
 *   - internal_links (empty stub)
 *   - search_indexes (empty stub)
 *   - event_media (no code refs; event_gallery kept)
 *   - users.verified (dead; is_verified used everywhere)
 *   - event_stalls / event_fnb_options / event_ad_spaces → merged into event_extras
 */
return new class extends Migration
{
    public function up(): void
    {
        // =====================================================================
        // CORE LARAVEL
        // =====================================================================

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            // Profile fields (2026_07_02_000000)
            $table->string('mobile', 20)->nullable()->after('password');
            $table->timestamp('mobile_verified_at')->nullable()->after('mobile');
            $table->boolean('is_verified')->default(false)->after('mobile_verified_at');
            $table->string('avatar', 500)->nullable()->after('is_verified');
            $table->string('phone', 20)->nullable()->after('avatar');
            $table->string('provider', 50)->nullable()->after('phone');
            $table->string('provider_id')->nullable()->after('provider');
            $table->text('provider_token')->nullable()->after('provider_id');
            $table->text('provider_refresh_token')->nullable()->after('provider_token');

            // Company fields (2026_07_03_000003)
            $table->string('company_name', 255)->nullable()->after('phone');
            $table->string('company_logo', 500)->nullable()->after('company_name');
            $table->string('company_website', 500)->nullable()->after('company_logo');
            $table->text('company_description')->nullable()->after('company_website');
            $table->string('industry', 100)->nullable()->after('company_description');
            $table->string('company_size', 50)->nullable()->after('industry');
            $table->year('year_established')->nullable()->after('company_size');
            $table->string('gst_number', 50)->nullable()->after('year_established');
            $table->string('pan_number', 50)->nullable()->after('gst_number');
            // verified/verified_at DROPPED — is_verified is the canonical column
            $table->boolean('is_featured')->default(false)->after('pan_number');
            $table->json('badges')->nullable()->after('is_featured');

            // 2FA (2026_07_04_000006)
            $table->boolean('two_factor_enabled')->default(false)->after('is_verified');

            $table->timestamps();

            $table->index(['provider', 'provider_id'], 'idx_users_provider');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration')->index();
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration')->index();
        });

        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->text('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable()->index();
            $table->timestamps();
        });

        // =====================================================================
        // SPATIE MEDIA LIBRARY
        // =====================================================================

        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->uuid()->nullable()->unique();
            $table->string('collection_name');
            $table->string('name');
            $table->string('file_name');
            $table->string('mime_type')->nullable();
            $table->string('disk');
            $table->string('conversions_disk')->nullable();
            $table->unsignedBigInteger('size');
            $table->json('manipulations');
            $table->json('custom_properties');
            $table->json('generated_conversions');
            $table->json('responsive_images');
            $table->unsignedInteger('order_column')->nullable()->index();
            $table->nullableTimestamps();
        });

        // =====================================================================
        // SPATIE PERMISSIONS
        // =====================================================================

        $teams = config('permission.teams');
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $pivotRole = $columnNames['role_pivot_key'] ?? 'role_id';
        $pivotPermission = $columnNames['permission_pivot_key'] ?? 'permission_id';

        Schema::create($tableNames['permissions'], static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });

        Schema::create($tableNames['roles'], static function (Blueprint $table) use ($teams, $columnNames) {
            $table->bigIncrements('id');
            if ($teams || config('permission.testing')) {
                $table->unsignedBigInteger($columnNames['team_foreign_key'])->nullable();
                $table->index($columnNames['team_foreign_key'], 'roles_team_foreign_key_index');
            }
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
            if ($teams || config('permission.testing')) {
                $table->unique([$columnNames['team_foreign_key'], 'name', 'guard_name']);
            } else {
                $table->unique(['name', 'guard_name']);
            }
        });

        Schema::create($tableNames['model_has_permissions'], static function (Blueprint $table) use ($tableNames, $columnNames, $pivotPermission, $teams) {
            $table->unsignedBigInteger($pivotPermission);
            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');
            $table->foreign($pivotPermission)->references('id')->on($tableNames['permissions'])->onDelete('cascade');
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'model_has_permissions_team_foreign_key_index');
                $table->primary([$columnNames['team_foreign_key'], $pivotPermission, $columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_permission_model_type_primary');
            } else {
                $table->primary([$pivotPermission, $columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_permission_model_type_primary');
            }
        });

        Schema::create($tableNames['model_has_roles'], static function (Blueprint $table) use ($tableNames, $columnNames, $pivotRole, $teams) {
            $table->unsignedBigInteger($pivotRole);
            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');
            $table->foreign($pivotRole)->references('id')->on($tableNames['roles'])->onDelete('cascade');
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'model_has_roles_team_foreign_key_index');
                $table->primary([$columnNames['team_foreign_key'], $pivotRole, $columnNames['model_morph_key'], 'model_type'], 'model_has_roles_role_model_type_primary');
            } else {
                $table->primary([$pivotRole, $columnNames['model_morph_key'], 'model_type'], 'model_has_roles_role_model_type_primary');
            }
        });

        Schema::create($tableNames['role_has_permissions'], static function (Blueprint $table) use ($tableNames, $pivotRole, $pivotPermission) {
            $table->unsignedBigInteger($pivotPermission);
            $table->unsignedBigInteger($pivotRole);
            $table->foreign($pivotPermission)->references('id')->on($tableNames['permissions'])->onDelete('cascade');
            $table->foreign($pivotRole)->references('id')->on($tableNames['roles'])->onDelete('cascade');
            $table->primary([$pivotPermission, $pivotRole], 'role_has_permissions_permission_id_role_id_primary');
        });

        // =====================================================================
        // PLATFORM / SETTINGS / CMS
        // =====================================================================

        Schema::create('platform_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string');
            $table->string('group')->default('general');
            $table->timestamps();
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action');
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->text('description')->nullable();
            $table->json('properties')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
            $table->index(['subject_type', 'subject_id']);
            $table->index('action');
            $table->index('created_at');
        });

        Schema::create('cms_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });

        // =====================================================================
        // SEO
        // =====================================================================

        Schema::create('seo_settings', function (Blueprint $table) {
            $table->id();
            $table->string('seoable_type');
            $table->unsignedBigInteger('seoable_id');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('og_type')->default('website');
            $table->string('twitter_card')->default('summary_large_image');
            $table->string('twitter_title')->nullable();
            $table->text('twitter_description')->nullable();
            $table->string('twitter_image')->nullable();
            $table->string('robots_directive')->default('index,follow');
            $table->json('structured_data')->nullable();
            $table->string('focus_keyword')->nullable();
            $table->decimal('seo_score', 5, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['seoable_type', 'seoable_id']);
            $table->index(['seoable_type', 'seoable_id']);
        });

        Schema::create('seo_audits', function (Blueprint $table) {
            $table->id();
            $table->string('auditable_type');
            $table->unsignedBigInteger('auditable_id');
            $table->string('url')->nullable();
            $table->json('results')->nullable();
            $table->integer('score')->default(0);
            $table->integer('critical_issues')->default(0);
            $table->integer('warnings')->default(0);
            $table->integer('notices')->default(0);
            $table->json('issues')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->index(['auditable_type', 'auditable_id']);
            $table->index('score');
        });

        Schema::create('redirects', function (Blueprint $table) {
            $table->id();
            $table->string('source_url');
            $table->string('target_url');
            $table->string('type')->default('301');
            $table->boolean('is_active')->default(true);
            $table->string('description')->nullable();
            $table->unsignedBigInteger('hit_count')->default(0);
            $table->timestamp('last_hit_at')->nullable();
            $table->timestamps();
            $table->unique('source_url');
            $table->index('target_url');
            $table->index('is_active');
        });

        // =====================================================================
        // TAXONOMY
        // =====================================================================

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon', 100)->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index('parent_id', 'idx_categories_parent_id');
            $table->index('is_active', 'idx_categories_is_active');
            $table->index('sort_order', 'idx_categories_sort_order');
        });

        Schema::create('category_field_definitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->cascadeOnDelete();
            $table->string('section_key', 80);
            $table->string('field_key', 80)->nullable();
            $table->string('label', 150)->nullable();
            $table->enum('input_type', [
                'text', 'textarea', 'number', 'date', 'time', 'select',
                'multiselect', 'boolean', 'repeater', 'media',
            ])->nullable();
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_required')->default(false);
            $table->json('options')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->unique(['category_id', 'section_key', 'field_key'], 'uk_cfd_cat_section_field');
            $table->index('category_id', 'idx_cfd_category');
        });

        Schema::create('amenities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('slug', 120)->unique();
            $table->string('icon', 100)->nullable();
            $table->string('group', 80)->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // =====================================================================
        // LOOKUP TABLES
        // =====================================================================

        Schema::create('audience_types', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('label');
            $table->timestamps();
        });

        Schema::create('age_groups', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('label');
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('industries', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('label');
            $table->timestamps();
        });

        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->unsignedTinyInteger('image_limit');
            $table->string('analytics_level')->default('basic');
            $table->boolean('featured_badge')->default(false);
            $table->boolean('priority_listing')->default(false);
            $table->boolean('social_promotion')->default(false);
            $table->boolean('homepage_featured')->default(false);
            $table->unsignedSmallInteger('listing_duration_days')->default(90);
            $table->timestamps();
        });

        Schema::create('participant_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80);
            $table->string('slug', 80)->unique();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // =====================================================================
        // USER PROFILES & SOCIAL ACCOUNTS
        // =====================================================================

        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('role_type', ['organizer', 'sponsor', 'partner']);
            $table->string('company_name')->nullable();
            $table->text('description')->nullable();
            $table->string('website', 500)->nullable();
            $table->json('social_links')->nullable();
            $table->string('location')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->boolean('is_verified')->default(false);
            // GST fields (2026_07_02_100001)
            $table->string('gst_number', 15)->nullable()->after('country');
            $table->boolean('gst_verified')->default(false)->after('gst_number');
            $table->timestamp('gst_verified_at')->nullable()->after('gst_verified');
            $table->string('gst_legal_name')->nullable()->after('gst_verified_at');
            $table->timestamps();
            $table->index('user_id', 'idx_profiles_user_id');
            $table->index('role_type', 'idx_profiles_role_type');
            $table->index('gst_number', 'idx_profiles_gst_number');
        });

        Schema::create('otp_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('otp_code');
            $table->enum('channel', ['sms', 'whatsapp', 'email']);
            $table->timestamp('expires_at');
            $table->integer('attempts')->default(0);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            $table->index('user_id', 'idx_otp_user_id');
            $table->index('expires_at', 'idx_otp_expires_at');
        });

        Schema::create('social_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('provider', ['linkedin', 'facebook', 'instagram', 'youtube']);
            $table->string('provider_id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('avatar', 500)->nullable();
            $table->text('access_token');
            $table->text('refresh_token')->nullable();
            $table->timestamp('token_expires_at')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'provider', 'provider_id'], 'uk_social_accounts_provider_user');
            $table->index('provider', 'idx_social_accounts_provider');
        });

        // =====================================================================
        // PARTICIPANTS
        // =====================================================================

        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type', 80)->nullable();
            $table->text('bio')->nullable();
            $table->string('image', 500)->nullable();
            $table->string('website', 500)->nullable();
            $table->json('social_links')->nullable();
            $table->string('organization')->nullable();
            $table->string('designation')->nullable();
            $table->string('company')->nullable();
            $table->softDeletes();
            $table->timestamps();
            if (Schema::getConnection()->getDriverName() !== 'sqlite') {
                $table->fullText(['name', 'bio', 'organization'], 'ft_participants_search');
            }
        });

        // =====================================================================
        // EVENTS (core + marketplace + contact fields)
        // =====================================================================

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->unique();

            // Identity & taxonomy
            $table->foreignId('organizer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->foreignId('subcategory_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('tagline', 500)->nullable();
            $table->text('description');

            // Format & workflow
            $table->enum('event_type', ['physical', 'virtual', 'hybrid'])->default('physical');
            $table->enum('visibility', ['public', 'unlisted', 'private'])->default('public');
            $table->enum('approval_status', ['draft', 'pending', 'approved', 'rejected', 'changes_requested'])->default('draft');
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected', 'live', 'completed', 'cancelled'])->default('draft');
            $table->text('rejection_reason')->nullable();

            // Locale & money
            $table->string('timezone', 64)->default('Asia/Kolkata');
            $table->char('currency', 3)->default('INR');
            $table->decimal('budget_min', 15, 2)->nullable();
            $table->decimal('budget_max', 15, 2)->nullable();
            $table->decimal('minimum_sponsorship', 15, 2)->nullable();
            $table->decimal('maximum_sponsorship', 15, 2)->nullable();
            $table->enum('sponsorship_type', ['paid', 'barter', 'hybrid'])->default('paid');
            $table->enum('plan', ['basic', 'featured', 'homepage'])->default('basic')->after('sponsorship_type');

            // Audience & registration
            $table->unsignedInteger('expected_audience')->nullable();
            // Marketplace audience targeting (2026_07_03_000002)
            $table->string('target_age_group', 20)->nullable()->after('expected_audience');
            $table->string('target_gender', 10)->nullable()->after('target_age_group');
            $table->text('audience_description')->nullable();
            $table->date('registration_deadline')->nullable();
            $table->string('registration_url', 500)->nullable();
            $table->string('website_url', 500)->nullable();
            // Contact fields (2026_07_08_000021)
            $table->string('contact_no', 30)->nullable()->after('website_url');
            $table->string('contact_email', 255)->nullable()->after('contact_no');
            $table->string('video_url', 500)->nullable();

            // Social / online presence (2026_07_03_000002)
            $table->unsignedInteger('instagram_reach')->nullable()->after('video_url');
            $table->unsignedInteger('youtube_reach')->nullable()->after('instagram_reach');
            $table->unsignedInteger('website_traffic')->nullable()->after('youtube_reach');

            // Event quality signals (2026_07_03_000002)
            $table->boolean('has_celebrity')->default(false)->after('website_traffic');
            $table->boolean('has_govt_support')->default(false)->after('has_celebrity');
            $table->boolean('has_media_coverage')->default(false)->after('has_govt_support');
            $table->string('venue_type', 100)->nullable()->after('has_media_coverage');
            $table->decimal('ticket_price_min', 10, 2)->nullable()->after('venue_type');
            $table->decimal('ticket_price_max', 10, 2)->nullable()->after('ticket_price_min');
            $table->text('previous_sponsors')->nullable()->after('ticket_price_max');
            $table->decimal('health_score', 5, 2)->nullable()->after('previous_sponsors');
            $table->timestamp('health_score_updated_at')->nullable()->after('health_score');

            // Legacy media fallbacks
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

            // Summary / cache columns
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->dateTime('next_occurrence_at')->nullable();
            $table->string('venue')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->decimal('primary_latitude', 10, 7)->nullable();
            $table->decimal('primary_longitude', 10, 7)->nullable();

            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index('organizer_id', 'idx_events_organizer_id');
            $table->index('category_id', 'idx_events_category_id');
            $table->index('subcategory_id', 'idx_events_subcategory_id');
            $table->index('approval_status', 'idx_events_approval_status');
            $table->index('status', 'idx_events_status');
            $table->index('city', 'idx_events_city');
            $table->index('next_occurrence_at', 'idx_events_next_occurrence');
            $table->index(['approval_status', 'is_published', 'is_featured', 'start_date'], 'idx_events_listing');
            $table->index(['category_id', 'city', 'start_date'], 'idx_events_cat_city_date');
            $table->index(['event_type', 'sponsorship_type'], 'idx_events_type_sponsorship');
            if (Schema::getConnection()->getDriverName() !== 'sqlite') {
                $table->fullText(['title', 'tagline', 'description'], 'ft_events_search');
            }
        });

        // =====================================================================
        // EVENT SCHEDULE & VENUES
        // =====================================================================

        Schema::create('event_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('label', 150)->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('timezone', 64)->nullable();
            $table->boolean('all_day')->default(false);
            $table->integer('sort_order')->default(0);
            $table->string('recurrence_rule', 255)->nullable();
            $table->date('recurrence_until')->nullable();
            $table->timestamps();
            $table->index('event_id', 'idx_event_dates_event_id');
            $table->index(['event_id', 'start_date', 'start_time'], 'idx_event_dates_event_start');
            $table->index('start_date', 'idx_event_dates_start_date');
        });

        Schema::create('event_venues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->enum('venue_type', ['physical', 'virtual', 'hybrid'])->default('physical');
            $table->string('venue_name')->nullable();
            $table->string('address', 500)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('virtual_url', 500)->nullable();
            $table->string('virtual_platform', 100)->nullable();
            $table->boolean('is_primary')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->index('event_id', 'idx_event_venues_event_id');
            $table->index(['city', 'country'], 'idx_event_venues_city_country');
            $table->index(['event_id', 'is_primary'], 'idx_event_venues_primary');
        });

        Schema::create('event_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('event_venue_id')->nullable()->constrained('event_venues')->nullOnDelete();
            $table->string('name', 150);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->index('event_id', 'idx_event_stages_event');
        });

        Schema::create('event_schedule', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('event_date_id')->nullable()->constrained('event_dates')->nullOnDelete();
            $table->foreignId('stage_id')->nullable()->constrained('event_stages')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('speaker')->nullable();
            $table->string('venue')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->index('event_id', 'idx_schedule_event');
            $table->index('event_date_id', 'idx_schedule_date');
            $table->index('stage_id', 'idx_schedule_stage');
        });

        Schema::create('event_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('participant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('participant_type_id')->constrained()->restrictOnDelete();
            $table->foreignId('event_date_id')->nullable()->constrained('event_dates')->nullOnDelete();
            $table->string('role_label', 150)->nullable();
            $table->string('session_title')->nullable();
            $table->dateTime('performance_start')->nullable();
            $table->dateTime('performance_end')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->unique(['event_id', 'participant_id', 'participant_type_id'], 'uk_event_participants');
            $table->index('participant_id', 'idx_ep_participant');
            $table->index('participant_type_id', 'idx_ep_type');
            $table->index(['event_id', 'sort_order'], 'idx_ep_event_sort');
        });

        // =====================================================================
        // EVENT CONTENT
        // =====================================================================

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

        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->morphs('linkable');
            $table->string('platform', 50);
            $table->string('url', 500);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // =====================================================================
        // EVENT EXTRAS (merged: stalls + fnb + ad_spaces)
        // =====================================================================

        Schema::create('event_extras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['stall', 'fnb', 'ad_space']);
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->timestamps();
            $table->index('event_id', 'idx_event_extras_event');
            $table->index('type', 'idx_event_extras_type');
        });

        // =====================================================================
        // EVENT AUDIENCE
        // =====================================================================

        Schema::create('event_audience', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->json('audience_types')->nullable();
            $table->json('age_groups')->nullable();
            $table->string('gender_composition')->nullable();
            $table->string('income_level')->nullable();
            $table->string('geographic_reach')->nullable();
            $table->text('target_market_summary')->nullable();
            $table->json('industry_alignment')->nullable();
            $table->timestamps();
        });

        // =====================================================================
        // EVENT SPONSORSHIP LEVELS
        // =====================================================================

        Schema::create('event_sponsorship_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->enum('level', ['title', 'co_sponsor', 'associate', 'powered_by', 'media_partner']);
            $table->timestamps();
        });

        // =====================================================================
        // EVENT DRAFTS (multi-step wizard)
        // =====================================================================

        Schema::create('event_drafts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('current_step')->default(1);
            $table->json('data')->nullable();
            $table->timestamps();
        });

        // =====================================================================
        // SPONSORS
        // =====================================================================

        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo', 500)->nullable();
            $table->string('website', 500)->nullable();
            $table->string('industry', 120)->nullable();
            // Org fields (2026_07_04_000008)
            $table->string('org_type', 100)->nullable()->after('industry');
            $table->string('registration_number', 100)->nullable()->after('org_type');
            $table->string('tax_id', 100)->nullable()->after('registration_number');
            $table->string('headquarters', 255)->nullable()->after('tax_id');
            $table->string('business_email', 255)->nullable()->after('headquarters');
            $table->string('business_phone', 50)->nullable()->after('business_email');
            $table->string('timezone', 100)->nullable()->after('business_phone');
            $table->string('default_currency', 10)->default('INR')->after('timezone');
            $table->string('fiscal_year', 20)->nullable()->after('default_currency');
            $table->string('org_status', 50)->default('active')->after('fiscal_year');
            $table->text('description')->nullable();
            $table->json('social_links')->nullable();
            $table->boolean('is_verified')->default(false);
            // SSO fields (2026_07_04_000006)
            $table->string('sso_provider', 50)->nullable()->after('is_verified');
            $table->string('sso_client_id', 500)->nullable()->after('sso_provider');
            $table->text('sso_client_secret')->nullable()->after('sso_client_id');
            $table->boolean('sso_enabled')->default(false)->after('sso_client_secret');
            $table->softDeletes();
            $table->timestamps();
            $table->index('user_id', 'idx_sponsors_user_id');
            if (Schema::getConnection()->getDriverName() !== 'sqlite') {
                $table->fullText(['name', 'description'], 'ft_sponsors_search');
            }
        });

        // =====================================================================
        // SPONSORSHIP PACKAGES & BENEFITS
        // =====================================================================

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
            // benefits JSON DROPPED — use sponsorship_benefits table
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

        // =====================================================================
        // SPONSORSHIP OPPORTUNITIES
        // =====================================================================

        Schema::create('sponsorship_opportunities', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->unique();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sponsor_package_id')->nullable()->constrained('sponsor_packages')->nullOnDelete();
            $table->string('title');
            $table->enum('type', ['advertising_space', 'food_partnership', 'content_addon', 'naming_rights', 'booth', 'other']);
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

        // =====================================================================
        // SPONSORSHIP REQUESTS → FIX: sponsor_id FKs to sponsors (not users)
        // =====================================================================

        Schema::create('sponsorship_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->foreignId('package_id')->nullable()->constrained('sponsor_packages')->nullOnDelete();
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

        // =====================================================================
        // SPONSORSHIP CONTRACTS
        // =====================================================================

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

        // =====================================================================
        // PARTNER SERVICES (marketplace)
        // =====================================================================

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

        // =====================================================================
        // PARTNERS (marketplace listing / discovery)
        // =====================================================================

        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_verified')->default(false)->after('user_id');
            $table->string('company_name');
            $table->string('logo_path')->nullable();
            $table->string('website')->nullable();
            $table->string('contact_person');
            $table->string('contact_email');
            $table->string('contact_phone', 20)->nullable();
            $table->string('city')->nullable();
            $table->string('country')->default('India');
            $table->enum('budget_range', ['under_50k', '50k_1l', '1l_5l', '5l_25l', '25l_plus'])->nullable();
            $table->enum('preferred_sponsorship_type', ['cash', 'barter', 'paid_barter'])->default('cash');
            $table->text('about')->nullable();
            $table->decimal('rating', 3, 2)->default(0)->after('about');
            $table->unsignedInteger('reviews_count')->default(0)->after('rating');
            $table->enum('status', ['active', 'inactive', 'pending_verification'])->default('pending_verification');
            $table->timestamps();
        });

        Schema::create('partner_industry', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('partners')->cascadeOnDelete();
            $table->foreignId('industry_id')->constrained()->cascadeOnDelete();
            $table->unique(['partner_id', 'industry_id']);
        });

        Schema::create('partner_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('partners')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->unique(['partner_id', 'category_id']);
        });

        Schema::create('partner_city', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('partners')->cascadeOnDelete();
            $table->string('city');
            $table->unique(['partner_id', 'city']);
        });

        Schema::create('partner_enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('company_name');
            $table->string('partnership_type');
            $table->string('partnership_type_label')->nullable();
            $table->text('message');
            $table->timestamps();
        });

        // =====================================================================
        // COMMUNICATION
        // =====================================================================

        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['direct', 'sponsorship', 'partnership'])->default('direct');
            $table->timestamps();
            $table->index('event_id', 'idx_conversations_event_id');
            $table->index('type', 'idx_conversations_type');
        });

        Schema::create('conversation_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('last_read_at')->nullable();
            $table->timestamps();
            $table->unique(['conversation_id', 'user_id'], 'uk_conv_participants_conv_user');
            $table->index('user_id', 'idx_conv_participants_user_id');
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->text('content');
            $table->string('attachment_url', 500)->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->index('conversation_id', 'idx_messages_conversation_id');
            $table->index('sender_id', 'idx_messages_sender_id');
            $table->index('created_at', 'idx_messages_created_at');
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->json('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->index('read_at', 'idx_notifications_read_at');
        });

        Schema::create('event_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->json('platforms');
            $table->json('content');
            $table->enum('status', ['draft', 'scheduled', 'publishing', 'published', 'partial', 'failed'])->default('draft');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamps();
            $table->index('event_id', 'idx_event_posts_event_id');
            $table->index('user_id', 'idx_event_posts_user_id');
            $table->index('status', 'idx_event_posts_status');
        });

        Schema::create('post_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_post_id')->constrained('event_posts')->cascadeOnDelete();
            $table->string('platform', 50);
            $table->enum('status', ['success', 'failed']);
            $table->text('response')->nullable();
            $table->text('error_message')->nullable();
            // Reach columns (2026_07_02_000016)
            $table->unsignedBigInteger('reach_impressions')->nullable()->after('error_message');
            $table->unsignedBigInteger('reach_reach')->nullable()->after('reach_impressions');
            $table->unsignedBigInteger('engagement_likes')->default(0)->after('reach_reach');
            $table->unsignedBigInteger('engagement_comments')->default(0)->after('engagement_likes');
            $table->unsignedBigInteger('engagement_shares')->default(0)->after('engagement_comments');
            $table->string('post_url', 500)->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->index('event_post_id', 'idx_post_logs_event_post_id');
            $table->index('platform', 'idx_post_logs_platform');
            $table->index('status', 'idx_post_logs_status');
        });

        // =====================================================================
        // SEO / MARKETING
        // =====================================================================

        Schema::create('keywords', function (Blueprint $table) {
            $table->id();
            $table->string('keyword');
            $table->string('category')->nullable();
            $table->enum('competition_level', ['low', 'medium', 'high'])->default('medium');
            $table->unsignedInteger('monthly_search_volume')->default(0);
            $table->unsignedTinyInteger('difficulty_score')->default(0);
            $table->enum('intent', ['informational', 'transactional', 'navigational', 'commercial'])->default('informational');
            $table->timestamps();
            $table->index('category', 'idx_keywords_category');
            $table->index('competition_level', 'idx_keywords_competition');
            $table->index('intent', 'idx_keywords_intent');
            $table->index('monthly_search_volume', 'idx_keywords_volume');
            if (Schema::getConnection()->getDriverName() !== 'sqlite') {
                $table->fullText('keyword', 'ft_keywords_search');
            }
        });

        Schema::create('search_logs', function (Blueprint $table) {
            $table->id();
            $table->string('query');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->unsignedInteger('results_count')->default(0);
            $table->timestamps();
            $table->index('user_id', 'idx_search_logs_user_id');
            $table->index('query', 'idx_search_logs_query');
            $table->index('created_at', 'idx_search_logs_created_at');
        });

        Schema::create('crawl_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('target_url', 2048);
            $table->enum('status', ['pending', 'running', 'completed', 'failed'])->default('pending');
            $table->unsignedSmallInteger('response_code')->nullable();
            $table->string('page_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('headers_found')->nullable();
            $table->json('links_found')->nullable();
            $table->json('errors')->nullable();
            $table->timestamps();
            $table->index('status', 'idx_crawl_jobs_status');
            $table->index('created_at', 'idx_crawl_jobs_created_at');
        });

        Schema::create('backlinks', function (Blueprint $table) {
            $table->id();
            $table->string('target_url', 2048);
            $table->string('source_url', 2048);
            $table->string('anchor_text')->nullable();
            $table->unsignedTinyInteger('domain_authority')->default(0);
            $table->enum('link_type', ['dofollow', 'nofollow', 'sponsored', 'ugc'])->default('dofollow');
            $table->enum('status', ['active', 'broken', 'pending'])->default('pending');
            $table->timestamps();
            $table->index('status', 'idx_backlinks_status');
            $table->index('domain_authority', 'idx_backlinks_da');
        });

        // =====================================================================
        // PAYMENTS
        // =====================================================================

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('payable_type')->nullable();
            $table->unsignedBigInteger('payable_id')->nullable();
            $table->string('gateway', 32)->default('razorpay');
            $table->string('gateway_order_id')->nullable()->unique();
            $table->string('gateway_payment_id')->nullable();
            $table->string('gateway_signature')->nullable();
            $table->decimal('amount', 15, 2);
            $table->decimal('base_amount', 15, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->char('currency', 3)->default('INR');
            $table->string('gst_number', 15)->nullable();
            $table->enum('status', ['created', 'pending', 'paid', 'failed', 'refunded'])->default('created');
            $table->json('metadata')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->index('user_id', 'idx_payments_user_id');
            $table->index('status', 'idx_payments_status');
            $table->index('gateway', 'idx_payments_gateway');
            $table->index(['payable_type', 'payable_id'], 'idx_payments_payable');
        });

        // =====================================================================
        // MARKETPLACE (sponsor side)
        // =====================================================================

        Schema::create('sponsor_budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('users')->cascadeOnDelete();
            $table->year('fiscal_year');
            $table->decimal('total_budget', 15, 2)->default(0);
            $table->decimal('allocated', 15, 2)->default(0);
            $table->decimal('spent', 15, 2)->default(0);
            $table->char('currency', 3)->default('INR');
            // Approval columns (2026_07_04_000002)
            $table->string('status', 30)->default('active');
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['sponsor_id', 'fiscal_year'], 'uk_sponsor_budget_year');
            $table->index('sponsor_id', 'idx_sponsor_budgets_sponsor_id');
            $table->index('status', 'idx_sp_budgets_status');
        });

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

        // =====================================================================
        // PARTNER WORKSPACE
        // =====================================================================

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

        // =====================================================================
        // SPONSOR WORKSPACE
        // =====================================================================

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

        Schema::create('sponsor_brand_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('sponsor_brands')->cascadeOnDelete();
            $table->foreignId('campaign_id')->nullable()->constrained('sponsor_campaigns')->nullOnDelete();
            $table->string('name');
            $table->string('type', 50);
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

        Schema::create('sponsor_negotiations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->unique();
            $table->foreignId('request_id')->constrained('sponsorship_requests')->cascadeOnDelete();
            $table->foreignId('initiated_by')->constrained('users')->cascadeOnDelete();
            $table->string('status', 30)->default('open');
            $table->decimal('current_offer', 15, 2)->nullable();
            $table->char('currency', 3)->default('INR');
            $table->text('terms_summary')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();
            $table->index('request_id', 'idx_sp_negotiations_request_id');
            $table->index('status', 'idx_sp_negotiations_status');
        });

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
            $table->string('type', 50)->default('amendment');
            $table->string('status', 30)->default('draft');
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

        Schema::create('sponsor_invoices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->unique();
            $table->foreignId('contract_id')->nullable()->constrained('sponsorship_contracts')->nullOnDelete();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->foreignId('event_id')->nullable()->constrained('events')->nullOnDelete();
            $table->string('invoice_number', 50)->unique();
            $table->string('status', 30)->default('draft');
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

        Schema::create('sponsor_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('sponsor_invoices')->cascadeOnDelete();
            $table->string('description');
            $table->string('type', 50)->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('unit_price', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->timestamps();
            $table->index('invoice_id', 'idx_sp_invoice_items_invoice_id');
        });

        Schema::create('sponsor_payment_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('sponsorship_contracts')->cascadeOnDelete();
            $table->unsignedTinyInteger('installment_number');
            $table->decimal('amount', 15, 2);
            $table->char('currency', 3)->default('INR');
            $table->date('due_date');
            $table->string('status', 30)->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->foreignId('invoice_id')->nullable()->constrained('sponsor_invoices')->nullOnDelete();
            $table->timestamps();
            $table->index('contract_id', 'idx_sp_payment_schedules_contract_id');
            $table->index('status', 'idx_sp_payment_schedules_status');
        });

        Schema::create('sponsor_payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->unique();
            $table->foreignId('invoice_id')->nullable()->constrained('sponsor_invoices')->nullOnDelete();
            $table->foreignId('schedule_id')->nullable()->constrained('sponsor_payment_schedules')->nullOnDelete();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->string('transaction_id', 200)->nullable();
            $table->string('gateway', 50)->nullable();
            $table->string('type', 30)->default('payment');
            $table->decimal('amount', 15, 2);
            $table->char('currency', 3)->default('INR');
            $table->string('status', 30)->default('pending');
            $table->json('gateway_response')->nullable();
            $table->text('failure_reason')->nullable();
            $table->timestamp('settled_at')->nullable();
            $table->timestamps();
            $table->index('invoice_id', 'idx_sp_payment_tx_invoice_id');
            $table->index('sponsor_id', 'idx_sp_payment_tx_sponsor_id');
            $table->index('status', 'idx_sp_payment_tx_status');
        });

        Schema::create('sponsor_tax_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->foreignId('invoice_id')->nullable()->constrained('sponsor_invoices')->nullOnDelete();
            $table->string('type', 50);
            $table->string('document_number', 100)->nullable();
            $table->string('file_path', 500);
            $table->date('document_date')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('status', 30)->default('generated');
            $table->timestamps();
            $table->index('sponsor_id', 'idx_sp_tax_docs_sponsor_id');
            $table->index('type', 'idx_sp_tax_docs_type');
        });

        Schema::create('sponsor_financial_audit_trails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->morphs('auditable');
            $table->string('event_type', 50);
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

        Schema::create('sponsor_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->foreignId('campaign_id')->nullable()->constrained('sponsor_campaigns')->nullOnDelete();
            $table->foreignId('contract_id')->nullable()->constrained('sponsorship_contracts')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('priority', 20)->default('medium');
            $table->string('status', 30)->default('todo');
            $table->date('due_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->index('sponsor_id', 'idx_sp_tasks_sponsor_id');
            $table->index('campaign_id', 'idx_sp_tasks_campaign_id');
            $table->index('status', 'idx_sp_tasks_status');
            $table->index('priority', 'idx_sp_tasks_priority');
        });

        Schema::create('sponsor_task_assignees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('sponsor_tasks')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['task_id', 'user_id'], 'uq_sp_task_assignees');
            $table->index('user_id', 'idx_sp_task_assignees_user_id');
        });

        Schema::create('sponsor_approval_workflows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->string('name');
            $table->string('entity_type', 100);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedTinyInteger('steps_required')->default(1);
            $table->timestamps();
            $table->index('sponsor_id', 'idx_sp_approval_wf_sponsor_id');
        });

        Schema::create('sponsor_approval_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workflow_id')->constrained('sponsor_approval_workflows')->cascadeOnDelete();
            $table->foreignId('approver_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('step_order');
            $table->string('action', 30)->default('approve');
            $table->timestamps();
            $table->unique(['workflow_id', 'step_order'], 'uq_sp_approval_steps_order');
            $table->index('approver_id', 'idx_sp_approval_steps_approver_id');
        });

        Schema::create('sponsor_approval_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workflow_id')->constrained('sponsor_approval_workflows')->cascadeOnDelete();
            $table->morphs('approvable');
            $table->foreignId('requested_by')->constrained('users')->cascadeOnDelete();
            $table->string('status', 30)->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
            $table->index('workflow_id', 'idx_sp_approval_req_workflow_id');
            $table->index(['approvable_type', 'approvable_id'], 'idx_sp_approval_req_approvable');
            $table->index('status', 'idx_sp_approval_req_status');
        });

        Schema::create('sponsor_approval_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('approval_request_id')->constrained('sponsor_approval_requests')->cascadeOnDelete();
            $table->foreignId('step_id')->constrained('sponsor_approval_steps')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('decision', 20);
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->unique(['approval_request_id', 'step_id', 'user_id'], 'uq_sp_approval_responses');
            $table->index('user_id', 'idx_sp_approval_responses_user_id');
        });

        Schema::create('sponsor_documents', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->unique();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->foreignId('campaign_id')->nullable()->constrained('sponsor_campaigns')->nullOnDelete();
            $table->foreignId('contract_id')->nullable()->constrained('sponsorship_contracts')->nullOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type', 50);
            $table->string('file_path', 500);
            $table->string('mime_type', 100)->nullable();
            $table->unsignedInteger('file_size')->nullable();
            $table->string('status', 30)->default('draft');
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

        Schema::create('sponsor_announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('body');
            $table->string('type', 50)->default('general');
            $table->string('audience_type', 50)->default('internal');
            $table->string('status', 30)->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();
            $table->index('sponsor_id', 'idx_sp_announcements_sponsor_id');
            $table->index('status', 'idx_sp_announcements_status');
        });

        Schema::create('sponsor_announcement_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('announcement_id')->constrained('sponsor_announcements')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('read_at');
            $table->unique(['announcement_id', 'user_id'], 'uq_sp_announcement_receipts');
            $table->index('user_id', 'idx_sp_announcement_receipts_user_id');
        });

        Schema::create('sponsor_integrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->string('provider', 100);
            $table->string('name')->nullable();
            $table->string('type', 50);
            $table->json('config')->nullable();
            $table->json('credentials')->nullable();
            $table->string('status', 30)->default('disconnected');
            $table->timestamp('last_synced_at')->nullable();
            $table->text('last_error')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->index('sponsor_id', 'idx_sp_integrations_sponsor_id');
            $table->index('provider', 'idx_sp_integrations_provider');
        });

        Schema::create('sponsor_integration_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('integration_id')->constrained('sponsor_integrations')->cascadeOnDelete();
            $table->string('event', 100);
            $table->text('details')->nullable();
            $table->string('status', 30)->default('success');
            $table->unsignedInteger('records_processed')->default(0);
            $table->timestamps();
            $table->index('integration_id', 'idx_sp_integration_logs_integration_id');
        });

        Schema::create('sponsor_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action', 100);
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

        Schema::create('sponsor_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->nullable()->constrained('sponsors')->nullOnDelete();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('recipient_id')->constrained('users')->cascadeOnDelete();
            $table->string('subject', 255)->nullable();
            $table->longText('body');
            $table->string('message_type', 50)->default('direct');
            $table->string('reference_type', 50)->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();
            $table->index('sponsor_id', 'idx_sp_messages_sponsor_id');
            $table->index(['sender_id', 'recipient_id'], 'idx_sp_messages_participants');
            $table->index('read_at', 'idx_sp_messages_read_at');
            $table->index(['reference_type', 'reference_id'], 'idx_sp_messages_reference');
        });

        Schema::create('sponsor_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->nullable()->constrained('sponsors')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('type', 100);
            $table->string('title', 255);
            $table->text('body')->nullable();
            $table->string('icon', 50)->nullable();
            $table->string('color', 50)->nullable();
            $table->string('action_url', 500)->nullable();
            $table->string('action_label', 100)->nullable();
            $table->string('reference_type', 50)->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('dismissed_at')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'read_at'], 'idx_sp_notif_user_read');
            $table->index('sponsor_id', 'idx_sp_notif_sponsor');
            $table->index(['reference_type', 'reference_id'], 'idx_sp_notif_reference');
        });

        // =====================================================================
        // PARTNER CRM WORKSPACE
        // =====================================================================

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
            // Extended fields (2026_07_06_000001)
            $table->string('pincode', 20)->nullable()->after('country');
            $table->string('pan_no', 20)->nullable()->after('tax_id');
            $table->string('designation', 100)->nullable()->after('business_type');
            $table->string('gst_number', 20)->nullable()->after('pan_no');
            $table->boolean('gst_verified')->default(false)->after('gst_number');
            $table->string('gst_legal_name')->nullable()->after('gst_verified');
            $table->timestamp('gst_verified_at')->nullable()->after('gst_legal_name');
            $table->boolean('pan_verified')->default(false)->after('gst_verified_at');
            $table->timestamp('pan_verified_at')->nullable()->after('pan_verified');
            $table->string('official_email')->nullable()->after('website');
            $table->string('social_media_link', 500)->nullable()->after('official_email');
            $table->json('client_references')->nullable()->after('social_media_link');
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

        // =====================================================================
        // ORGANIZER WORKSPACE
        // =====================================================================

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
            // Extended fields (2026_07_06_000001)
            $table->string('pincode', 20)->nullable()->after('country');
            $table->string('pan_no', 20)->nullable()->after('tax_id');
            $table->string('designation', 100)->nullable()->after('business_type');
            $table->string('gst_number', 20)->nullable()->after('pan_no');
            $table->boolean('gst_verified')->default(false)->after('gst_number');
            $table->string('gst_legal_name')->nullable()->after('gst_verified');
            $table->timestamp('gst_verified_at')->nullable()->after('gst_legal_name');
            $table->boolean('pan_verified')->default(false)->after('gst_verified_at');
            $table->timestamp('pan_verified_at')->nullable()->after('pan_verified');
            $table->string('official_email')->nullable()->after('website');
            $table->string('social_media_link', 500)->nullable()->after('official_email');
            $table->json('client_references')->nullable()->after('social_media_link');
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
        $tables = [
            'organizer_check_ins',
            'organizer_post_event_reports',
            'organizer_renewals',
            'organizer_sponsor_relationships',
            'organizer_settings',
            'organizer_profiles',
            'partner_campaigns',
            'partner_activity_logs',
            'partner_tasks',
            'partner_notes',
            'partner_commissions',
            'partner_meetings',
            'partner_deals',
            'partner_leads',
            'partner_assignments',
            'partner_profiles',
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
            'sponsor_notifications',
            'sponsor_messages',
            'sponsor_internal_notes',
            'sponsor_team_members',
            'sponsor_campaign_deliverables',
            'sponsor_campaigns',
            'sponsor_comparison_items',
            'sponsor_comparisons',
            'sponsor_saved_events',
            'sponsor_proposals',
            'sponsor_budgets',
            'partner_payouts',
            'partner_portfolio_items',
            'partner_availability',
            'payments',
            'backlinks',
            'crawl_jobs',
            'search_logs',
            'keywords',
            'post_logs',
            'event_posts',
            'notifications',
            'messages',
            'conversation_participants',
            'conversations',
            'partner_enquiries',
            'partner_city',
            'partner_category',
            'partner_industry',
            'partners',
            'partner_bids',
            'partner_requests',
            'partner_service_reviews',
            'partner_services',
            'sponsorship_contracts',
            'sponsorship_requests',
            'sponsorship_opportunities',
            'sponsorship_benefits',
            'sponsor_packages',
            'sponsors',
            'event_drafts',
            'event_sponsorship_levels',
            'event_audience',
            'event_extras',
            'social_links',
            'organizer_contacts',
            'event_statistics',
            'ticket_types',
            'event_team',
            'event_amenities',
            'event_faqs',
            'event_documents',
            'event_gallery',
            'event_participants',
            'event_schedule',
            'event_stages',
            'event_venues',
            'event_dates',
            'events',
            'participants',
            'plans',
            'industries',
            'age_groups',
            'audience_types',
            'participant_types',
            'amenities',
            'category_field_definitions',
            'categories',
            'redirects',
            'seo_audits',
            'seo_settings',
            'cms_pages',
            'activity_logs',
            'platform_settings',
            'personal_access_tokens',
            'media',
            'failed_jobs',
            'job_batches',
            'jobs',
            'cache_locks',
            'cache',
            'sessions',
            'password_reset_tokens',
            'users',
        ];

        // Drop permission tables dynamically
        $tableNames = config('permission.table_names');
        if ($tableNames) {
            Schema::dropIfExists($tableNames['role_has_permissions']);
            Schema::dropIfExists($tableNames['model_has_roles']);
            Schema::dropIfExists($tableNames['model_has_permissions']);
            Schema::dropIfExists($tableNames['roles']);
            Schema::dropIfExists($tableNames['permissions']);
        }

        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }
    }
};
